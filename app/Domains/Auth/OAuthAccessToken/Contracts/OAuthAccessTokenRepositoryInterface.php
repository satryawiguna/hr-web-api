<?php

namespace App\Domains\Auth\OAuthAccessToken\Contracts;

use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Auth\OAuthAccessToken\Contracts\EloquentOAuthAccessTokenRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface OAuthAccessTokenRepositoryInterface.
 */
interface OAuthAccessTokenRepositoryInterface
{
    /**
     * OAuthAccessTokenRepositoryInterface constructor.
     *
     * @param EloquentOAuthAccessTokenRepositoryInterface $eloquent
     */
    public function __construct(EloquentOAuthAccessTokenRepositoryInterface $eloquent);

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
}
