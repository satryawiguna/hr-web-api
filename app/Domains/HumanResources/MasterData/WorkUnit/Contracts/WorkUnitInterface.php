<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit\Contracts;

use App\Domains\Contracts\BaseEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface WorkUnitInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'work_units';
    const MORPH_NAME = 'work_units';

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
     * Get title.
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Set title.
     *
     * @param $title
     *
     * @return mixed
     */
    public function setTitle($title);

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
     * Get country.
     *
     * @return mixed
     */
    public function getCountry();

    /**
     * Set country.
     *
     * @param $country
     *
     * @return mixed
     */
    public function setCountry($country);

    /**
     * Get state_or_province.
     *
     * @return mixed
     */
    public function getStateOrProvince();

    /**
     * Set state_or_province.
     *
     * @param $state_or_province
     *
     * @return mixed
     */
    public function setStateOrProvince($state_or_province);

    /**
     * Get city.
     *
     * @return mixed
     */
    public function getCity();

    /**
     * Set city.
     *
     * @param $city
     *
     * @return mixed
     */
    public function setCity($city);

    /**
     * Get address.
     *
     * @return mixed
     */
    public function getAddress();

    /**
     * Set address.
     *
     * @param $address
     *
     * @return mixed
     */
    public function setAddress($address);

    /**
     * Get postcode.
     *
     * @return mixed
     */
    public function getPostcode();

    /**
     * Set postcode.
     *
     * @param $postcode
     *
     * @return mixed
     */
    public function setPostcode($postcode);

    /**
     * Get phone.
     *
     * @return mixed
     */
    public function getPhone();

    /**
     * Set phone.
     *
     * @param $phone
     *
     * @return mixed
     */
    public function setPhone($phone);

    /**
     * Get fax.
     *
     * @return mixed
     */
    public function getFax();

    /**
     * Set fax.
     *
     * @param $fax
     *
     * @return mixed
     */
    public function setFax($fax);

    /**
     * Get email.
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param $email
     *
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Get url.
     *
     * @return mixed
     */
    public function getUrl();

    /**
     * Set url.
     *
     * @param $url
     *
     * @return mixed
     */
    public function setUrl($url);

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
    public function workUnitParent();

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    public function projects();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function workUnitChilds();

    /**
     * @return mixed
     */
    public function workUnitMutations();

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
