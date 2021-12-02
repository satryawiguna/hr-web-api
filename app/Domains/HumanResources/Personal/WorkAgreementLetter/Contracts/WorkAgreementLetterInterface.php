<?php
namespace App\Domains\WorkAgreementLetter\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface WorkAgreementLetterInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'work_agreement_letters';
    const MORPH_NAME = 'work_agreement_letters';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get employee_id.
     *
     * @return mixed
     */
    public function getEmployeeId();
    
    /**
     * Set employee_id.
     *
     * @param $employee_id
     *
     * @return mixed
     */
    public function setEmployeeId($employee_id);

    /**
     * Get letter_type_id.
     *
     * @return mixed
     */
    public function getLetterTypeId();
    
    /**
     * Set letter_type_id.
     *
     * @param $letter_type_id
     *
     * @return mixed
     */
    public function setLetterTypeId($letter_type_id);

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
    public function employee();

    /**
     * @return mixed
     */
    public function letterType();

    //</editor-fold>

    //</editor-fold>
}
