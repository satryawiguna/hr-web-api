<?php
namespace App\Domains\HumanResources\Element\ElementEntry\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ElementEntryInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'element_entries';
    const MORPH_NAME = 'element_entries';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get element_id.
     *
     * @return mixed
     */
    public function getElementId();
    
    /**
     * Set element_id.
     *
     * @param $element_id
     *
     * @return mixed
     */
    public function setElementId($element_id);

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
     * Get efective_start_date.
     *
     * @return mixed
     */
    public function getEfectiveStartDate();
    
    /**
     * Set efective_start_date.
     *
     * @param $efective_start_date
     *
     * @return mixed
     */
    public function setEfectiveStartDate($efective_start_date);

    /**
     * Get efective_end_date.
     *
     * @return mixed
     */
    public function getEfectiveEndDate();
    
    /**
     * Set efective_end_date.
     *
     * @param $efective_end_date
     *
     * @return mixed
     */
    public function setEfectiveEndDate($efective_end_date);

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

    public function elementEntryValues();

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function employee();

    //</editor-fold>

    //</editor-fold>
}
