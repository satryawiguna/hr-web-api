<?php
namespace App\Domains\HumanResources\Mutation\PositionMutation\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface PositionMutationInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'position_mutations';
    const MORPH_NAME = 'position_mutations';

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
     * Get position_id.
     *
     * @return mixed
     */
    public function getPositionId();
    
    /**
     * Set position_id.
     *
     * @param $position_id
     *
     * @return mixed
     */
    public function setPositionId($position_id);

    /**
     * Get grade_id.
     *
     * @return mixed
     */
    public function getGradeId();

    /**
     * Set grade_id.
     *
     * @param $grade_id
     *
     * @return mixed
     */
    public function setGradeId($grade_id);

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
    public function position();

    //</editor-fold>


    //</editor-fold>
}
