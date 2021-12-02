<?php
namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface WorkCompetenceInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'work_competences';
    const MORPH_NAME = 'work_competences';

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
     * Get competence_id.
     *
     * @return mixed
     */
    public function getCompetenceId();

    /**
     * Set competence_id.
     *
     * @param $competence_id
     *
     * @return mixed
     */
    public function setCompetenceId($competence_id);

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
     * Get validity.
     *
     * @return mixed
     */
    public function getValidity();
    
    /**
     * Set validity.
     *
     * @param $validity
     *
     * @return mixed
     */
    public function setValidity($validity);

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
    public function competence();

    //</editor-fold>

    //</editor-fold>
}
