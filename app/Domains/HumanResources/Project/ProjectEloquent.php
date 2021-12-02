<?php

namespace App\Domains\HumanResources\Project;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\ContractType\ContractTypeEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\ProjectAddendumEloquent;
use App\Domains\HumanResources\Mutation\ProjectMutationEloquent;
use App\Domains\HumanResources\Project\ProjectTerms\ProjectTermsEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Infrastructures\EloquentAbstract;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Project eloquent",
 *     title="Project eloquent",
 *     required={"company_id", "reference_number", "contract_type_id", "name", "first_party_number", "second_party_number", "issue_date", "start_date", "end_date", "activity", "description", "value", "is_contract"}
 * )
 * ProjectEloquent.
 */
class ProjectEloquent extends EloquentAbstract implements ProjectInterface
{
    use SoftDeletes, SoftCascadeTrait;

    /**
     * @OA\Property(
     *     property="parent_id",
     *     type="integer",
     *     format="int64",
     *     description="Parent id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="company_id",
     *     type="integer",
     *     format="int64",
     *     description="Company id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="reference_number",
     *     type="string",
     *     description="Reference number property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="contract_type_id",
     *     type="integer",
     *     format="int64",
     *     description="Contract type id property",
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
     *     property="first_party_number",
     *     type="string",
     *     description="First party number property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="second_party_number",
     *     type="string",
     *     description="Second party number property"
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
     *     property="activity",
     *     type="string",
     *     description="Activity property"
     * )
     *
     * @var string
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
    protected $table = ProjectInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'company_id', 'contract_type_id', 'reference_number', 'name', 'first_party_number', 'second_party_number', 'issue_date', 'start_date', 'end_date', 'activity', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'parent_id', 'company_id', 'contract_type_id', 'reference_number', 'name', 'first_party_number', 'second_party_number', 'issue_date', 'start_date', 'end_date', 'activity', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'parent_id', 'company_id', 'contract_type_id', 'reference_number', 'name', 'first_party_number', 'second_party_number', 'issue_date', 'start_date', 'end_date', 'activity', 'description', 'value', 'is_contract', 'created_by', 'modified_by'
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

    protected $project_media_libraries;

    protected $softCascade = ['projectAddendums', 'projectTerms'];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractTypeId()
    {
        return $this->contract_type_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setContractTypeId($contract_type_id)
    {
        $this->contract_type_id = $contract_type_id;
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
    public function getFirstPartyNumber()
    {
        return $this->first_party_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstPartyNumber($first_party_number)
    {
        $this->first_party_number = $first_party_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecondPartyNumber()
    {
        return $this->second_party_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecondPartyNumber($second_party_number)
    {
        $this->second_party_number = $second_party_number;
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

    //<editor-fold desc="#custom property">

    /**
     * @return mixed
     */
    public function getProjectMediaLibraries()
    {
        return $this->project_media_libraries;
    }

    /**
     * @param $project_media_libraries
     * @return $this|mixed
     */
    public function setProjectMediaLibraries($project_media_libraries)
    {
        $this->project_media_libraries = $project_media_libraries;
        return $this;
    }

    //</editor-fold>

    //</editor-fold


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function projectParent()
    {
        return $this->belongsTo(ProjectEloquent::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function workUnits()
    {
        return $this->belongsToMany(WorkUnitEloquent::class, 'project_work_units', 'project_id', 'work_unit_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has one relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function contractType()
    {
        return $this->belongsTo( ContractTypeEloquent::class, 'contract_type_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function projectChilds()
    {
        return $this->hasMany(ProjectEloquent::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectTerms()
    {
        return $this->hasMany(ProjectTermsEloquent::class, 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function projectAddendums()
    {
        return $this->hasMany(ProjectAddendumEloquent::class, 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function projectMutations()
    {
        return $this->hasMany(ProjectMutationEloquent::class,'project_id');
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
 *     schema="CreateProjectEloquent",
 *     description="Create project eloquent",
 *     title="Create project eloquent",
 *     required={"company_id", "reference_number", "contract_type_id", "name", "first_party_number", "second_party_number", "issue_date", "start_date", "end_date", "activity", "description", "value", "is_contract"},
 *     @OA\Property(property="parent_id", ref="#/components/schemas/ProjectEloquent/properties/parent_id"),
 *     @OA\Property(property="company_id", ref="#/components/schemas/ProjectEloquent/properties/company_id"),
 *     @OA\Property(property="reference_number", ref="#/components/schemas/ProjectEloquent/properties/reference_number"),
 *     @OA\Property(property="contract_type_id", ref="#/components/schemas/ProjectEloquent/properties/contract_type_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/ProjectEloquent/properties/name"),
 *     @OA\Property(property="first_party_number", ref="#/components/schemas/ProjectEloquent/properties/first_party_number"),
 *     @OA\Property(property="second_party_number", ref="#/components/schemas/ProjectEloquent/properties/second_party_number"),
 *     @OA\Property(property="issue_date", ref="#/components/schemas/ProjectEloquent/properties/issue_date"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/ProjectEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/ProjectEloquent/properties/end_date"),
 *     @OA\Property(property="activity", ref="#/components/schemas/ProjectEloquent/properties/activity"),
 *     @OA\Property(property="description", ref="#/components/schemas/ProjectEloquent/properties/description"),
 *     @OA\Property(property="value", ref="#/components/schemas/ProjectEloquent/properties/value"),
 *     @OA\Property(property="is_contract", ref="#/components/schemas/ProjectEloquent/properties/is_contract"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateProjectEloquent",
 *     description="Update project eloquent",
 *     title="Update project eloquent",
 *     required={"id", "company_id", "reference_number", "contract_type_id", "name", "first_party_number", "second_party_number", "issue_date", "start_date", "end_date", "activity", "description", "value", "is_contract"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateProjectEloquent")
 *     }
 * )
 */
