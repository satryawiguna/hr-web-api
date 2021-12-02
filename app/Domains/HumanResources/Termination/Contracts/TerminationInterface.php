<?php
namespace App\Domains\HumanResources\Termination\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface TerminationInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'terminations';
    const MORPH_NAME = 'terminations';

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
     * Get termination_date.
     *
     * @return mixed
     */
    public function getTerminationDate();
    
    /**
     * Set termination_date.
     *
     * @param $termination_date
     *
     * @return mixed
     */
    public function setTerminationDate($termination_date);

    /**
     * Get note.
     *
     * @return mixed
     */
    public function getNote();
    
    /**
     * Set note.
     *
     * @param $note
     *
     * @return mixed
     */
    public function setNote($note);

    /**
     * Get severance.
     *
     * @return mixed
     */
    public function getSeverance();
    
    /**
     * Set severance.
     *
     * @param $severance
     *
     * @return mixed
     */
    public function setSeverance($severance);

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

    //</editor-fold>


    //</editor-fold>
}
