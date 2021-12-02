<?php
namespace App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts;

use App\Domains\Contracts\BaseEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface RecruitmentStageInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">
    
    const TABLE_NAME = 'recruitment_stages';
    const MORPH_NAME = 'recruitment_stages';

    //</editor-fold>


    //<editor-fold desc="#property">

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
     * Get color.
     *
     * @return mixed
     */
    public function getColor();
    
    /**
     * Set color.
     *
     * @param $color
     *
     * @return mixed
     */
    public function setColor($color);

    /**
     * Get sort_order.
     *
     * @return mixed
     */
    public function getSortOrder();
    
    /**
     * Set sort_order.
     *
     * @param $sort_order
     *
     * @return mixed
     */
    public function setSortOrder($sort_order);

    /**
     * Get is_scheduled.
     *
     * @return mixed
     */
    public function getIsScheduled();
    
    /**
     * Set is_scheduled.
     *
     * @param $is_scheduled
     *
     * @return mixed
     */
    public function setIsScheduled($is_scheduled);

    /**
     * Get is_init.
     *
     * @return mixed
     */
    public function getIsInit();
    
    /**
     * Set is_init.
     *
     * @param $is_init
     *
     * @return mixed
     */
    public function setIsInit($is_init);

    /**
     * Get is_hired.
     *
     * @return mixed
     */
    public function getIsHired();
    
    /**
     * Set is_hired.
     *
     * @param $is_hired
     *
     * @return mixed
     */
    public function setIsHired($is_hired);

    /**
     * Get is_reject.
     *
     * @return mixed
     */
    public function getIsReject();
    
    /**
     * Set is_reject.
     *
     * @param $is_reject
     *
     * @return mixed
     */
    public function setIsReject($is_reject);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function company();

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    //</editor-fold>


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
