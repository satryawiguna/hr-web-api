<?php
namespace App\Domains\HumanResources\Element\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ElementInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'elements';
    const MORPH_NAME = 'elements';

    //</editor-fold>


    //<editor-fold desc="#property">

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
     * Get formula_id.
     *
     * @return mixed
     */
    public function getFormulaId();
    
    /**
     * Set formula_id.
     *
     * @param $formula_id
     *
     * @return mixed
     */
    public function setFormulaId($formula_id);

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
    public function elementValues();

    /**
     * @return mixed
     */
    public function elementEntries();

    /**
     * @return mixed
     */
    public function formulaResults();

    /**
     * @return mixed
     */
    public function payrollBalanceFeeds();

    /**
     * @return mixed
     */
    public function payrollElements();

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return mixed
     */
    public function formulas();

    //</editor-fold>

    //</editor-fold>
}
