<?php
namespace App\Domains\HumanResources\Element\ElementEntryValue\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ElementEntryValueInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'element_entry_values';
    const MORPH_NAME = 'element_entry_values';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get element_entry_id.
     *
     * @return mixed
     */
    public function getElementEntryId();
    
    /**
     * Set element_entry_id.
     *
     * @param $element_entry_id
     *
     * @return mixed
     */
    public function setElementEntryId($element_entry_id);

    /**
     * Get element_value_id.
     *
     * @return mixed
     */
    public function getElementValueId();
    
    /**
     * Set element_value_id.
     *
     * @param $element_value_id
     *
     * @return mixed
     */
    public function setElementValueId($element_value_id);

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
     * Get value.
     *
     * @return mixed
     */
    public function getValue();
    
    /**
     * Set value.
     *
     * @param $value
     *
     * @return mixed
     */
    public function setValue($value);

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
    public function elementEntry();

    /**
     * @return mixed
     */
    public function elementValue();

    //</editor-fold>

    //</editor-fold>
}
