<?php
namespace App\Domains\Commons\Company;


use App\Domains\Commons\Application\ApplicationEloquent;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\BaseSalaryCustomTypeEloquent;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\CompanyCategory\CompanyCategoryEloquent;
use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\EmployeeLoanType\EmployeeLoanTypeEloquent;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleEloquent;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeEloquent;
use App\Domains\Commons\Office\OfficeEloquent;
use App\Domains\HumanResources\MasterData\OtherType\OtherTypeEloquent;
use App\Domains\HumanResources\MasterData\Position\PositionEloquent;
use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\MasterData\SalaryStructure\SalaryStructureEloquent;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Domains\User\UserEloquent;
use App\Domains\Vacancy\VacancyEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\WorkUnitEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Company eloquent",
 *     title="Company eloquent",
 *     required={"company_category_id", "employee_number_scale_id", "name", "slug", "email"}
 * )
 * CompanyEloquent.
 */
class CompanyEloquent extends EloquentAbstract implements CompanyInterface
{
    use SoftDeletes, Sluggable;

    /**
     * @OA\Property(
     *     property="company_category_id",
     *     type="integer",
     *     format="int32",
     *     description="Company category property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="employee_number_scale_id",
     *     type="integer",
     *     format="int32",
     *     description="Employee number scale property",
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
     *     property="slug",
     *     type="string",
     *     description="Slug property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="url",
     *     type="string",
     *     description="Url property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="latitude",
     *     type="string",
     *     description="Latitude property"
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="longitude",
     *     type="string",
     *     description="Longitude property"
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

    /**
     * @OA\Property(
     *     property="is_active",
     *     type="integer",
     *     format="int32",
     *     description="Is active property"
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
     *
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
    protected $table =  CompanyInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_category_id', 'employee_number_scale_id', 'name', 'slug', 'email', 'url', 'latitude', 'longitude', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'company_category_id', 'employee_number_scale_id', 'name', 'slug', 'email', 'url', 'latitude', 'longitude', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'company_category_id', 'employee_number_scale_id', 'name', 'slug', 'email', 'url', 'latitude', 'longitude', 'description', 'is_active', 'created_by', 'modified_by'
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
    public function getCompanyCategoryId()
    {
        return $this->company_category_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyCategoryId($company_category_id)
    {
        $this->company_category_id = $company_category_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmployeeNumberScaleId()
    {
        return $this->employee_number_scale_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmployeeNumberScaleId($employee_number_scale_id)
    {
        $this->employee_number_scale_id = $employee_number_scale_id;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
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
    public function getIsActive()
    {
        return $this->is_active;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
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
    public function companyCategory()
    {
        return $this->belongsTo(CompanyCategoryEloquent::class, 'company_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function employeeNumberScale()
    {
        return $this->belongsTo(EmployeeNumberScaleEloquent::class, 'employee_number_scale_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    public function applications()
    {
        return $this->belongsToMany(ApplicationEloquent::class, 'company_applications', 'company_id', 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_companies', 'company_id', 'user_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function positions()
    {
        return $this->hasMany(PositionEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function otherTypes()
    {
        return $this->hasMany(OtherTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function otherAllowanceTypes()
    {
        return $this->hasMany(OtherAllowanceTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function baseSalaryCustomTypes()
    {
        return $this->hasMany(BaseSalaryCustomTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function salaryStructures()
    {
        return $this->hasMany(SalaryStructureEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function vacancies()
    {
        return $this->hasMany(VacancyEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function projects()
    {
        return $this->hasMany(ProjectEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function letterTypes()
    {
        return $this->hasMany(LetterTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workUnits()
    {
        return $this->hasMany(WorkUnitEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function competences()
    {
        return $this->hasMany(CompetenceEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workAreas()
    {
        return $this->hasMany(WorkAreaEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function offices()
    {
        return $this->hasMany(OfficeEloquent::class, 'comapny_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function customAllowanceTypes()
    {
        return $this->hasMany(CustomAllowanceTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function employeeLoanTypes()
    {
        return $this->hasMany(EmployeeLoanTypeEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function employees()
    {
        return $this->hasMany(EmployeeEloquent::class, 'company_id');
    }

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    public function morphMediaLibraries()
    {
        return $this->morphToMany(MediaLibraryEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_libraryable_id',
            'media_library_id');
    }

    //</editor-fold>


    /**
     * @return array|mixed
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateCompanyEloquent",
 *     description="Create company eloquent",
 *     title="Create company eloquent",
 *     required={"company_category_id", "employee_number_scale_id", "name", "slug", "email"},
 *     @OA\Property(property="company_category_id", ref="#/components/schemas/CompanyEloquent/properties/company_category_id"),
 *     @OA\Property(property="employee_number_scale_id", ref="#/components/schemas/CompanyEloquent/properties/employee_number_scale_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/CompanyEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/CompanyEloquent/properties/slug"),
 *     @OA\Property(property="email", ref="#/components/schemas/CompanyEloquent/properties/email"),
 *     @OA\Property(property="url", ref="#/components/schemas/CompanyEloquent/properties/url"),
 *     @OA\Property(property="latitude", ref="#/components/schemas/CompanyEloquent/properties/latitude"),
 *     @OA\Property(property="longitude", ref="#/components/schemas/CompanyEloquent/properties/longitude"),
 *     @OA\Property(property="description", ref="#/components/schemas/CompanyEloquent/properties/description"),
 *     @OA\Property(property="is_active", ref="#/components/schemas/CompanyEloquent/properties/is_active")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateCompanyEloquent",
 *     description="Update company eloquent",
 *     title="Update company eloquent",
 *     required={"id","company_category_id", "employee_number_scale_id", "name", "slug", "email"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateCompanyEloquent")
 *     }
 * )
 */
