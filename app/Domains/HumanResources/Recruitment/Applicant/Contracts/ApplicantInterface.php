<?php
namespace App\Domains\HumanResources\Recruitment\Applicant\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ApplicantInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'applicants';
    const MORPH_NAME = 'applicants';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get profile_id.
     *
     * @return mixed
     */
    public function getProfileId();
    
    /**
     * Set profile_id.
     *
     * @param $profile_id
     *
     * @return mixed
     */
    public function setProfileId($profile_id);

    /**
     * Get gender_id.
     *
     * @return mixed
     */
    public function getGenderId();
    
    /**
     * Set gender_id.
     *
     * @param $gender_id
     *
     * @return mixed
     */
    public function setGenderId($gender_id);

    /**
     * Get religion_id.
     *
     * @return mixed
     */
    public function getReligionId();
    
    /**
     * Set religion_id.
     *
     * @param $religion_id
     *
     * @return mixed
     */
    public function setReligionId($religion_id);

    /**
     * Get marital_status_id.
     *
     * @return mixed
     */
    public function getMaritalStatusId();
    
    /**
     * Set marital_status_id.
     *
     * @param $marital_status_id
     *
     * @return mixed
     */
    public function setMaritalStatusId($marital_status_id);

    /**
     * Get identity_number.
     *
     * @return mixed
     */
    public function getIdentityNumber();

    /**
     * Set identity_number.
     *
     * @param $identity_number
     *
     * @return mixed
     */
    public function setIdentityNumber($identity_number);

    /**
     * Get identity_expired_date.
     *
     * @return mixed
     */
    public function getIdentityExpiredDate();

    /**
     * Set identity_expired_date.
     *
     * @param $identity_expired_date
     *
     * @return mixed
     */
    public function setIdentityExpiredDate($identity_expired_date);

    /**
     * Get identity_address.
     *
     * @return mixed
     */
    public function getIdentityAddress();

    /**
     * Set identity_address.
     *
     * @param $identity_address
     *
     * @return mixed
     */
    public function setIdentityAddress($identity_address);
    
    /**
     * Get passport_number.
     *
     * @return mixed
     */
    public function getPassportNumber();

    /**
     * Set passport_number.
     *
     * @param $passport_number
     *
     * @return mixed
     */
    public function setPassportNumber($passport_number);

    /**
     * Get passport_expired_date.
     *
     * @return mixed
     */
    public function getPassportExpiredDate();

    /**
     * Set passport_expired_date.
     *
     * @param $passport_expired_date
     *
     * @return mixed
     */
    public function setPassportExpiredDate($passport_expired_date);

    /**
     * Get visa_number.
     *
     * @return mixed
     */
    public function getVisaNumber();

    /**
     * Set visa_number.
     *
     * @param $visa_number
     *
     * @return mixed
     */
    public function setVisaNumber($visa_number);

    /**
     * Get visa_expired_date.
     *
     * @return mixed
     */
    public function getVisaExpiredDate();

    /**
     * Set visa_expired_date.
     *
     * @param $visa_expired_date
     *
     * @return mixed
     */
    public function setVisaExpiredDate($visa_expired_date);

    /**
     * Get birth_date.
     *
     * @return mixed
     */
    public function getBirthDate();
    
    /**
     * Set birth_date.
     *
     * @param $birth_date
     *
     * @return mixed
     */
    public function setBirthDate($birth_date);

    /**
     * Get birth_place.
     *
     * @return mixed
     */
    public function getBirthPlace();
    
    /**
     * Set birth_place.
     *
     * @param $birth_place
     *
     * @return mixed
     */
    public function setBirthPlace($birth_place);

    /**
     * Get age.
     *
     * @return mixed
     */
    public function getAge();
    
    /**
     * Set age.
     *
     * @param $age
     *
     * @return mixed
     */
    public function setAge($age);

    /**
     * Get weight.
     *
     * @return mixed
     */
    public function getWeight();
    
    /**
     * Set weight.
     *
     * @param $weight
     *
     * @return mixed
     */
    public function setWeight($weight);

    /**
     * Get height.
     *
     * @return mixed
     */
    public function getHeight();
    
    /**
     * Set height.
     *
     * @param $height
     *
     * @return mixed
     */
    public function setHeight($height);

    /**
     * Get linkedin.
     *
     * @return mixed
     */
    public function getLinkedin();
    
    /**
     * Set linkedin.
     *
     * @param $linkedin
     *
     * @return mixed
     */
    public function setLinkedin($linkedin);

    /**
     * Get facebook.
     *
     * @return mixed
     */
    public function getFacebook();
    
    /**
     * Set facebook.
     *
     * @param $facebook
     *
     * @return mixed
     */
    public function setFacebook($facebook);

    /**
     * Get instagram.
     *
     * @return mixed
     */
    public function getInstagram();
    
    /**
     * Set instagram.
     *
     * @param $instagram
     *
     * @return mixed
     */
    public function setInstagram($instagram);

    /**
     * Get skype.
     *
     * @return mixed
     */
    public function getSkype();
    
    /**
     * Set skype.
     *
     * @param $skype
     *
     * @return mixed
     */
    public function setSkype($skype);

    /**
     * Get website.
     *
     * @return mixed
     */
    public function getWebsite();
    
    /**
     * Set website.
     *
     * @param $website
     *
     * @return mixed
     */
    public function setWebsite($website);

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
    public function profile();

    /**
     * @return mixed
     */
    public function gender();

    /**
     * @return mixed
     */
    public function religion();

    /**
     * @return mixed
     */
    public function maritalStatus();

    //</editor-fold>

    //</editor-fold>
}
