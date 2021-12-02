<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence;

use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Work competence eloquent",
 *     title="Work competence eloquent",
 *     required={"employee_id", "reference_number", "competence_id", "issue_date", "validity"}
 * )
 * WorkCompetenceEloquent.
 */
class WorkCompetenceEloquent extends EloquentAbstract implements WorkCompetenceInterface
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
     *     property="reference_number",
     *     description="Reference number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="competence_id",
     *     description="Competence id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="issue_date",
     *     description="Issue date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="validity",
     *     description="Validity property",
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
    protected $table =  WorkCompetenceInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'reference_number', 'competence_id', 'issue_date', 'validity', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'reference_number', 'competence_id', 'issue_date', 'validity', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'reference_number', 'competence_id', 'issue_date', 'validity', 'created_by', 'modified_by'
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
    public function getReferenceNumber()
    {
        return $this->reference_number;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReferenceNumber($reference_number)
    {
        $this->reference_number = $reference_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompetenceId()
    {
        return $this->competence_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompetenceId($competence_id)
    {
        $this->competence_id = $competence_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssueDate()
    {
        return $this->issue_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIssueDate($issue_date)
    {
        $this->issue_date = $issue_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidity()
    {
        return $this->validity;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValidity($validity)
    {
        $this->validity = $validity;
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
    public function competence()
    {
        return $this->belongsTo(CompetenceEloquent::class, 'competence_id');
    }

    //</editor-fold>

    //</editor-fold
}

/**
 * @OA\Schema(
 *     schema="CreateWorkCompetenceEloquent",
 *     description="Create work competence eloquent",
 *     title="Create work competence eloquent",
 *     required={"employee_id", "reference_number", "competence_id", "issue_date", "validity"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/employee_id"),
 *     @OA\Property(property="reference_number", ref="#/components/schemas/WorkCompetenceEloquent/properties/reference_number"),
 *     @OA\Property(property="competence_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/competence_id"),
 *     @OA\Property(property="issue_date", ref="#/components/schemas/WorkCompetenceEloquent/properties/issue_date"),
 *     @OA\Property(property="validity", ref="#/components/schemas/WorkCompetenceEloquent/properties/validity"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateWorkCompetenceEloquent",
 *     description="Update work competence eloquent",
 *     title="Update work competence eloquent",
 *     required={"id", "employee_id", "reference_number", "competence_id", "issue_date", "validity"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateWorkCompetenceEloquent")
 *     }
 * )
 */
