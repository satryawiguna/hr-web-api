<?php

namespace App\Domains\Area\Country;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Area\Country\Contracts\CountryInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Country eloquent",
 *     title="Country eloquent",
 *     required={"country_name", "two_letter_code", "phone_code"}
 * )
 * CountryEloquent.
 */
class CountryEloquent extends EloquentAbstract implements CountryInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="country_name",
     *     type="string",
     *     description="Country name property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="two_letter_code",
     *     type="string",
     *     description="Two letter code property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="phone_code",
     *     type="string",
     *     description="Phone code property"
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
    protected $table = CountryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_name', 'two_letter_code', 'phone_code'
    ];

    protected $searchable = [
        'country_name', 'two_letter_code', 'phone_code'
    ];

    protected $orderable = [
        'country_name', 'two_letter_code', 'phone_code'
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
    public function getCountryName()
    {
        return $this->country_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountryName($country_name)
    {
        $this->country_name = $country_name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTwoLetterCode()
    {
        return $this->two_letter_code;
    }

    /**
     * {@inheritdoc}
     */
    public function setTwoLetterCode($two_letter_code)
    {
        $this->two_letter_code = $two_letter_code;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneCode()
    {
        return $this->phone_code;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoneCode($phone_code)
    {
        $this->phone_code = $phone_code;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function states()
    {
        // return $this->hasMany(EmployeeEloquent::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function cities()
    {
        // return $this->hasMany(ApplicantEloquent::class, 'country_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateCountryEloquent",
 *     description="Create country eloquent",
 *     title="Create country eloquent",
 *     required={"country_name", "two_letter_code", "phone_code"},
 *     @OA\Property(property="country_name", ref="#/components/schemas/CountryEloquent/properties/country_name"),
 *     @OA\Property(property="two_letter_code", ref="#/components/schemas/CountryEloquent/properties/two_letter_code"),
 *     @OA\Property(property="phone_code", ref="#/components/schemas/CountryEloquent/properties/phone_code")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateCountryEloquent",
 *     description="Update country eloquent",
 *     title="Update country eloquent",
 *     required={"id", "country_name", "two_letter_code", "phone_code"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateCountryEloquent")
 *     }
 * )
 */
