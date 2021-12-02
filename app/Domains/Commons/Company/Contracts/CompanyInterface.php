<?php

namespace App\Domains\Commons\Company\Contracts;

use App\Domains\Contracts\BaseEntityInterface;
use App\Domains\MediaLibrary\MediaLibraryEloquent;

interface CompanyInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'companies';
    const MORPH_NAME = 'companies';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get company_category_id.
     *
     * @return mixed
     */
    public function getCompanyCategoryId();

    /**
     * Set company_category_id.
     *
     * @param $company_category_id
     *
     * @return mixed
     */
    public function setCompanyCategoryId($company_category_id);

    /**
     * Get employee_number_scale_id.
     *
     * @return mixed
     */
    public function getEmployeeNumberScaleId();

    /**
     * Set employee_number_scale_id.
     *
     * @param $employee_number_scale_id
     *
     * @return mixed
     */
    public function setEmployeeNumberScaleId($employee_number_scale_id);

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
     * @param $latitude
     * @return mixed
     */
    public function setLatitude($latitude);

    /**
     * @return mixed
     */
    public function getLatitude();

    /**
     * @param $longitude
     * @return mixed
     */
    public function setLongitude($longitude);

    /**
     * @return mixed
     */
    public function getLongitude();

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
    public function companyCategory();

    /**
     * @return mixed
     */
    public function employeeNumberScale();

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return mixed
     */
    public function applications();

    /**
     * @return mixed
     */
    public function users();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function positions();

    /**
     * @return mixed
     */
    public function otherTypes();

    /**
     * @return mixed
     */
    public function otherAllowanceTypes();

    /**
     * @return mixed
     */
    public function baseSalaryCustomTypes();

    /**
     * @return mixed
     */
    public function salaryStructures();

    /**
     * @return mixed
     */
    public function vacancies();

    /**
     * @return mixed
     */
    public function projects();

    /**
     * @return mixed
     */
    public function letterTypes();

    /**
     * @return mixed
     */
    public function workUnits();

    /**
     * @return mixed
     */
    public function competences();

    /**
     * @return mixed
     */
    public function workAreas();

    /**
     * @return mixed
     */
    public function offices();

    /**
     * @return mixed
     */
    public function customAllowanceTypes();

    /**
     * @return mixed
     */
    public function employeeLoanTypes();

    /**
     * @return mixed
     */
    public function employees();

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphMediaLibraries();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();

    //</editor-fold>
}
