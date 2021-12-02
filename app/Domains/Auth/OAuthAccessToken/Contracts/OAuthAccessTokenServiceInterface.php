<?php

namespace App\Domains\Auth\OAuthAccessToken\Contracts;

/**
 * Interface OAuthAccessTokenServiceInterface.
 */
interface OAuthAccessTokenServiceInterface
{
    /**
     * OAuthAccessTokenServiceInterface constructor.
     *
     * @param OAuthAccessTokenRepositoryInterface $repository
     */
    public function __construct(OAuthAccessTokenRepositoryInterface $repository);

    /**
     * Create OAuthAccessToken.
     *
     * @param OAuthAccessTokenInterface $OAuthAccessToken
     *
     * @return mixed
     */
    public function create(OAuthAccessTokenInterface $OAuthAccessToken);

    /**
     * Update OAuthAccessToken.
     *
     * @param OAuthAccessTokenInterface $OAuthAccessToken
     *
     * @return mixed
     */
    public function update(OAuthAccessTokenInterface $OAuthAccessToken);

    /**
     * Delete OAuthAccessToken.
     *
     * @param OAuthAccessTokenInterface $OAuthAccessToken
     *
     * @return mixed
     */
    public function delete(OAuthAccessTokenInterface $OAuthAccessToken);

    /**
     * Get OAuthAccessToken.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * Lists OAuthAccessTokens.
     *
     * @return mixed
     */
    public function lists();
}
