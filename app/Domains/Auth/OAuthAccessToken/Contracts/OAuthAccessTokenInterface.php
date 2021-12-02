<?php
namespace App\Domains\Auth\OAuthAccessToken\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface OAuthAccessTokenInterface extends BaseEntityInterface
{
    const TABLE_NAME = 'oauth_access_tokens';
    const MORPH_NAME = 'oauth_access_tokens';

    

    /**
     * Get user_id.
     *
     * @return mixed
     */
    public function getUserId();
    
    /**
     * Set user_id.
     *
     * @param $user_id
     *
     * @return mixed
     */
    public function setUserId($user_id);

    /**
     * Get client_id.
     *
     * @return mixed
     */
    public function getClientId();
    
    /**
     * Set client_id.
     *
     * @param $client_id
     *
     * @return mixed
     */
    public function setClientId($client_id);

    /**
     * Get name.
     *
     * @return mixed
     */
    public function getName();
    
    /**
     * Set name.
     *
     * @param $name
     *
     * @return mixed
     */
    public function setName($name);

    /**
     * Get scopes.
     *
     * @return mixed
     */
    public function getScopes();
    
    /**
     * Set scopes.
     *
     * @param $scopes
     *
     * @return mixed
     */
    public function setScopes($scopes);

    /**
     * Get revoked.
     *
     * @return mixed
     */
    public function getRevoked();
    
    /**
     * Set revoked.
     *
     * @param $revoked
     *
     * @return mixed
     */
    public function setRevoked($revoked);

    /**
     * Get expires_at.
     *
     * @return mixed
     */
    public function getExpiresAt();
    
    /**
     * Set expires_at.
     *
     * @param $expires_at
     *
     * @return mixed
     */
    public function setExpiresAt($expires_at);
}
