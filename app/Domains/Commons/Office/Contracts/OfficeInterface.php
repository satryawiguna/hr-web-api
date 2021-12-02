<?php
namespace App\Domains\Commons\Office\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface OfficeInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'offices';
    const MORPH_NAME = 'offices';

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
     * Get type.
     *
     * @return mixed
     */
    public function getType();

    /**
     * Set type.
     *
     * @param $type
     *
     * @return mixed
     */
    public function setType($type);

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
     * Get latitude.
     *
     * @return mixed
     */
    public function getLatitude();
    
    /**
     * Set latitude.
     *
     * @param $latitude
     *
     * @return mixed
     */
    public function setLatitude($latitude);

    /**
     * Get longitude.
     *
     * @return mixed
     */
    public function getLongitude();
    
    /**
     * Set longitude.
     *
     * @param $longitude
     *
     * @return mixed
     */
    public function setLongitude($longitude);

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

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return mixed
     */
    public function users();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function employees();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();


    //</editor-fold>
}
