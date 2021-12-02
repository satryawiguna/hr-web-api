<?php

namespace App\Domains\Area\City;

use App\Domains\Area\City\Contracts\CityInterface;
use App\Domains\Area\State\StateEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="City eloquent",
 *     title="City eloquent",
 *     required={"state_id", "city_name"}
 * )
 * CityEloquent.
 */
class CityEloquent extends EloquentAbstract implements CityInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="state_id",
     *     type="integer",
     *     format="int64",
     *     description="State id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="city_name",
     *     type="string",
     *     description="City name property"
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
    protected $table = CityInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id', 'city_name'
    ];

    protected $searchable = [
        'state_id', 'city_name'
    ];

    protected $orderable = [
        'state_id', 'city_name'
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
    public function getStateId()
    {
        return $this->state_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStateId($state_id)
    {
        $this->state_id = $state_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * {@inheritdoc}
     */
    public function setCityName($city_name)
    {
        $this->city_name = $city_name;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function state()
    {
        return $this->belongsTo(StateEloquent::class, 'state_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateCityEloquent",
 *     description="Create state eloquent",
 *     title="Create state eloquent",
 *     required={"state_id", "city_name"},
 *     @OA\Property(property="state_id", ref="#/components/schemas/CityEloquent/properties/state_id"),
 *     @OA\Property(property="city_name", ref="#/components/schemas/CityEloquent/properties/city_name")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateCityEloquent",
 *     description="Update state eloquent",
 *     title="Update state eloquent",
 *     required={"id", "state_id", "city_name"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateCityEloquent")
 *     }
 * )
 */
