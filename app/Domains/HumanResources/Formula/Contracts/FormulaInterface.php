<?php
namespace App\Domains\HumanResources\Formula\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface FormulaInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'formulas';
    const MORPH_NAME = 'formulas';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get formula_category_id.
     *
     * @return mixed
     */
    public function getFormulaCategoryId();
    
    /**
     * Set formula_category_id.
     *
     * @param $formula_category_id
     *
     * @return mixed
     */
    public function setFormulaCategoryId($formula_category_id);

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
    public function elements();

    /**
     * @return mixed
     */
    public function formulaResults();

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function formulaCategory();

    //</editor-fold>

    //</editor-fold>
}
