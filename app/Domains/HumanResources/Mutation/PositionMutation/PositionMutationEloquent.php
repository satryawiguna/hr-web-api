<?php

namespace App\Domains\HumanResources\Mutation\PositionMutation;

use App\Domains\HumanResources\MasterData\Grade\GradeEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\MasterData\Position\PositionEloquent;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Position mutation eloquent",
 *     title="Position mutation eloquent",
 *     required={"employee_id", "position_id", "grade_id", "mutation_date"}
 * )
 * PositionMutationEloquent.
 */
class PositionMutationEloquent extends EloquentAbstract implements PositionMutationInterface
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
     *     property="position_id",
     *     description="Position id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="grade_id",
     *     description="Grade id property",
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
    protected $table =  PositionMutationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'position_id', 'grade_id', 'mutation_date', 'note', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'position_id', 'grade_id', 'mutation_date', 'note', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'position_id', 'grade_id', 'mutation_date', 'note', 'created_by', 'modified_by'
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
    public function getPositionId()
    {
        return $this->position_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPositionId($position_id)
    {
        $this->position_id = $position_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGradeId()
    {
        return $this->grade_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setGradeId($grade_id)
    {
        $this->grade_id = $grade_id;
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
    public function position()
    {
        return $this->belongsTo(PositionEloquent::class, 'position_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(GradeEloquent::class,'grade_id');
    }

    //</editor-fold>

    //</editor-fold
}

/**
 * @OA\Schema(
 *     schema="CreatePositionMutationEloquent",
 *     description="Create position mutation eloquent",
 *     title="Create position mutation eloquent",
 *     required={"position_id", "grade_id", "mutation_date"},
 *     @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
 *     @OA\Property(property="grade_id", ref="#/components/schemas/PositionMutationEloquent/properties/grade_id"),
 *     @OA\Property(property="mutation_date", ref="#/components/schemas/PositionMutationEloquent/properties/mutation_date"),
 *     @OA\Property(property="note", ref="#/components/schemas/PositionMutationEloquent/properties/note"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdatePositionMutationEloquent",
 *     description="Update position mutation eloquent",
 *     title="Update position mutation eloquent",
 *     required={"id", "position_id", "grade_id", "mutation_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreatePositionMutationEloquent")
 *     }
 * )
 */
