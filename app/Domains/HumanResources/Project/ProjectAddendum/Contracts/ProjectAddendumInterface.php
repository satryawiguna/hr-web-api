<?php
namespace App\Domains\HumanResources\Project\ProjectAddendum\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ProjectAddendumInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'project_addendums';
    const MORPH_NAME = 'project_addendums';

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
     * Get reference_number.
     *
     * @return mixed
     */
    public function getReferenceNumber();
    
    /**
     * Set reference_number.
     *
     * @param $reference_number
     *
     * @return mixed
     */
    public function setReferenceNumber($reference_number);

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
     * Get issue_date.
     *
     * @return mixed
     */
    public function getIssueDate();
    
    /**
     * Set issue_date.
     *
     * @param $issue_date
     *
     * @return mixed
     */
    public function setIssueDate($issue_date);

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
     * Get is_contract.
     *
     * @return mixed
     */
    public function getIsContract();

    /**
     * Set is_contract.
     *
     * @param $is_contract
     *
     * @return mixed
     */
    public function setIsContract($is_contract);

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

    /**
     * Get modified_by.
     *
     * @return mixed
     */
    public function getProjectAddendumMediaLibraries();

    /**
     * Set modified_by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setProjectAddendumsMediaLibraries($project_addendum_media_libraries);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function project();

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphMediaLibraries();

    //</editor-fold>


    //</editor-fold>
}
