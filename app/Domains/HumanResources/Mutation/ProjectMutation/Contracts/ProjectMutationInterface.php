<?php
namespace App\Domains\HumanResources\Mutation\ProjectMutation\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ProjectMutationInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta"

    const TABLE_NAME = 'project_mutations';
    const MORPH_NAME = 'project_mutations';

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
    public function project();

    //</editor-fold>


    //</editor-fold>    
}
