<?php
namespace App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface NonFormalEducationHistoryInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'non_formal_education_histories';
    const MORPH_NAME = 'non_formal_education_histories';

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
     * Get institution.
     *
     * @return mixed
     */
    public function getInstitution();
    
    /**
     * Set institution.
     *
     * @param $institution
     *
     * @return mixed
     */
    public function setInstitution($institution);

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
