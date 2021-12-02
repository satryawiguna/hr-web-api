<?php
namespace App\Domains\User\Profile\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ProfileInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'profiles';
    const MORPH_NAME = 'profiles';

    //</editor-fold>


    //<editor-fold desc="#property">

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
     * Get full_name.
     *
     * @return mixed
     */
    public function getFullName();
    
    /**
     * Set full_name.
     *
     * @param $full_name
     *
     * @return mixed
     */
    public function setFullName($full_name);

    /**
     * Get nick_name.
     *
     * @return mixed
     */
    public function getNickName();
    
    /**
     * Set nick_name.
     *
     * @param $nick_name
     *
     * @return mixed
     */
    public function setNickName($nick_name);

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
     * Get mobile.
     *
     * @return mixed
     */
    public function getMobile();
    
    /**
     * Set mobile.
     *
     * @param $mobile
     *
     * @return mixed
     */
    public function setMobile($mobile);

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
    public function user();

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphMediaLibraries();

    //</editor-fold>


    //</editor-fold>
}
