<?php

namespace App\Domains\HumanResources\Element\ElementEntry;

use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Element entry eloquent",
 *     title="Element entry eloquent",
 *     required={"element_id", "employee_id", "effective_start_date", "effective_end_date"}
 * )
 * ElementEntryEloquent.
 */
class ElementEntryEloquent extends EloquentAbstract implements ElementEntryInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="element_id",
     *     type="integer",
     *     format="int64",
     *     description="Element id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="employee_id",
     *     type="integer",
     *     format="int64",
     *     description="Employee id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="effective_start_date",
     *     type="string",
     *     format="date-time",
     *     description="Effective start date property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="effective_end_date",
     *     type="string",
     *     format="date-time",
     *     description="Effective end date property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="created_by",
     *     type="string",
     *     description="Created by property"
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="modified_by",
     *     type="string",
     *     description="Modified by property"
     * )
     *
     * @var string
     */

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  ElementEntryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'element_id', 'employee_id', 'effective_start_date', 'effective_end_date', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'element_id', 'employee_id', 'effective_start_date', 'effective_end_date', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'element_id', 'employee_id', 'effective_start_date', 'effective_end_date', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [
        'deleted_at'
    ];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getElementId()
    {
        return $this->element_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementId($element_id)
    {
        $this->element_id = $element_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEfectiveStartDate()
    {
        return $this->effective_start_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEfectiveStartDate($effective_start_date)
    {
        $this->effective_start_date = $effective_start_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEfectiveEndDate()
    {
        return $this->effective_end_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEfectiveEndDate($effective_end_date)
    {
        $this->effective_end_date = $effective_end_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementEntryValues()
    {
        return $this->hasMany(ElementEntryValueEloquent::class, 'element_entry_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'employee_id');
    }

    //</editor-fold>


    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateElementEntryEloquent",
 *     description="Create element entry eloquent",
 *     title="Create element entry eloquent",
 *     required={"element_id", "employee_id", "effective_start_date", "effective_end_date"},
 *     @OA\Property(property="element_id", ref="#/components/schemas/ElementEntryEloquent/properties/element_id"),
 *     @OA\Property(property="employee_id", ref="#/components/schemas/ElementEntryEloquent/properties/employee_id"),
 *     @OA\Property(property="effective_start_date", ref="#/components/schemas/ElementEntryEloquent/properties/effective_start_date"),
 *     @OA\Property(property="effective_end_date", ref="#/components/schemas/ElementEntryEloquent/properties/effective_end_date")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateElementEntryEloquent",
 *     description="Update element entry eloquent",
 *     title="Update element entry eloquent",
 *     required={"id", "element_id", "employee_id", "effective_start_date", "effective_end_date"},
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(
 *                   property="id",
 *                   type="integer",
 *                   format="int64",
 *                   description="Id property",
 *                   example=1
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/CreateElementEntryEloquent")
 *     }
 * )
 */
