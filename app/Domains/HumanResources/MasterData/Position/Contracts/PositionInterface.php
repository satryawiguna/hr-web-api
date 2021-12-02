<?php

namespace App\Domains\HumanResources\MasterData\Position\Contracts;

use App\Domains\Contracts\BaseEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface PositionInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'positions';
    const MORPH_NAME = 'positions';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get parent_id.
     *
     * @return mixed
     */
    public function getParentId();

    /**
     * Set parent_id.
     *
     * @param $parent_id
     *
     * @return mixed
     */
    public function setParentId($parent_id);

    /**
     * Get company_id.
     *
     * @return mixed
     */
    public function getCompanyId();

    /**
     * Set company_id.
     *
     * @param $company_id
     *
     * @return mixed
     */
    public function setCompanyId($company_id);

    /**
     * Get code.
     *
     * @return mixed
     */
    public function getCode();

    /**
     * Set code.
     *
     * @param $code
     *
     * @return mixed
     */
    public function setCode($code);

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
    public function company();

    /**
     * @return mixed
     */
    public function positionParent();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function positionChilds();

    /**
     * @return mixed
     */
    public function positionMutations();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();

    /**
     * @param Builder $query
     * @param Model $model
     * @param $attribute
     * @param $config
     * @param $slug
     * @return mixed
     */
    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug);


    //</editor-fold>
}
