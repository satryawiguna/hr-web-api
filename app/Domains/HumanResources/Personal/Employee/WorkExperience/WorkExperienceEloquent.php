<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkExperience;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Work experience eloquent",
 *     title="Work experience eloquent",
 *     required={"employee_id", "company", "business_type", "position"}
 * )
 * WorkExperienceEloquent.
 */
class WorkExperienceEloquent extends EloquentAbstract implements WorkExperienceInterface
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
     *     property="company",
     *     description="Company property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="business_type",
     *     description="Business type property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="position",
     *     description="Position property",
     *     type="string"
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


    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  WorkExperienceInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'company', 'business_type', 'position', 'start_date', 'end_date', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'company', 'business_type', 'position', 'start_date', 'end_date', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'company', 'business_type', 'position', 'start_date', 'end_date', 'created_by', 'modified_by'
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
    public function getCompany()
    {
        return $this->company;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBusinessType()
    {
        return $this->business_type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBusinessType($business_type)
    {
        $this->business_type = $business_type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
 *     schema="CreateWorkExperienceEloquent",
 *     description="Create work experience eloquent",
 *     title="Create work experience eloquent",
 *     required={"employee_id", "company", "business_type", "position"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/WorkExperienceEloquent/properties/employee_id"),
 *     @OA\Property(property="company", ref="#/components/schemas/WorkExperienceEloquent/properties/company"),
 *     @OA\Property(property="business_type", ref="#/components/schemas/WorkExperienceEloquent/properties/business_type"),
 *     @OA\Property(property="position", ref="#/components/schemas/WorkExperienceEloquent/properties/position"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/WorkExperienceEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/WorkExperienceEloquent/properties/end_date"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateWorkExperienceEloquent",
 *     description="Update work experience eloquent",
 *     title="Update work experience eloquent",
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
 *          @OA\Schema(ref="#/components/schemas/CreateWorkExperienceEloquent")
 *     }
 * )
 */
