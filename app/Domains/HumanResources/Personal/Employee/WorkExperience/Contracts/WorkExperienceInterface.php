<?php
namespace App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface WorkExperienceInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'work_experiences';
    const MORPH_NAME = 'work_experiences';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get employee_id.
     *
     * @return mixed
     */
    public function getEmployeeId();
    
    /**
     * Set employee_id.
     *
     * @param $employee_id
     *
     * @return mixed
     */
    public function setEmployeeId($employee_id);

    /**
     * Get company.
     *
     * @return mixed
     */
    public function getCompany();
    
    /**
     * Set company.
     *
     * @param $company
     *
     * @return mixed
     */
    public function setCompany($company);

    /**
     * Get business_type.
     *
     * @return mixed
     */
    public function getBusinessType();
    
    /**
     * Set business_type.
     *
     * @param $business_type
     *
     * @return mixed
     */
    public function setBusinessType($business_type);

    /**
     * Get position.
     *
     * @return mixed
     */
    public function getPosition();
    
    /**
     * Set position.
     *
     * @param $position
     *
     * @return mixed
     */
    public function setPosition($position);

    /**
     * Get start_date.
     *
     * @return mixed
     */
    public function getStartDate();
    
    /**
     * Set start_date.
     *
     * @param $start_date
     *
     * @return mixed
     */
    public function setStartDate($start_date);

    /**
     * Get end_date.
     *
     * @return mixed
     */
    public function getEndDate();

    /**
     * Set end_date.
     *
     * @param $end_date
     *
     * @return mixed
     */
    public function setEndDate($end_date);

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
    public function employee();

    //</editor-fold>

    //</editor-fold>
}
