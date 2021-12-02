<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\Personal\WorkUnitMutation\WorkUnitMutationEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Work unit eloquent",
 *     title="Work unit eloquent",
 *     required={"company_id", "code", "title", "slug", "country", "state_or_province", "city", "address", "postcode", "phone", "email"}
 * )
 * WorkUnitEloquent.
 */
class WorkUnitEloquent extends EloquentAbstract implements WorkUnitInterface
{
    use SoftDeletes, Sluggable;

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
     *     property="code",
     *     type="string",
     *     description="Code property"
     * )
     *
     * @var string
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
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="state_or_province",
     *     type="string",
     *     description="State/Province property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="City property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="postcode",
     *     type="string",
     *     description="Postcode property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="phone",
     *     type="string",
     *     description="Phone property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="fax",
     *     type="string",
     *     description="Fax property"
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
     *     property="is_active",
     *     type="integer",
     *     format="int32",
     *     description="Is active property (active = 1; not active = 0)",
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
    protected $table = WorkUnitInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'company_id', 'code', 'title', 'slug', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'url', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'parent_id', 'company_id', 'code', 'title', 'slug', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'url', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'parent_id', 'company_id', 'code', 'title', 'slug', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'url', 'is_active', 'created_by', 'modified_by'
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;
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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStateOrProvince()
    {
        return $this->state_or_province;
    }

    /**
     * {@inheritdoc}
     */
    public function setStateOrProvince($state_or_province)
    {
        $this->state_or_province = $state_or_province;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * {@inheritdoc}
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
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
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workUnitParent()
    {
        return $this->belongsTo(WorkUnitEloquent::class, 'parent_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    public function projects()
    {
        return $this->belongsToMany(ProjectEloquent::class, 'project_work_units', 'work_unit_id', 'project_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workUnitChilds()
    {
        return $this->hasMany(WorkUnitEloquent::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function workUnitMutations()
    {
        return $this->hasMany(WorkUnitMutationEloquent::class, 'work_unit_id');
    }

    //</editor-fold>


    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @param Builder $query
     * @param Model $model
     * @param $attribute
     * @param $config
     * @param $slug
     * @return mixed
     */
    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug)
    {
        return $query->where('company_id', $config['company_id']);
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateWorkUnitEloquent",
 *     description="Create work unit eloquent",
 *     title="Create work unit eloquent",
 *     required={"company_id", "code", "title", "slug", "country", "state_or_province", "city", "address", "postcode", "phone", "email"},
 *     @OA\Property(property="parent_id", ref="#/components/schemas/WorkUnitEloquent/properties/parent_id"),
 *     @OA\Property(property="company_id", ref="#/components/schemas/WorkUnitEloquent/properties/company_id"),
 *     @OA\Property(property="code", ref="#/components/schemas/WorkUnitEloquent/properties/code"),
 *     @OA\Property(property="title", ref="#/components/schemas/WorkUnitEloquent/properties/title"),
 *     @OA\Property(property="slug", ref="#/components/schemas/WorkUnitEloquent/properties/slug"),
 *     @OA\Property(property="country", ref="#/components/schemas/WorkUnitEloquent/properties/country"),
 *     @OA\Property(property="state_or_province", ref="#/components/schemas/WorkUnitEloquent/properties/state_or_province"),
 *     @OA\Property(property="city", ref="#/components/schemas/WorkUnitEloquent/properties/city"),
 *     @OA\Property(property="address", ref="#/components/schemas/WorkUnitEloquent/properties/address"),
 *     @OA\Property(property="postcode", ref="#/components/schemas/WorkUnitEloquent/properties/postcode"),
 *     @OA\Property(property="phone", ref="#/components/schemas/WorkUnitEloquent/properties/phone"),
 *     @OA\Property(property="fax", ref="#/components/schemas/WorkUnitEloquent/properties/fax"),
 *     @OA\Property(property="email", ref="#/components/schemas/WorkUnitEloquent/properties/email"),
 *     @OA\Property(property="url", ref="#/components/schemas/WorkUnitEloquent/properties/url")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateWorkUnitEloquent",
 *     description="Update work unit eloquent",
 *     title="Update work unit eloquent",
 *     required={"id", "company_id", "name", "slug"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateWorkUnitEloquent")
 *     }
 * )
 */
