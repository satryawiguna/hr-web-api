<?php

namespace App\Domains\HumanResources\Project\ProjectAddendum;

use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumInterface;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Project addendum eloquent",
 *     title="Project addendum eloquent",
 *     required={"project_id","reference_number","name","issue_date","start_date","end_date"}
 * )
 * ProjectAddendumEloquent.
 */
class ProjectAddendumEloquent extends EloquentAbstract implements ProjectAddendumInterface
{
    use SoftDeletes;

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
     *     property="reference_number",
     *     description="Reference number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="name",
     *     description="Name property",
     *     type="string"
     * )
     *
     * @var string
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
     *     property="description",
     *     description="Description number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="value",
     *     description="Value property",
     *     type="number"
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="is_contract",
     *     type="integer",
     *     format="int32",
     *     description="Is contract property (contract = 1; not contract = 0)",
     *     example=1
     * )
     *
     * @var integer
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
    protected $table =  ProjectAddendumInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'reference_number', 'name', 'issue_date', 'start_date', 'end_date', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'project_id', 'reference_number', 'name', 'issue_date', 'start_date', 'end_date', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'project_id', 'reference_number', 'name', 'issue_date', 'start_date', 'end_date', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
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
    public function getIsContract()
    {
        return $this->is_contract;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsContract($is_contract)
    {
        $this->is_contract = $is_contract;
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

    /**
     * @return mixed
     */
    public function getProjectAddendumMediaLibraries()
    {
        return $this->project_addendum_media_libraries;
    }

    /**
     * @param $project_addendum_media_libraries
     * @return $this|mixed
     */
    public function setProjectAddendumsMediaLibraries($project_addendum_media_libraries)
    {
        $this->project_addendum_media_libraries = $project_addendum_media_libraries;
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


    //<editor-fold desc="#polimorphism relation">

    public function morphMediaLibraries()
    {
        return $this->morphToMany(MediaLibraryEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_libraryable_id',
            'media_library_id');
    }

    //</editor-fold>


    //</editor-fold>
}


/**
 * @OA\Schema(
 *     schema="CreateProjectAddendumEloquent",
 *     description="Create project addendum eloquent",
 *     title="Create project addendum eloquent",
 *     required={"reference_number","name","issue_date","start_date","end_date"},
 *     @OA\Property(property="reference_number", ref="#/components/schemas/ProjectAddendumEloquent/properties/reference_number"),
 *     @OA\Property(property="name", ref="#/components/schemas/ProjectAddendumEloquent/properties/name"),
 *     @OA\Property(property="issue_date", ref="#/components/schemas/ProjectAddendumEloquent/properties/issue_date"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/ProjectAddendumEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/ProjectAddendumEloquent/properties/end_date"),
 *     @OA\Property(property="description", ref="#/components/schemas/ProjectAddendumEloquent/properties/description"),
 *     @OA\Property(property="value", ref="#/components/schemas/ProjectAddendumEloquent/properties/value"),
 *     @OA\Property(property="is_contract", ref="#/components/schemas/ProjectAddendumEloquent/properties/is_contract"),
 *     @OA\Property(
 *         property="media_libraries",
 *         description="Media library property",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                 property="media_library_id",
 *                 description="Media library id property",
 *                 type="string",
 *                 example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
 *             ),
 *             @OA\Property(
 *                 property="pivot",
 *                 description="Pivot property",
 *                 @OA\Property(
 *                     property="attribute",
 *                     type="string",
 *                     example="document"
 *                 )
 *             )
 *         )
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateProjectAddendumEloquent",
 *     description="Update project addendum eloquent",
 *     title="Update project addendum eloquent",
 *     required={"id","reference_number","name","issue_date","start_date","end_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateProjectAddendumEloquent")
 *     }
 * )
 */
