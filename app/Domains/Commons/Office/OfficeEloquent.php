<?php

namespace App\Domains\Commons\Office;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\Office\Contracts\OfficeInterface;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Office eloquent",
 *     title="Office eloquent",
 *     required={"company_id", "name", "slug", "type", "country", "state_or_province", "city", "address", "phone"}
 * )
 * OfficeEloquent.
 */
class OfficeEloquent extends EloquentAbstract implements OfficeInterface
{
    use SoftDeletes, Sluggable;

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
     *     property="type",
     *     type="string",
     *     description="Type property",
     *     enum={"HEAD", "BRANCH"},
     *     example="HEAD"
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
     *     description="State or province property"
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
     *     property="latitude",
     *     type="float",
     *     description="Latitude property"
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="longitude",
     *     type="float",
     *     description="Longitude property"
     * )
     *
     * @var float
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
    protected $table =  OfficeInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'slug', 'type', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'latitude', 'longitude', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'company_id', 'name', 'slug', 'type', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'latitude', 'longitude', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'company_id', 'name', 'slug', 'type', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'fax', 'email', 'latitude', 'longitude', 'is_active', 'created_by', 'modified_by'
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
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
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class,'company_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_company_offices', 'office_id', 'user_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function employees()
    {
        return $this->hasMany(EmployeeEloquent::class, 'office_id');
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
 *     schema="CreateOfficeEloquent",
 *     description="Create office eloquent",
 *     title="Create office eloquent",
 *     required={"company_id", "name", "slug", "type", "country", "state_or_province", "city", "address", "phone"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/OfficeEloquent/properties/company_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/OfficeEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/OfficeEloquent/properties/slug"),
 *     @OA\Property(property="type", ref="#/components/schemas/OfficeEloquent/properties/type"),
 *     @OA\Property(property="country", ref="#/components/schemas/OfficeEloquent/properties/country"),
 *     @OA\Property(property="state_or_province", ref="#/components/schemas/OfficeEloquent/properties/state_or_province"),
 *     @OA\Property(property="city", ref="#/components/schemas/OfficeEloquent/properties/city"),
 *     @OA\Property(property="address", ref="#/components/schemas/OfficeEloquent/properties/address"),
 *     @OA\Property(property="postcode", ref="#/components/schemas/OfficeEloquent/properties/postcode"),
 *     @OA\Property(property="phone", ref="#/components/schemas/OfficeEloquent/properties/phone"),
 *     @OA\Property(property="fax", ref="#/components/schemas/OfficeEloquent/properties/fax"),
 *     @OA\Property(property="email", ref="#/components/schemas/OfficeEloquent/properties/email"),
 *     @OA\Property(property="latitude", ref="#/components/schemas/OfficeEloquent/properties/latitude"),
 *     @OA\Property(property="longitude", ref="#/components/schemas/OfficeEloquent/properties/longitude")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateOfficeEloquent",
 *     description="Update office eloquent",
 *     title="Update office eloquent",
 *     required={"id", "company_id", "name", "slug", "type", "country", "state_or_province", "city", "address", "phone"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateOfficeEloquent")
 *     }
 * )
 */
