<?php

namespace App\Domains\HumanResources\Personal\Employee\Child;

use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Child eloquent",
 *     title="Child eloquent",
 *     required={"employee_id", "full_name", "nick_name", "gender_id", "order"}
 * )
 * ChildEloquent.
 */
class ChildEloquent extends EloquentAbstract implements ChildInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="employee_id",
     *     description="Employee id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
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
     *     property="order",
     *     description="Order property",
     *     type="integer",
     *     format="int32",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="birth_place",
     *     description="Birth place property",
     *     type="string"
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
     *     property="has_bpjs_kesehatan",
     *     description="Has BPJS kesehatan property",
     *     type="boolean"
     * )
     *
     * @var boolean
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_number",
     *     description="BPJS kesehatan number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_date",
     *     description="BPJS kesehatan date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="bpjs_kesehatan_class",
     *     description="BPJS kesehatan class property",
     *     type="string",
     *     enum={"I","II","III"},
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
    protected $table =  ChildInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'full_name', 'nick_name', 'gender_id', 'order', 'birth_place', 'birth_date', 'has_bpjs_kesehatan', 'bpjs_kesehatan_number', 'bpjs_kesehatan_date', 'bpjs_kesehatan_class', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'full_name', 'nick_name', 'gender_id', 'order', 'birth_place', 'birth_date', 'has_bpjs_kesehatan', 'bpjs_kesehatan_number', 'bpjs_kesehatan_date', 'bpjs_kesehatan_class', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'full_name', 'nick_name', 'gender_id', 'order', 'birth_place', 'birth_date', 'has_bpjs_kesehatan', 'bpjs_kesehatan_number', 'bpjs_kesehatan_date', 'bpjs_kesehatan_class', 'created_by', 'modified_by'
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
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
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
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOrder($order)
    {
        $this->order = $order;
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
    public function getHasBpjsKesehatan()
    {
        return $this->has_bpjs_kesehatan;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setHasBpjsKesehatan($has_bpjs_kesehatan)
    {
        $this->has_bpjs_kesehatan = $has_bpjs_kesehatan;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanNumber()
    {
        return $this->bpjs_kesehatan_number;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanNumber($bpjs_kesehatan_number)
    {
        $this->bpjs_kesehatan_number = $bpjs_kesehatan_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanDate()
    {
        return $this->bpjs_kesehatan_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanDate($bpjs_kesehatan_date)
    {
        $this->bpjs_kesehatan_date = $bpjs_kesehatan_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBpjsKesehatanClass()
    {
        return $this->bpjs_kesehatan_class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBpjsKesehatanClass($bpjs_kesehatan_class)
    {
        $this->bpjs_kesehatan_class = $bpjs_kesehatan_class;
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
    public function employee()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function gender()
    {
        return $this->belongsTo(GenderEloquent::class, 'gender_id');
    }

    //</editor-fold>

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateChildEloquent",
 *     description="Create child eloquent",
 *     title="Create child eloquent",
 *     required={"employee_id", "full_name", "nick_name", "gender_id", "order"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/ChildEloquent/properties/employee_id"),
 *     @OA\Property(property="full_name", ref="#/components/schemas/ChildEloquent/properties/full_name"),
 *     @OA\Property(property="nick_name", ref="#/components/schemas/ChildEloquent/properties/nick_name"),
 *     @OA\Property(property="gender_id", ref="#/components/schemas/ChildEloquent/properties/gender_id"),
 *     @OA\Property(property="order", ref="#/components/schemas/ChildEloquent/properties/order"),
 *     @OA\Property(property="birth_place", ref="#/components/schemas/ChildEloquent/properties/birth_place"),
 *     @OA\Property(property="birth_date", ref="#/components/schemas/ChildEloquent/properties/birth_date"),
 *     @OA\Property(property="has_bpjs_kesehatan", ref="#/components/schemas/ChildEloquent/properties/has_bpjs_kesehatan"),
 *     @OA\Property(property="bpjs_kesehatan_number", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_number"),
 *     @OA\Property(property="bpjs_kesehatan_date", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_date"),
 *     @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_class"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateChildEloquent",
 *     description="Update child eloquent",
 *     title="Update child eloquent",
 *     required={"id", "employee_id", "full_name", "nick_name", "gender_id", "order"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateChildEloquent")
 *     }
 * )
 */
