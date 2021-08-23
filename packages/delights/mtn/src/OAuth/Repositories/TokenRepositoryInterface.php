<?php
/**
 * TokenRepositoryInterface.
 */

namespace Delights\Mtn\OAuth\Repositories;

/**
 * Interface TokenRepositoryInterface.
 */
interface TokenRepositoryInterface
{
    /**
     * Create token.
     *
     * @param array $attributes
     *
     * @return \Delights\Mtn\OAuth\Models\TokenInterface Token created.
     */
    public function create(array $attributes);

    /**
     * Retrieve token.
     *
     * Specified token, or any token available in storage.
     *
     * @param string $access_token
     *
     * @throws \Delights\Mtn\OAuth\Exceptions\TokenNotFoundException
     *
     * @return \Delights\Mtn\OAuth\Models\TokenInterface|null Token, null if non found.
     */
    public function retrieve($access_token = null);

    /**
     * Updates token.
     *
     * @param mixed $access_token
     * @param array $attributes
     *
     * @throws \Delights\Mtn\OAuth\Exceptions\TokenNotFoundException
     *
     * @return \Delights\Mtn\OAuth\Models\TokenInterface Token
     */
    public function update($access_token, array $attributes);

    /**
     * Destroy token.
     *
     * @param string $access_token
     *
     * @throws \Delights\Mtn\OAuth\Exceptions\TokenNotFoundException
     *
     * @return void
     */
    public function delete($access_token);
}
