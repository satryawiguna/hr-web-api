<?php
namespace App\Domains\HumanResources\Personal\Employee\Child\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface ChildInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'childs';
    const MORPH_NAME = 'childs';

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
     * Get full_name.
     *
     * @return mixed
     */
    public function getFullName();
    
    /**
     * Set full_name.
     *
     * @param $full_name
     *
     * @return mixed
     */
    public function setFullName($full_name);

    /**
     * Get nick_name.
     *
     * @return mixed
     */
    public function getNickName();
    
    /**
     * Set nick_name.
     *
     * @param $nick_name
     *
     * @return mixed
     */
    public function setNickName($nick_name);

    /**
     * Get gender_id.
     *
     * @return mixed
     */
    public function getGenderId();

    /**
     * Set gender_id.
     *
     * @param $gender_id
     *
     * @return mixed
     */
    public function setGenderId($gender_id);

    /**
     * Get order.
     *
     * @return mixed
     */
    public function getOrder();
    
    /**
     * Set order.
     *
     * @param $order
     *
     * @return mixed
     */
    public function setOrder($order);

    /**
     * Get birth_place.
     *
     * @return mixed
     */
    public function getBirthPlace();
    
    /**
     * Set birth_place.
     *
     * @param $birth_place
     *
     * @return mixed
     */
    public function setBirthPlace($birth_place);

    /**
     * Get birth_date.
     *
     * @return mixed
     */
    public function getBirthDate();
    
    /**
     * Set birth_date.
     *
     * @param $birth_date
     *
     * @return mixed
     */
    public function setBirthDate($birth_date);

    /**
     * Get has_bpjs_kesehatan.
     *
     * @return mixed
     */
    public function getHasBpjsKesehatan();
    
    /**
     * Set has_bpjs_kesehatan.
     *
     * @param $has_bpjs_kesehatan
     *
     * @return mixed
     */
    public function setHasBpjsKesehatan($has_bpjs_kesehatan);

    /**
     * Get bpjs_kesehatan_number.
     *
     * @return mixed
     */
    public function getBpjsKesehatanNumber();
    
    /**
     * Set bpjs_kesehatan_number.
     *
     * @param $bpjs_kesehatan_number
     *
     * @return mixed
     */
    public function setBpjsKesehatanNumber($bpjs_kesehatan_number);

    /**
     * Get bpjs_kesehatan_date.
     *
     * @return mixed
     */
    public function getBpjsKesehatanDate();
    
    /**
     * Set bpjs_kesehatan_date.
     *
     * @param $bpjs_kesehatan_date
     *
     * @return mixed
     */
    public function setBpjsKesehatanDate($bpjs_kesehatan_date);

    /**
     * Get bpjs_kesehatan_class.
     *
     * @return mixed
     */
    public function getBpjsKesehatanClass();
    
    /**
     * Set bpjs_kesehatan_class.
     *
     * @param $bpjs_kesehatan_class
     *
     * @return mixed
     */
    public function setBpjsKesehatanClass($bpjs_kesehatan_class);

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
    public function gender();

    //</editor-fold>

    //</editor-fold>
}
