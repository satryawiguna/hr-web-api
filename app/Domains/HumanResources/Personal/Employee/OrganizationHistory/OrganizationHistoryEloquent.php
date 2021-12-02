<?php

namespace App\Domains\HumanResources\Personal\Employee\OrganizationHistory;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts\OrganizationHistoryInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Organization history eloquent",
 *     title="Organization history eloquent",
 *     required={"employee_id", "name", "start_date", "end_date", "activity"}
 * )
 * OrganizationHistoryEloquent.
 */
class OrganizationHistoryEloquent extends EloquentAbstract implements OrganizationHistoryInterface
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
     *     property="activity",
     *     type="string",
     *     description="Activity property"
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
    protected $table =  OrganizationHistoryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'name', 'start_date', 'end_date', 'activity', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'name', 'start_date', 'end_date', 'activity', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'name', 'start_date', 'end_date', 'activity', 'created_by', 'modified_by'
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
    public function getActivity()
    {
        return $this->activity;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
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
 *     schema="CreateOrganizationHistoryEloquent",
 *     description="Create organization history eloquent",
 *     title="Create organization history eloquent",
 *     required={"employee_id", "name", "start_date", "end_date", "activity"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/OrganizationHistoryEloquent/properties/employee_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/OrganizationHistoryEloquent/properties/name"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/OrganizationHistoryEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/OrganizationHistoryEloquent/properties/end_date"),
 *     @OA\Property(property="activity", ref="#/components/schemas/OrganizationHistoryEloquent/properties/activity")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateOrganizationHistoryEloquent",
 *     description="Update organization history eloquent",
 *     title="Update organization history eloquent",
 *     required={"id", "employee_id", "name", "start_date", "end_date", "activity"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateOrganizationHistoryEloquent")
 *     }
 * )
 */
