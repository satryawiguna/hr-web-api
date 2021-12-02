<?php

namespace App\Domains\HumanResources\Vacancy;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\Commons\Skill\SkillEloquent;
use App\Domains\Commons\VacancyCategory\VacancyCategoryEloquent;
use App\Domains\Commons\VacancyLocation\VacancyLocationEloquent;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\AdditionalQuestionEloquent;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Vacancy eloquent",
 *     title="Vacancy eloquent",
 *     required={"company_id", "vacancy_location_id", "vacancy_category_id", "title", "slug", "publish_date", "expired_date", "min_salary", "max_salary", "reference_code", "intro", "description", "requirement", "needs", "work_status", "work_type", "status"}
 * )
 * VacancyEloquent.
 */
class VacancyEloquent extends EloquentAbstract implements VacancyInterface
{
    use SoftDeletes;

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
     *     property="vacancy_location_id",
     *     type="integer",
     *     format="int64",
     *     description="Vacancy locaiton id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="vacancy_category_id",
     *     type="integer",
     *     format="int64",
     *     description="Vacancy category id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     description="Title property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="slug",
     *     type="string",
     *     description="Slug property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="publish_date",
     *     description="Publish date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="expired_date",
     *     description="Expired date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="min_salary",
     *     type="number",
     *     description="Min salary property",
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="max_salary",
     *     type="number",
     *     description="Max salary property",
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="reference_code",
     *     type="string",
     *     description="Reference code property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="intro",
     *     type="string",
     *     description="Intro property"
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
     *     property="requirement",
     *     type="string",
     *     description="Requirement property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="needs",
     *     type="integer",
     *     format="int64",
     *     description="Career property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="work_status",
     *     description="Work status property",
     *     type="string",
     *     enum={"FULL_TIME", "PART_TIME"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="work_type",
     *     description="Work type property",
     *     type="string",
     *     enum={"PERMANENT", "CONTRACT"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="status",
     *     description="Status property",
     *     type="string",
     *     enum={"PUBLISH", "DRAFT", "PENDING"},
     *     default=""
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
    protected $table =  VacancyInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'vacancy_location_id', 'vacancy_category_id', 'title', 'slug', 'publish_date', 'expired_date', 'min_salary', 'max_salary', 'reference_code', 'intro', 'description', 'requirement', 'needs', 'work_status', 'work_type', 'status', 'created_by',' modified_by'
    ];

    protected $searchable = [
        'company_id', 'vacancy_location_id', 'vacancy_category_id', 'title', 'slug', 'publish_date', 'expired_date', 'min_salary', 'max_salary', 'reference_code', 'intro', 'description', 'requirement', 'needs', 'work_status', 'work_type', 'status', 'created_by',' modified_by'
    ];

    protected $orderable = [
        'company_id', 'vacancy_location_id', 'vacancy_category_id', 'title', 'slug', 'publish_date', 'expired_date', 'min_salary', 'max_salary', 'reference_code', 'intro', 'description', 'requirement', 'needs', 'work_status', 'work_type', 'status', 'created_by',' modified_by'
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
    public function getVacancyLocationId()
    {
        return $this->vacancy_location_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVacancyLocationId($vacancy_location_id)
    {
        $this->vacancy_location_id = $vacancy_location_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVacancyCategoryId()
    {
        return $this->vacancy_category_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVacancyCategoryId($vacancy_category_id)
    {
        $this->vacancy_category_id = $vacancy_category_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishDate()
    {
        return $this->publish_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPublishDate($publish_date)
    {
        $this->publish_date = $publish_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiredDate()
    {
        return $this->expired_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExpiredDate($expired_date)
    {
        $this->expired_date = $expired_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinSalary()
    {
        return $this->min_salary;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMinSalary($min_salary)
    {
        $this->min_salary = $min_salary;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxSalary()
    {
        return $this->max_salary;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMaxSalary($max_salary)
    {
        $this->max_salary = $max_salary;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceCode()
    {
        return $this->reference_code;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReferenceCode($reference_code)
    {
        $this->reference_code = $reference_code;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIntro()
    {
        return $this->intro;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
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
    public function getRequirement()
    {
        return $this->requirement;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRequirement($requirement)
    {
        $this->requirement = $requirement;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNeeds()
    {
        return $this->needs;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNeeds($needs)
    {
        $this->needs = $needs;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkStatus()
    {
        return $this->work_status;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setWorkStatus($work_status)
    {
        $this->work_status = $work_status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkType()
    {
        return $this->work_type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setWorkType($work_type)
    {
        $this->work_type = $work_type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
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

    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicant()
    {
        return $this->hasMany(ApplicantEloquent::class,'vacancy_id');
    }

    //</editor-fold>

    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function degree()
    {
        return $this->belongsToMany(DegreeEloquent::class, 'vacancy_degrees', 'vacancy_id', 'degree_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function skill()
    {
        return $this->belongsToMany(SkillEloquent::class, 'vacancy_skills', 'vacancy_id', 'skill_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function additionalQuestion()
    {
        return $this->belongsToMany(AdditionalQuestionEloquent::class, 'vacancy_additional_questions', 'vacancy_id', 'additional_question_id');
    }

    //</editor-fold>    


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    public function vacancyLocation()
    {
        return $this->belongsTo(VacancyLocationEloquent::class, 'vacancy_location_id');
    }

    public function vacancyCategory()
    {
        return $this->belongsTo(VacancyCategoryEloquent::class, 'vacancy_category_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateVacancyEloquent",
 *     description="Create vacancy eloquent",
 *     title="Create vacancy eloquent",
 *     required={"company_id", "vacancy_location_id", "vacancy_category_id", "title", "slug", "publish_date", "expired_date", "reference_code", "intro", "description", "requirement", "needs", "work_status", "work_type", "status"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/VacancyEloquent/properties/company_id"),
 *     @OA\Property(property="vacancy_location_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_location_id"),
 *     @OA\Property(property="vacancy_category_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_category_id"),
 *     @OA\Property(property="title", ref="#/components/schemas/VacancyEloquent/properties/title"),
 *     @OA\Property(property="slug", ref="#/components/schemas/VacancyEloquent/properties/slug"),
 *     @OA\Property(property="publish_date", ref="#/components/schemas/VacancyEloquent/properties/publish_date"),
 *     @OA\Property(property="expired_date", ref="#/components/schemas/VacancyEloquent/properties/expired_date"),
 *     @OA\Property(property="min_salary", ref="#/components/schemas/VacancyEloquent/properties/min_salary"),
 *     @OA\Property(property="max_salary", ref="#/components/schemas/VacancyEloquent/properties/max_salary"),
 *     @OA\Property(property="reference_code", ref="#/components/schemas/VacancyEloquent/properties/reference_code"),
 *     @OA\Property(property="intro", ref="#/components/schemas/VacancyEloquent/properties/intro"),
 *     @OA\Property(property="description", ref="#/components/schemas/VacancyEloquent/properties/description"),
 *     @OA\Property(property="requirement", ref="#/components/schemas/VacancyEloquent/properties/requirement"),
 *     @OA\Property(property="needs", ref="#/components/schemas/VacancyEloquent/properties/needs"),
 *     @OA\Property(property="work_status", ref="#/components/schemas/VacancyEloquent/properties/work_status"),
 *     @OA\Property(property="work_type", ref="#/components/schemas/VacancyEloquent/properties/work_type"),
 *     @OA\Property(property="status", ref="#/components/schemas/VacancyEloquent/properties/status"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateVacancyEloquent",
 *     description="Update vacancy eloquent",
 *     title="Update vacancy eloquent",
 *     required={"company_id", "vacancy_location_id", "vacancy_category_id", "title", "slug", "publish_date", "expired_date", "min_salary", "max_salary", "reference_code", "intro", "description", "requirement", "needs", "work_status", "work_type", "status"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateVacancyEloquent")
 *     }
 * )
 */
