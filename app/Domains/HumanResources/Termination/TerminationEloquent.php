<?php

namespace App\Domains\HumanResources\Termination;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Termination\Contracts\TerminationInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Termination eloquent",
 *     title="Termination eloquent",
 *     required={"employee_id", "type", "termination_date", "severance"}
 * )
 * TerminationEloquent.
 */
class TerminationEloquent extends EloquentAbstract implements TerminationInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="employee_id",
     *     description="Employee id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="type",
     *     description="Type property",
     *     type="string",
     *     enum={"RESIGN", "PHK"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="termination_date",
     *     description="Termination date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="note",
     *     description="Note property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="severance",
     *     description="Severance property",
     *     type="number"
     * )
     *
     * @var float
     */


    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  TerminationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'type', 'termination_date', 'note', 'severance', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'type', 'termination_date', 'note', 'severance', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'type', 'termination_date', 'note', 'severance', 'created_by', 'modified_by'
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
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTerminationDate()
    {
        return $this->termination_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTerminationDate($termination_date)
    {
        $this->termination_date = $termination_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSeverance()
    {
        return $this->severance;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSeverance($severance)
    {
        $this->severance = $severance;
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

    //</editor-fold


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'employee_id');
    }

    //</editor-fold>

    //</editor-fold
}

/**
 * @OA\Schema(
 *     schema="CreateTerminationEloquent",
 *     description="Create termination eloquent",
 *     title="Create termination eloquent",
 *     required={"employee_id", "type", "termination_date", "severance"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/TerminationEloquent/properties/employee_id"),
 *     @OA\Property(property="type", ref="#/components/schemas/TerminationEloquent/properties/type"),
 *     @OA\Property(property="termination_date", ref="#/components/schemas/TerminationEloquent/properties/termination_date"),
 *     @OA\Property(property="note", ref="#/components/schemas/TerminationEloquent/properties/note"),
 *     @OA\Property(property="severance", ref="#/components/schemas/TerminationEloquent/properties/severance"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateTerminationEloquent",
 *     description="Update termination eloquent",
 *     title="Update termination eloquent",
 *     required={"id", "employee_id", "type", "termination_date", "severance"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateTerminationEloquent")
 *     }
 * )
 */
