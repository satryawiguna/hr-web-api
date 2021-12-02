<?php

namespace App\Domains\HumanResources\Mutation\WorkUnitMutation;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Work unit mutation eloquent",
 *     title="Work unit mutation eloquent",
 *     required={"employee_id", "work_unit_id", "mutation_date"}
 * )
 * WorkUnitMutationEloquent.
 */
class WorkUnitMutationEloquent extends EloquentAbstract implements WorkUnitMutationInterface
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
     *     property="work_unit_id",
     *     description="Work unit id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="mutation_date",
     *     description="Mutation date property",
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


    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  WorkUnitMutationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'work_unit_id', 'mutation_date', 'note', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'work_unit_id', 'mutation_date', 'note', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'work_unit_id', 'mutation_date', 'note', 'created_by', 'modified_by'
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
    public function getWorkUnitId()
    {
        return $this->work_unit_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setWorkUnitId($work_unit_id)
    {
        $this->work_unit_id = $work_unit_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMutationDate()
    {
        return $this->mutation_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMutationDate($mutation_date)
    {
        $this->mutation_date = $mutation_date;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function workUnit()
    {
        return $this->belongsTo(WorkUnitEloquent::class, 'work_unit_id');
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateWorkUnitMutationEloquent",
 *     description="Create work unit mutation eloquent",
 *     title="Create work unit mutation eloquent",
 *     required={"work_unit_id", "mutation_date"},
 *     @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
 *     @OA\Property(property="mutation_date", ref="#/components/schemas/WorkUnitMutationEloquent/properties/mutation_date"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateWorkUnitMutationEloquent",
 *     description="Update work unit mutation eloquent",
 *     title="Update work unit mutation eloquent",
 *     required={"id", "work_unit_id", "mutation_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateWorkUnitMutationEloquent")
 *     }
 * )
 */
