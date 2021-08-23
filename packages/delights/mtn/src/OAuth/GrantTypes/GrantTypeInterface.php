<?php
/**
 * GrantTypeInterface.
 */

namespace Delights\Mtn\OAuth\GrantTypes;

/**
 * Interface GrantTypeInterface.
 */
interface GrantTypeInterface
{
    /**
     * Obtain the token data returned by the OAuth2 server.
     *
     * @param string $refreshToken
     *
     * @throws \Delights\Mtn\OAuth\Exceptions\TokenRequestException
     *
     * @return array API token
     */
    public function getToken($refreshToken = null);
}
