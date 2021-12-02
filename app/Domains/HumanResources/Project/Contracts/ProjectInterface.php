<?php

namespace App\Domains\HumanResources\Project\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ProjectInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'projects';
    const MORPH_NAME = 'projects';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get parent_id.
     *
     * @return mixed
     */
    public function getParentId();

    /**
     * Set parent_id.
     *
     * @param $parent_id
     *
     * @return mixed
     */
    public function setParentId($parent_id);

    /**
     * Get company_id.
     *
     * @return mixed
     */
    public function getCompanyId();

    /**
     * Set company_id.
     *
     * @param $company_id
     *
     * @return mixed
     */
    public function setCompanyId($company_id);

    /**
     * Get contract_type_id.
     *
     * @return mixed
     */
    public function getContractTypeId();

    /**
     * Set contract_type_id.
     *
     * @param $contract_type_id
     *
     * @return mixed
     */
    public function setContractTypeId($contract_type_id);

    /**
     * Get reference number.
     *
     * @return mixed
     */
    public function getReferenceNumber();

    /**
     * Set reference number.
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
     * Get first_party_number.
     *
     * @return mixed
     */
    public function getFirstPartyNumber();

    /**
     * Set first_party_number.
     *
     * @param $first_party_number
     *
     * @return mixed
     */
    public function setFirstPartyNumber($first_party_number);

    /**
     * Get second_party_number.
     *
     * @return mixed
     */
    public function getSecondPartyNumber();

    /**
     * Set second_party_nuber.
     *
     * @param $second_party_number
     *
     * @return mixed
     */
    public function setSecondPartyNumber($second_party_number);

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
     * Get activity.
     *
     * @return mixed
     */
    public function getActivity();

    /**
     * Set activity.
     *
     * @param $activity
     *
     * @return mixed
     */
    public function setActivity($activity);

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


    //<editor-fold desc="#custom property">

    /**
     * Get project_media_libraries.
     *
     * @return mixed
     */
    public function getProjectMediaLibraries();

    /**
     * Set project_media_libraries.
     *
     * @param $project_media_libraries
     * @return mixed
     */
    public function setProjectMediaLibraries($project_media_libraries);

    //</editor-fold>

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function projectParent();

    /**
     * @return mixed
     */
    public function company();

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return mixed
     */
    public function workUnits();

    //</editor-fold>


    //<editor-fold desc="#has one relation">

    /**
     * @return mixed
     */
    public function contractType();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function projectChilds();

    /**
     * @return mixed
     */
    public function projectTerms();

    /**
     * @return mixed
     */
    public function projectAddendums();
    
    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphMediaLibraries();

    /**
     * @return mixed
     */
    public function projectMutations();

    //</editor-fold>


    //</editor-fold>
}
