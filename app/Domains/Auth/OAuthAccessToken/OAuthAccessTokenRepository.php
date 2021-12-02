<?php

namespace App\Domains\Auth\OAuthAccessToken;

use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenRepositoryInterface;
use App\Infrastructures\Auth\OAuthAccessToken\Contracts\EloquentOAuthAccessTokenRepositoryInterface;
use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class OAuthAccessTokenRepository.
 */
class OAuthAccessTokenRepository extends RepositoryAbstract implements OAuthAccessTokenRepositoryInterface
{
    /**
     * OAuthAccessTokenRepository constructor.
     *
     * @param EloquentOAuthAccessTokenRepositoryInterface $eloquent
     */
    public function __construct(EloquentOAuthAccessTokenRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        return [
            'user_id' => $OAuthAccessToken->getUserId(),
            'client_id' => $OAuthAccessToken->getClientId(),
            'name' => $OAuthAccessToken->getName(),
            'scopes' => $OAuthAccessToken->getScopes(),
            'revoked' => $OAuthAccessToken->getRevoked(),
            'expires_at' => $OAuthAccessToken->getExpiresAt(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        $data = $this->setupPayload($OAuthAccessToken);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        $data = $this->setupPayload($OAuthAccessToken);
       
        return $this->eloquent()->update($data, $OAuthAccessToken->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OAuthAccessTokenInterface $OAuthAccessToken)
    {
        return $this->eloquent()->delete($OAuthAccessToken->getKey());
    }
}
