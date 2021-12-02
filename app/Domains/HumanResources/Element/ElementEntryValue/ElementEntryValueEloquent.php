<?php

namespace App\Domains\HumanResources\Element\ElementEntryValue;

use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Element entry value eloquent",
 *     title="Element entry value eloquent",
 *     required={"element_entry_id", "element_value_id", "effective_start_date", "effective_end_date", "value"}
 * )
 * ElementEntryValueEloquent.
 */
class ElementEntryValueEloquent extends EloquentAbstract implements ElementEntryValueInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="element_entry_id",
     *     type="integer",
     *     format="int64",
     *     description="Element entry id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="element_value_id",
     *     type="integer",
     *     format="int64",
     *     description="Element value id property",
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
     *     property="value",
     *     type="float",
     *     description="Value property",
     *     example=100
     * )
     *
     * @var float
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
    protected $table =  ElementEntryValueInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'element_entry_id', 'element_value_id', 'effective_start_date', 'effective_end_date', 'value', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'element_entry_id', 'element_value_id', 'effective_start_date', 'effective_end_date', 'value', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'element_entry_id', 'element_value_id', 'effective_start_date', 'effective_end_date', 'value', 'created_by', 'modified_by'
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
    public function getElementEntryId()
    {
        return $this->element_entry_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementEntryId($element_entry_id)
    {
        $this->element_entry_id = $element_entry_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getElementValueId()
    {
        return $this->element_value_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementValueId($element_value_id)
    {
        $this->element_value_id = $element_value_id;
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
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
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

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function elementEntry()
    {
        return $this->belongsTo(ElementEloquent::class, 'element_entry_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function elementValue()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'element_value_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateElementEntryValueEloquent",
 *     description="Create element entry value eloquent",
 *     title="Create element entry value eloquent",
 *     required={"element_entry_id", "element_value_id", "effective_start_date", "effective_end_date", "value"},
 *     @OA\Property(property="element_entry_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_entry_id"),
 *     @OA\Property(property="element_value_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_value_id"),
 *     @OA\Property(property="effective_start_date", ref="#/components/schemas/ElementEntryValueEloquent/properties/effective_start_date"),
 *     @OA\Property(property="effective_end_date", ref="#/components/schemas/ElementEntryValueEloquent/properties/effective_end_date"),
 *     @OA\Property(property="value", ref="#/components/schemas/ElementEntryValueEloquent/properties/value")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateElementEntryValueEloquent",
 *     description="Update element entry value eloquent",
 *     title="Update element entry value eloquent",
 *     required={"id", "element_entry_id", "element_value_id", "effective_start_date", "effective_end_date", "value"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateElementEntryValueEloquent")
 *     }
 * )
 */
