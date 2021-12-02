<?php
namespace App\Domains\HumanResources\Vacancy\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface VacancyInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'vacancies';
    const MORPH_NAME = 'vacancies';

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
     * Get vacancy_location_id.
     *
     * @return mixed
     */
    public function getVacancyLocationId();
    
    /**
     * Set vacancy_location_id.
     *
     * @param $vacancy_location_id
     *
     * @return mixed
     */
    public function setVacancyLocationId($vacancy_location_id);

    /**
     * Get vacancy_category_id .
     *
     * @return mixed
     */
    public function getVacancyCategoryId();
    
    /**
     * Set vacancy_category_id .
     *
     * @param $vacancy_category_id 
     *
     * @return mixed
     */
    public function setVacancyCategoryId($vacancy_category_id );

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
     * Get publish_date.
     *
     * @return mixed
     */
    public function getPublishDate();
    
    /**
     * Set publish_date.
     *
     * @param $publish_date
     *
     * @return mixed
     */
    public function setPublishDate($publish_date);

    /**
     * Get expired_date.
     *
     * @return mixed
     */
    public function getExpiredDate();
    
    /**
     * Set expired_date.
     *
     * @param $expired_date
     *
     * @return mixed
     */
    public function setExpiredDate($expired_date);

    /**
     * Get min_salary.
     *
     * @return mixed
     */
    public function getMinSalary();
    
    /**
     * Set min_salary.
     *
     * @param $min_salary
     *
     * @return mixed
     */
    public function setMinSalary($min_salary);

    /**
     * Get max_salary.
     *
     * @return mixed
     */
    public function getMaxSalary();
    
    /**
     * Set max_salary.
     *
     * @param $max_salary
     *
     * @return mixed
     */
    public function setMaxSalary($max_salary);

    /**
     * Get reference_code.
     *
     * @return mixed
     */
    public function getReferenceCode();

    /**
     * Set reference_code.
     *
     * @param $reference_code
     *
     * @return mixed
     */
    public function setReferenceCode($reference_code);

    /**
     * Get intro.
     *
     * @return mixed
     */
    public function getIntro();
    
    /**
     * Set intro.
     *
     * @param $intro
     *
     * @return mixed
     */
    public function setIntro($intro);

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
     * Get requirement.
     *
     * @return mixed
     */
    public function getRequirement();
    
    /**
     * Set requirement.
     *
     * @param $requirement
     *
     * @return mixed
     */
    public function setRequirement($requirement);

    /**
     * Get needs.
     *
     * @return mixed
     */
    public function getNeeds();
    
    /**
     * Set needs.
     *
     * @param $needs
     *
     * @return mixed
     */
    public function setNeeds($needs);

    /**
     * Get work_status.
     *
     * @return mixed
     */
    public function getWorkStatus();
    
    /**
     * Set work_status.
     *
     * @param $work_status
     *
     * @return mixed
     */
    public function setWorkStatus($work_status);

    /**
     * Get work_type.
     *
     * @return mixed
     */
    public function getWorkType();
    
    /**
     * Set work_type.
     *
     * @param $work_type
     *
     * @return mixed
     */
    public function setWorkType($work_type);

    /**
     * Get status.
     *
     * @return mixed
     */
    public function getStatus();
    
    /**
     * Set status.
     *
     * @param $status
     *
     * @return mixed
     */
    public function setStatus($status);

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

    //<editor-fold desc="#has many relation">

    public function applicant();

    public function degree();

    public function skill();

    public function additionalQuestion();

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    public function company();

    public function vacancyLocation();

    public function vacancyCategory();

    //</editor-fold>

    //</editor-fold>
}
