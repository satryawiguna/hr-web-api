<?php


namespace App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class CreateProjectAddendumRequest extends AuditableRequest
{
    public $project_id;

    public $reference_number;

    public $name;

    public $issue_date;

    public $start_date;

    public $end_date;

    public $description;

    public $value;

    public $is_contract;

    public $media_libraries;

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * @param mixed $project_id
     */
    public function setProjectId($project_id): void
    {
        $this->project_id = $project_id;
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
}
