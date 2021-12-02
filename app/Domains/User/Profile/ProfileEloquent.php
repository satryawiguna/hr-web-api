<?php

namespace App\Domains\User\Profile;

use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Domains\User\Profile\Contracts\ProfileInterface;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\HumanResources\Recruitment\Applicant\ApplicantEloquent;

/**
 * @OA\Schema(
 *     description="Profile eloquent",
 *     title="Profile eloquent",
 *     required={"user_id", "full_name", "nick_name", "email"}
 * )
 * ProfileEloquent.
 */
class ProfileEloquent extends EloquentAbstract implements ProfileInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="user_id",
     *     description="User id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="full_name",
     *     description="Full name property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="nick_name",
     *     description="Nick name property",
     *     type="string"
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
     *     property="mobile",
     *     type="string",
     *     description="Mobile property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="email",
     *     description="Email property",
     *     type="string",
     *     example="bs@gmail.com"
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
    protected $table =  ProfileInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'full_name', 'nick_name', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'mobile', 'email', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'user_id', 'full_name', 'nick_name', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'mobile', 'email', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'user_id', 'full_name', 'nick_name', 'country', 'state_or_province', 'city', 'address', 'postcode', 'phone', 'mobile', 'email', 'created_by', 'modified_by'
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
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->full_name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNickName()
    {
        return $this->nick_name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNickName($nick_name)
    {
        $this->nick_name = $nick_name;
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
    public function getMobile()
    {
        return $this->mobile;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
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


    //<editor-fold desc="belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function user()
    {
        return $this->belongsTo(UserEloquent::class, 'user_id');
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

    public function applicant()
    {
        return $this->hasOne(ApplicantEloquent::class, 'profile_id');
    }

    //</editor-fold>


    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateProfileEloquent",
 *     description="Create profile eloquent",
 *     title="Create profile eloquent",
 *     required={"full_name", "nick_name", "country", "state_or_province", "city", "address", "email"},
 *     @OA\Property(property="full_name", ref="#/components/schemas/ProfileEloquent/properties/full_name"),
 *     @OA\Property(property="nick_name", ref="#/components/schemas/ProfileEloquent/properties/nick_name"),
 *     @OA\Property(property="country", ref="#/components/schemas/ProfileEloquent/properties/country"),
 *     @OA\Property(property="state_or_province", ref="#/components/schemas/ProfileEloquent/properties/state_or_province"),
 *     @OA\Property(property="city", ref="#/components/schemas/ProfileEloquent/properties/city"),
 *     @OA\Property(property="address", ref="#/components/schemas/ProfileEloquent/properties/address"),
 *     @OA\Property(property="postcode", ref="#/components/schemas/ProfileEloquent/properties/postcode"),
 *     @OA\Property(property="phone", ref="#/components/schemas/ProfileEloquent/properties/phone"),
 *     @OA\Property(property="mobile", ref="#/components/schemas/ProfileEloquent/properties/mobile"),
 *     @OA\Property(property="email", ref="#/components/schemas/ProfileEloquent/properties/email")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateProfileEloquent",
 *     description="Update profile eloquent",
 *     title="Update profile eloquent",
 *     required={"id","full_name", "nick_name", "country", "state_or_province", "city", "address", "email"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateProfileEloquent")
 *     }
 * )
 */
