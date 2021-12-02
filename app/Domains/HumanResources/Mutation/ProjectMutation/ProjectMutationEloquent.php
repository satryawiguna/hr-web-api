<?php

namespace App\Domains\HumanResources\Mutation\ProjectMutation;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Project mutation eloquent",
 *     title="Project mutation eloquent",
 *     required={"employee_id", "project_id", "mutation_date"}
 * )
 * ProjectMutationEloquent.
 */
class ProjectMutationEloquent extends EloquentAbstract implements ProjectMutationInterface
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
     *     property="project_id",
     *     description="Project id property",
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


    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  ProjectMutationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'project_id', 'mutation_date', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'project_id', 'mutation_date', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'project_id', 'mutation_date', 'created_by', 'modified_by'
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
    public function getProjectId()
    {
        return $this->project_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProjectId($project_id)
    {
        $this->project_id = $project_id;
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
    public function project()
    {
        return $this->belongsTo(ProjectEloquent::class, 'project_id');
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateProjectMutationEloquent",
 *     description="Create project mutation eloquent",
 *     title="Create project mutation eloquent",
 *     required={"project_id", "mutation_date"},
 *     @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
 *     @OA\Property(property="mutation_date", ref="#/components/schemas/ProjectMutationEloquent/properties/mutation_date")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateProjectMutationEloquent",
 *     description="Update project mutation eloquent",
 *     title="Update project mutation eloquent",
 *     required={"id", "project_id", "mutation_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateProjectMutationEloquent")
 *     }
 * )
 */
