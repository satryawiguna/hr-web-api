<?php

namespace App\Domains\Auth\OAuthAccessToken;

use App\Domains\Auth\OAuthAccessToken\Contracts\OAuthAccessTokenInterface;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;

/**
 * OAuthAccessTokenEloquent.
 */
class OAuthAccessTokenEloquent extends EloquentAbstract implements OAuthAccessTokenInterface
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  OAuthAccessTokenInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'name', 'scopes', 'revoked', 'expires_at'
    ];

    protected $searchable = [
        'user_id', 'client_id', 'name', 'scopes', 'revoked', 'expires_at'
    ];

    protected $orderable = [
        'user_id', 'client_id', 'name', 'scopes', 'revoked', 'expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientId()
    {
        return $this->client_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes()
    {
        return $this->scopes;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRevoked()
    {
        return $this->revoked;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRevoked($revoked)
    {
        $this->revoked = $revoked;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(UserEloquent::class, 'user_id');
    }
}
