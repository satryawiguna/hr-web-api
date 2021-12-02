<?php
namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface FormalEducationHistoryInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'formal_education_histories';
    const MORPH_NAME = 'formal_education_histories';

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
     * Get degree_id.
     *
     * @return mixed
     */
    public function getDegreeId();
    
    /**
     * Set degree_id.
     *
     * @param $degree_id
     *
     * @return mixed
     */
    public function setDegreeId($degree_id);

    /**
     * Get major_id.
     *
     * @return mixed
     */
    public function getMajorId();
    
    /**
     * Set major_id.
     *
     * @param $major_id
     *
     * @return mixed
     */
    public function setMajorId($major_id);

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

    /**
     * @return mixed
     */
    public function degree();

    /**
     * @return mixed
     */
    public function major();

    //</editor-fold>


    //</editor-fold>
}
