<?php

namespace App\Domains\Auth\OAuthAccessToken;

use App\Domains\ServiceAbstract;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenRepositoryInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenServiceInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenInterface;

/**
 * OAuthAccessTokenService Class
 * It has all useful methods for business logic.
 */
class OAuthAccessTokenService extends ServiceAbstract implements OAuthAccessTokenServiceInterface
{
    /**
     * @var OAuthAccessTokenRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our OAuthAccessTokenInterface
     * OAuthAccessTokenService constructor.
     *
     * @param OAuthAccessTokenRepositoryInterface $repository
     */
    public function __construct(OAuthAccessTokenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        return $this->repository->create($OAuthAccessToken);
    }

    /**
     * {@inheritdoc}
     */
    public function update(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        return $this->repository->update($OAuthAccessToken);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        return $this->repository->delete($OAuthAccessToken);
    }
}
