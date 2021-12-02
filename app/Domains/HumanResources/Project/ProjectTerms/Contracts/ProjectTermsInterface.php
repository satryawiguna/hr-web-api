<?php
namespace App\Domains\HumanResources\Project\ProjectTerms\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ProjectTermsInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'project_terms';
    const MORPH_NAME = 'project_terms';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get project_id.
     *
     * @return mixed
     */
    public function getProjectId();
    
    /**
     * Set project_id.
     *
     * @param $project_id
     *
     * @return mixed
     */
    public function setProjectId($project_id);

    /**
     * Get step.
     *
     * @return mixed
     */
    public function getStep();
    
    /**
     * Set step.
     *
     * @param $step
     *
     * @return mixed
     */
    public function setStep($step);

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


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function project();

    //</editor-fold>


    //</editor-fold>
}
