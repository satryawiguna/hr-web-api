<?php
namespace App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface WorkUnitMutationInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'work_unit_mutations';
    const MORPH_NAME = 'work_unit_mutations';

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
     * Get work_unit_id.
     *
     * @return mixed
     */
    public function getWorkUnitId();
    
    /**
     * Set work_unit_id.
     *
     * @param $work_unit_id
     *
     * @return mixed
     */
    public function setWorkUnitId($work_unit_id);

    /**
     * Get mutation_date.
     *
     * @return mixed
     */
    public function getMutationDate();
    
    /**
     * Set mutation_date.
     *
     * @param $mutation_date
     *
     * @return mixed
     */
    public function setMutationDate($mutation_date);

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
    public function workUnit();

    //</editor-fold>


    //</editor-fold>
}
