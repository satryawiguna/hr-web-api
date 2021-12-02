<?php


namespace App\Domains\HumanResources\Project\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class CreateProjectRequest extends AuditableRequest
{
    public $parent_id;

    public $company_id;

    public $contract_type_id;

    public $reference_number;

    public $name;

    public $first_party_number;

    public $second_party_number;

    public $issue_date;

    public $start_date;

    public $end_date;

    public $activity;

    public $description;

    public $value;

    public $is_contract;

    public $media_libraries;

    // Has many
    public $project_addendums;

    public $project_terms;

    // Attach
    public $work_units;

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id): void
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getContractTypeId()
    {
        return $this->contract_type_id;
    }

    /**
     * @param mixed $contract_type_id
     */
    public function setContractTypeId($contract_type_id): void
    {
        $this->contract_type_id = $contract_type_id;
    }

    /**
     * @return mixed
     */
    public function getReferenceNumber()
    {
        return $this->reference_number;
    }

    /**
     * @param mixed $reference_number
     */
    public function setReferenceNumber($reference_number): void
    {
        $this->reference_number = $reference_number;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstPartyNumber()
    {
        return $this->first_party_number;
    }

    /**
     * @param mixed $first_party_number
     */
    public function setFirstPartyNumber($first_party_number): void
    {
        $this->first_party_number = $first_party_number;
    }

    /**
     * @return mixed
     */
    public function getSecondPartyNumber()
    {
        return $this->second_party_number;
    }

    /**
     * @param mixed $second_party_number
     */
    public function setSecondPartyNumber($second_party_number): void
    {
        $this->second_party_number = $second_party_number;
    }

    /**
     * @return mixed
     */
    public function getIssueDate()
    {
        return $this->issue_date;
    }

    /**
     * @param mixed $issue_date
     */
    public function setIssueDate($issue_date): void
    {
        $this->issue_date = $issue_date;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date): void
    {
        $this->end_date = $end_date;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getIsContract()
    {
        return $this->is_contract;
    }

    /**
     * @param mixed $is_contract
     */
    public function setIsContract($is_contract): void
    {
        $this->is_contract = $is_contract;
    }

    /**
     * @return mixed
     */
    public function getMediaLibraries()
    {
        return $this->media_libraries;
    }

    /**
     * @param mixed $media_libraries
     */
    public function setMediaLibraries($media_libraries): void
    {
        $this->media_libraries = $media_libraries;
    }

    /**
     * @return mixed
     */
    public function getProjectAddendums()
    {
        return $this->project_addendums;
    }

    /**
     * @param mixed $project_addendums
     */
    public function setProjectAddendums($project_addendums): void
    {
        $this->project_addendums = $project_addendums;
    }

    /**
     * @return mixed
     */
    public function getProjectTerms()
    {
        return $this->project_terms;
    }

    /**
     * @param mixed $project_terms
     */
    public function setProjectTerms($project_terms): void
    {
        $this->project_terms = $project_terms;
    }

    /**
     * @return mixed
     */
    public function getWorkUnits()
    {
        return $this->work_units;
    }

    /**
     * @param mixed $work_units
     */
    public function setWorkUnits($work_units): void
    {
        $this->work_units = $work_units;
    }
}
