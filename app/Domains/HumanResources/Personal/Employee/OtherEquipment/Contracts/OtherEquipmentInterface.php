<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface OtherEquipmentInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'other_equipments';
    const MORPH_NAME = 'other_equipments';

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

    //</editor-fold>


    //</editor-fold>
}
