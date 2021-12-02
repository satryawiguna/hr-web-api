<?php

namespace App\Domains\HumanResources\Project\ProjectTerms;

use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\Project\ProjectTerms\Contracts\ProjectTermsInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Project Terms eloquent",
 *     title="Project Terms eloquent",
 *     required={"project_id", "step", "name", "value", "description"}
 * )
 * ProjectEloquent.
 */
class ProjectTermsEloquent extends EloquentAbstract implements ProjectTermsInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="project_id",
     *     type="integer",
     *     format="int64",
     *     description="Project id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="step",
     *     type="integer",
     *     format="int64",
     *     description="Step property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="value",
     *     type="float",
     *     description="Value property",
     *     example="0"
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
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
    protected $table =  ProjectTermsInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'step', 'name', 'value', 'description', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'project_id', 'step', 'name', 'value', 'description', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'project_id', 'step', 'name', 'value', 'description', 'created_by', 'modified_by'
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
    public function getStep()
    {
        return $this->step;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStep($step)
    {
        $this->step = $step;
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
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function project()
    {
        return $this->belongsTo(ProjectEloquent::class, 'project_id');
    }

    //</editor-fold>


    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateProjectTermsEloquent",
 *     description="Create project terms eloquent",
 *     title="Create project terms eloquent",
 *     required={"step","name","value","description"},
 *     @OA\Property(property="step", ref="#/components/schemas/ProjectTermsEloquent/properties/step"),
 *     @OA\Property(property="name", ref="#/components/schemas/ProjectTermsEloquent/properties/name"),
 *     @OA\Property(property="value", ref="#/components/schemas/ProjectTermsEloquent/properties/value"),
 *     @OA\Property(property="description", ref="#/components/schemas/ProjectTermsEloquent/properties/description"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateProjectTermsEloquent",
 *     description="Update project terms eloquent",
 *     title="Update project terms eloquent",
 *     required={"project_id","step","name","value","description"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateProjectTermsEloquent")
 *     }
 * )
 */
