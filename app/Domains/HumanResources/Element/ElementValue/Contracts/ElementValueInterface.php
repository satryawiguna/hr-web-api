<?php
namespace App\Domains\HumanResources\Element\ElementValue\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ElementValueInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'element_values';
    const MORPH_NAME = 'element_values';

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
     * Get code.
     *
     * @return mixed
     */
    public function getCode();
    
    /**
     * Set code.
     *
     * @param $code
     *
     * @return mixed
     */
    public function setCode($code);

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
     * Get seq_no.
     *
     * @return mixed
     */
    public function getSeqNo();
    
    /**
     * Set seq_no.
     *
     * @param $seq_no
     *
     * @return mixed
     */
    public function setSeqNo($seq_no);

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

    /**
     * @return mixed
     */
    public function formulaResults();

    /**
     * @return mixed
     */
    public function elementEntryValues();

    /**
     * @return mixed
     */
    public function payrollBalanceFeeds();

    /**
     * @return mixed
     */
    public function payrollElementValues();

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function element();

    //</editor-fold>


    //</editor-fold>
}
