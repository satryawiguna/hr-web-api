<?php

namespace App\Domains\HumanResources\Recruitment\Applicant;

use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantInterface;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\User\Profile\ProfileEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Applicant eloquent",
 *     title="Applicant eloquent",
 *     required={"profile_id", "gender_id", "religion_id", "marital_status_id", "identity_number", "identity_expired_date", "identity_address", "passport_number", "passport_expired_date", "visa_number", "visa_expired_number", "birth_date", "birth_place", "age", "weight", "height", "linkedin", "facebook", "instagram", "skype", "website"}
 * )
 * ApplicantEloquent.
 */
class ApplicantEloquent extends EloquentAbstract implements ApplicantInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="profile_id",
     *     description="Profile id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="gender_id",
     *     description="Gender id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="religion_id",
     *     description="Religion id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="marital_status_id",
     *     description="Marital status id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     property="identity_number",
     *     description="Identity number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="identity_expired_date",
     *     description="Identity expired date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="identity_address",
     *     description="Identity address property",
     *     type="string",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="passport_number",
     *     description="Passport number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="passport_expired_date",
     *     description="Passport expired date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="visa_number",
     *     type="integer",
     *     format="int32",
     *     description="Visa number property",
     *     example=13213213
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="visa_expired_date",
     *     description="Visa expired date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="birth_date",
     *     description="Birth date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="birth_place",
     *     type="string",
     *     description="Birth place property"
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="age",
     *     type="integer",
     *     format="int32",
     *     description="Age property",
     *     example=20
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="weight",
     *     type="integer",
     *     format="int32",
     *     description="Weight property",
     *     example=80
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="height",
     *     type="integer",
     *     format="int32",
     *     description="Height property",
     *     example=80
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="linkedin",
     *     type="string",
     *     description="Linkedin property"
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="facebook",
     *     type="string",
     *     description="Facebook property"
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="instagram",
     *     type="string",
     *     description="Instagram property"
     * )
     * @var string
     */

     /**
     * @OA\Property(
     *     property="skype",
     *     type="string",
     *     description="Skype property"
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="website",
     *     type="string",
     *     description="Website property"
     * )
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
    protected $table =  ApplicantInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_id', 'gender_id', 'religion_id', 'marital_status_id', 'identity_number', 'identity_expired_date', 'identity_address', 'passport_number', 'passport_expired_date', 'visa_number', 'visa_expired_date', 'birth_date', 'birth_place', 'age', 'weight', 'height', 'linkedin', 'facebook', 'instagram', 'skype', 'website', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'profile_id', 'gender_id', 'religion_id', 'marital_status_id', 'identity_number', 'identity_expired_date', 'identity_address', 'passport_number', 'passport_expired_date', 'visa_number', 'visa_expired_date', 'birth_date', 'birth_place', 'age', 'weight', 'height', 'linkedin', 'facebook', 'instagram', 'skype', 'website', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'profile_id', 'gender_id', 'religion_id', 'marital_status_id', 'identity_number', 'identity_expired_date', 'identity_address', 'passport_number', 'passport_expired_date', 'visa_number', 'visa_expired_date', 'birth_date', 'birth_place', 'age', 'weight', 'height', 'linkedin', 'facebook', 'instagram', 'skype', 'website', 'created_by', 'modified_by'
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
    public function getProfileId()
    {
        return $this->profile_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGenderId()
    {
        return $this->gender_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setGenderId($gender_id)
    {
        $this->gender_id = $gender_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReligionId()
    {
        return $this->religion_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReligionId($religion_id)
    {
        $this->religion_id = $religion_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaritalStatusId()
    {
        return $this->marital_status_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMaritalStatusId($marital_status_id)
    {
        $this->marital_status_id = $marital_status_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityNumber()
    {
        return $this->identity_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentityNumber($identity_number)
    {
        $this->identity_number = $identity_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityExpiredDate()
    {
        return $this->identity_expired_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentityExpiredDate($identity_expired_date)
    {
        $this->identity_expired_date = $identity_expired_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityAddress()
    {
        return $this->identity_address;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentityAddress($identity_address)
    {
        $this->identity_address = $identity_address;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassportNumber()
    {
        return $this->passport_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassportNumber($passport_number)
    {
        $this->passport_number = $passport_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassportExpiredDate()
    {
        return $this->passport_expired_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassportExpiredDate($passport_expired_date)
    {
        $this->passport_expired_date = $passport_expired_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisaNumber()
    {
        return $this->visa_number;
    }

    /**
     * {@inheritdoc}
     */
    public function setVisaNumber($visa_number)
    {
        $this->visa_number = $visa_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisaExpiredDate()
    {
        return $this->visa_expired_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setVisaExpiredDate($visa_expired_date)
    {
        $this->visa_expired_date = $visa_expired_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthPlace()
    {
        return $this->birth_place;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBirthPlace($birth_place)
    {
        $this->birth_place = $birth_place;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAge()
    {
        return $this->age;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFacebook()
    {
        return $this->facebook;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstagram()
    {
        return $this->instagram;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkype()
    {
        return $this->skype;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsite()
    {
        return $this->website;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setWebsite($website)
    {
        $this->website = $website;
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

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(ProfileEloquent::class, 'profile_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function gender()
    {
        return $this->belongsTo(GenderEloquent::class, 'gender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function religion()
    {
        return $this->belongsTo(ReligionEloquent::class, 'religion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatusEloquent::class, 'marital_status_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateApplicantEloquent",
 *     description="Create applicant eloquent",
 *     title="Create applicant eloquent",
 *     required={"gender_id", "religion_id", "marital_status_id", "identity_number", "identity_expired_date", "identity_address", "passport_number", "passport_expired_date", "visa_number", "visa_expired_number", "birth_date", "birth_place", "age", "weight", "height", "linkedin", "facebook", "instagram", "skype", "website"},
 *     @OA\Property(property="gender_id", ref="#/components/schemas/ApplicantEloquent/properties/gender_id"),
 *     @OA\Property(property="religion_id", ref="#/components/schemas/ApplicantEloquent/properties/religion_id"),
 *     @OA\Property(property="marital_status_id", ref="#/components/schemas/ApplicantEloquent/properties/marital_status_id"),
 *     @OA\Property(property="identity_number", ref="#/components/schemas/ApplicantEloquent/properties/identity_number"),
 *     @OA\Property(property="identity_expired_date", ref="#/components/schemas/ApplicantEloquent/properties/identity_expired_date"),
 *     @OA\Property(property="identity_address", ref="#/components/schemas/ApplicantEloquent/properties/identity_address"),
 *     @OA\Property(property="passport_number", ref="#/components/schemas/ApplicantEloquent/properties/passport_number"),
 *     @OA\Property(property="passport_expired_date", ref="#/components/schemas/ApplicantEloquent/properties/passport_expired_date"),
 *     @OA\Property(property="visa_number", ref="#/components/schemas/ApplicantEloquent/properties/visa_number"),
 *     @OA\Property(property="visa_expired_date", ref="#/components/schemas/ApplicantEloquent/properties/visa_expired_date"),
 *     @OA\Property(property="birth_date", ref="#/components/schemas/ApplicantEloquent/properties/birth_date"),
 *     @OA\Property(property="birth_place", ref="#/components/schemas/ApplicantEloquent/properties/birth_place"),
 *     @OA\Property(property="age", ref="#/components/schemas/ApplicantEloquent/properties/age"),
 *     @OA\Property(property="weight", ref="#/components/schemas/ApplicantEloquent/properties/weight"),
 *     @OA\Property(property="height", ref="#/components/schemas/ApplicantEloquent/properties/height"),
 *     @OA\Property(property="linkedin", ref="#/components/schemas/ApplicantEloquent/properties/linkedin"),
 *     @OA\Property(property="facebook", ref="#/components/schemas/ApplicantEloquent/properties/facebook"),
 *     @OA\Property(property="instagram", ref="#/components/schemas/ApplicantEloquent/properties/instagram"),
 *     @OA\Property(property="skype", ref="#/components/schemas/ApplicantEloquent/properties/skype"),
 *     @OA\Property(property="website", ref="#/components/schemas/ApplicantEloquent/properties/website"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateApplicantEloquent",
 *     description="Update applicant eloquent",
 *     title="Update applicant eloquent",
 *     required={"gender_id", "religion_id", "marital_status_id", "identity_number", "identity_expired_date", "identity_address", "passport_number", "passport_expired_date", "visa_number", "visa_expired_number", "birth_date", "birth_place", "age", "weight", "height", "linkedin", "facebook", "instagram", "skype", "website"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateApplicantEloquent")
 *     }
 * )
 */

