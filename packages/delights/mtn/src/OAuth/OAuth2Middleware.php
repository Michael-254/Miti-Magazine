<?php
/**
 * OAuth2Middleware.
 */

namespace Delights\Mtn\OAuth;

use Delights\Mtn\OAuth\Exceptions\TokenRequestException;
use Delights\Mtn\OAuth\Repositories\FileTokenRepository;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;

/**
 * Class OAuth2Middleware.
 */
class OAuth2Middleware
{
    /**
     * Primary grant type.
     *
     * @var \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface
     */
    protected $grantType;

    /**
     * Refresh token (secondary) grant type.
     *
     * @var \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface
     */
    protected $refreshTokenGrantType;

    /**
     * Token repository.
     *
     * @var \Delights\Mtn\OAuth\Repositories\TokenRepositoryInterface
     */
    protected $tokenRepository;

    /**
     * Token model.
     *
     * @var \Delights\Mtn\OAuth\Models\TokenInterface
     */
    protected $token;

    /**
     * Get main grant type.
     *
     * @return \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * Set main grant type.
     *
     * @param \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface $grantType
     */
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    /**
     * Get refresh token grant type.
     *
     * @return \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface
     */
    public function getRefreshTokenGrantType()
    {
        return $this->refreshTokenGrantType;
    }

    /**
     * Set refresh token grant type.
     *
     * @param \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface $refreshTokenGrantType
     */
    public function setRefreshTokenGrantType($refreshTokenGrantType)
    {
        $this->refreshTokenGrantType = $refreshTokenGrantType;
    }

    /**
     * Set token.
     *
     * @param \Delights\Mtn\OAuth\Models\TokenInterface $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get a valid access token.
     *
     * @throws TokenRequestException
     *
     * @return \Delights\Mtn\OAuth\Models\TokenInterface|null
     */
    public function getToken()
    {
        // If token is not set try to get it from the persistent storage.
        if ($this->token === null) {
            $this->token = $this->tokenRepository->retrieve();
        }

        // If storage token is not set or expired then try to acquire a new one...
        if ($this->token === null || $this->token->isExpired()) {

            // Hydrate `rawToken` with a new access token
            $this->token = $this->requestNewToken();
        }

        return $this->token;
    }

    /**
     * Set token repository.
     *
     * @param \Delights\Mtn\OAuth\Repositories\TokenRepositoryInterface $tokenRepository
     */
    public function setTokenRepository($tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Get token repository.
     *
     * @return \Delights\Mtn\OAuth\Repositories\TokenRepositoryInterface
     */
    public function getTokenRepository()
    {
        return $this->tokenRepository;
    }

    /**
     * Constructor.
     *
     * @param \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface         $grantType
     * @param \Delights\Mtn\OAuth\GrantTypes\GrantTypeInterface         $refreshTokenGrantType
     * @param \Delights\Mtn\OAuth\Repositories\TokenRepositoryInterface $tokenRepository
     */
    public function __construct($grantType, $refreshTokenGrantType = null, $tokenRepository = null)
    {
        $this->grantType = $grantType;
        $this->refreshTokenGrantType = $refreshTokenGrantType;
        $this->tokenRepository = ($tokenRepository) ? $tokenRepository : new FileTokenRepository();
    }

    /**
     * Guzzle middleware invocation.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            if (!$request->hasHeader('Authorization')) {
                $request = $this->signRequest($request, $this->getToken());
            }

            return $handler($request, $options)->then(
                $this->onFulfilled($request, $options, $handler),
                $this->onRejected($request, $options, $handler)
            );
        };
    }

    /**
     * Request error event handler.
     *
     * Handles unauthorized errors by acquiring a new access token and retrying the request.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     * @param callable                           $handler
     *
     * @return \Closure
     */
    private function onFulfilled(RequestInterface $request, array $options, callable $handler)
    {
        return function ($response) use ($request, $options, $handler) {
            // Only deal with Unauthorized response.
            if ($response && $response->getStatusCode() != 401) {
                return $response;
            }

            // If we already retried once, give up.
            if ($request->hasHeader('X-Guzzle-Retry')) {
                return $response;
            }

            // Delete the previous access token, if any
            $this->tokenRepository->delete($this->token->getAccessToken());

            // Unset current token
            $this->token = null;

            // Acquire a new access token, and retry the request.
            $this->token = $this->getToken();
            if ($this->token === null) {
                return $response;
            }

            $request = $request->withHeader('X-Guzzle-Retry', 1);

            $request = $this->signRequest($request, $this->token);

            return $handler($request, $options);
        };
    }

    /**
     * When request is rejected.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     * @param callable                           $handler
     *
     * @return \Closure
     */
    private function onRejected(RequestInterface $request, array $options, callable $handler)
    {
        return function ($reason) {
            return \GuzzleHttp\Promise\rejection_for($reason);
        };
    }

    /**
     * Add auth headers.
     *
     * @param \Psr\Http\Message\RequestInterface             $request
     * @param \Delights\Mtn\OAuth\Models\TokenInterface $token
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function signRequest(RequestInterface $request, $token)
    {
        if ($token === null) {
            return $request;
        }

        return $request->withHeader('Authorization', $this->token->getTokenType().' '.$this->token->getAccessToken());
    }

    /**
     * Acquire a new access token from the oauth2 server.
     *
     * @throws \Delights\Mtn\OAuth\Exceptions\TokenRequestException
     *
     * @return \Delights\Mtn\OAuth\Models\TokenInterface
     */
    protected function requestNewToken()
    {
        try {
            // Refresh an existing, but expired access token.
            if ($this->refreshTokenGrantType && $this->token && $this->token->getRefreshToken()) {
                // Request new access token using the existing refresh token.
                $api_token = $this->refreshTokenGrantType->getToken($this->token->getRefreshToken());

                return $this->tokenRepository->create($api_token);
            }

            // Obtain new access token using the main grant type.
            $api_token = $this->grantType->getToken();

            return $this->tokenRepository->create($api_token);
        } catch (RequestException $ex) {
            throw new TokenRequestException('Unable to obtain a new access token.', 0, $ex->getPrevious());
        }
    }
}
