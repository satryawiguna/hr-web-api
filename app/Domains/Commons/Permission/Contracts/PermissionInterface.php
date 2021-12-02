<?php
namespace App\Domains\Commons\Permission\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface PermissionInterface extends BaseEntityInterface
{
    const TABLE_NAME = 'permissions';
    const MORPH_NAME = 'permissions';

    

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
     * Get slug.
     *
     * @return mixed
     */
    public function getSlug();
    
    /**
     * Set slug.
     *
     * @param $slug
     *
     * @return mixed
     */
    public function setSlug($slug);

    /**
     * Get server.
     *
     * @return mixed
     */
    public function getServer();
    
    /**
     * Set server.
     *
     * @param $server
     *
     * @return mixed
     */
    public function setServer($server);

    /**
     * Get path.
     *
     * @return mixed
     */
    public function getPath();
    
    /**
     * Set path.
     *
     * @param $path
     *
     * @return mixed
     */
    public function setPath($path);

    /**
     * Get description.
     *
     * @return mixed
     */
    public function getDescription();
    
    /**
     * Set description.
     *
     * @param $description
     *
     * @return mixed
     */
    public function setDescription($description);

    /**
     * Get is_active.
     *
     * @return mixed
     */
    public function getIsActive();
    
    /**
     * Set is_active.
     *
     * @param $is_active
     *
     * @return mixed
     */
    public function setIsActive($is_active);

    /**
     * Get created_by.
     *
     * @return mixed
     */
    public function getCreatedBy();
    
    /**
     * Set created_by.
     *
     * @param $created_by
     *
     * @return mixed
     */
    public function setCreatedBy($created_by);

    /**
     * Get modified_by.
     *
     * @return mixed
     */
    public function getModifiedBy();
    
    /**
     * Set modified_by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setModifiedBy($modified_by);

    /**
     * @return mixed
     */
    public function users();

    /**
     * @return mixed
     */
    public function accesses();

    /**
     * @return mixed
     */
    public function roles();
}
