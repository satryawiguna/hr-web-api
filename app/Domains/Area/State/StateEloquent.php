<?php

namespace App\Domains\Area\State;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\Area\Country\CountryEloquent;
use App\Domains\Area\State\Contracts\StateInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="State eloquent",
 *     title="State eloquent",
 *     required={"country_id", "state_name"}
 * )
 * StateEloquent.
 */
class StateEloquent extends EloquentAbstract implements StateInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="country_id",
     *     type="integer",
     *     format="int64",
     *     description="Country id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="state_name",
     *     type="string",
     *     description="State name property"
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
    protected $table = StateInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'state_name'
    ];

    protected $searchable = [
        'country_id', 'state_name'
    ];

    protected $orderable = [
        'country_id', 'state_name'
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
    public function getCountryId()
    {
        return $this->country_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStateName()
    {
        return $this->state_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setStateName($state_name)
    {
        $this->state_name = $state_name;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function country()
    {
        return $this->belongsTo(CountryEloquent::class, 'country_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateStateEloquent",
 *     description="Create country eloquent",
 *     title="Create country eloquent",
 *     required={"country_id", "state_name"},
 *     @OA\Property(property="country_id", ref="#/components/schemas/StateEloquent/properties/country_id"),
 *     @OA\Property(property="state_name", ref="#/components/schemas/StateEloquent/properties/state_name")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateStateEloquent",
 *     description="Update country eloquent",
 *     title="Update country eloquent",
 *     required={"id", "country_id", "state_name"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateStateEloquent")
 *     }
 * )
 */
