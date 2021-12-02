<?php

namespace App\Domains\Commons\Role\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface RoleInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'roles';
    const MORPH_NAME = 'roles';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get group_id.
     *
     * @return mixed
     */
    public function getGroupId();

    /**
     * Set group_id.
     *
     * @param $group_id
     *
     * @return mixed
     */
    public function setGroupId($group_id);

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

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function group();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function users();

    /**
     * @return mixed
     */
    public function permissions();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();


    //</editor-fold>
}
