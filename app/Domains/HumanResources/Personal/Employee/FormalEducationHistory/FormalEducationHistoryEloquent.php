<?php

namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryInterface;
use App\Domains\Commons\Major\MajorEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Formal education history eloquent",
 *     title="Application eloquent",
 *     required={"employee_id", "degree_id", "major_id", "name", "start_date", "end_date"}
 * )
 * FormalEducationHistoryEloquent.
 */
class FormalEducationHistoryEloquent extends EloquentAbstract implements FormalEducationHistoryInterface
{
    use SoftDeletes;

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
     *     property="major_id",
     *     type="integer",
     *     format="int64",
     *     description="Major id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="degree_id",
     *     type="integer",
     *     format="int64",
     *     description="Degree id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="start_date",
     *     description="Start date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="end_date",
     *     description="End date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
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
    protected $table =  FormalEducationHistoryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'degree_id', 'major_id', 'name', 'start_date', 'end_date', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'degree_id', 'major_id', 'name', 'start_date', 'end_date', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'degree_id', 'major_id', 'name', 'start_date', 'end_date', 'created_by', 'modified_by'
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
    public function getDegreeId()
    {
        return $this->degree_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDegreeId($degree_id)
    {
        $this->degree_id = $degree_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMajorId()
    {
        return $this->major_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMajorId($major_id)
    {
        $this->major_id = $major_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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
    public function employee()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function degree()
    {
        return $this->belongsTo(DegreeEloquent::class, 'degree_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function major()
    {
        return $this->belongsTo(MajorEloquent::class, 'major_id');
    }

    //</editor-fold>


    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateFormalEducationHistoryEloquent",
 *     description="Create formal education history eloquent",
 *     title="Create formal education history eloquent",
 *     required={"employee_id", "degree_id", "major_id", "name", "start_date", "end_date"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/employee_id"),
 *     @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
 *     @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/name"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/end_date")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateFormalEducationHistoryEloquent",
 *     description="Update formal education history eloquent",
 *     title="Update formal education history eloquent",
 *     required={"id", "employee_id", "degree_id", "major_id", "name", "start_date", "end_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateFormalEducationHistoryEloquent")
 *     }
 * )
 */