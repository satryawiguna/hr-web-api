<?php
namespace App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request;


use App\Core\Services\Request\AuditableRequest;

class CreateWorkAgreementLetterRequest extends AuditableRequest
{
    public $employee_id;

    public $letter_type_id;

    public $reference_number;

    public $start_date;

    public $end_date;

    public $media_libraries;

    /**
     * @return mixed
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * @param mixed $employee_id
     */
    public function setEmployeeId($employee_id): void
    {
        $this->employee_id = $employee_id;
    }

    /**
     * @return mixed
     */
    public function getLetterTypeId()
    {
        return $this->letter_type_id;
    }

    /**
     * @param mixed $letter_type_id
     */
    public function setLetterTypeId($letter_type_id): void
    {
        $this->letter_type_id = $letter_type_id;
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