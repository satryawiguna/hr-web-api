<?php

namespace App\Domains\HumanResources\Element\ElementValue;

use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\ElementEntryValue\ElementEntryValueEloquent;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueInterface;
use App\Domains\HumanResources\Formula\FormulaResult\FormulaResultEloquent;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\PayrollBalanceFeedEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Element value eloquent",
 *     title="Element value eloquent",
 *     required={"element_id", "code", "name", "slug", "value", "seq_no"}
 * )
 * ElementValueEloquent.
 */
class ElementValueEloquent extends EloquentAbstract implements ElementValueInterface
{
    use SoftDeletes, Sluggable;

    /**
     * @OA\Property(
     *     property="element_id",
     *     type="integer",
     *     format="int64",
     *     description="Element id property",
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
     *     property="value",
     *     type="float",
     *     description="Value property",
     *     example="100"
     * )
     *
     * @var float
     */

    /**
     * @OA\Property(
     *     property="seq_no",
     *     type="string",
     *     description="Seq number property"
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
    protected $table =  ElementValueInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'element_id', 'code', 'name', 'slug', 'value', 'seq_no', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'element_id', 'code', 'name', 'slug', 'value', 'seq_no', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'element_id', 'code', 'name', 'slug', 'value', 'seq_no', 'created_by', 'modified_by'
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
    public function getElementId()
    {
        return $this->element_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setElementId($element_id)
    {
        $this->element_id = $element_id;
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
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSeqNo()
    {
        return $this->seq_no;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSeqNo($seq_no)
    {
        $this->seq_no = $seq_no;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function formulaResults()
    {
        return $this->hasMany(FormulaResultEloquent::class, 'element_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function elementEntryValues()
    {
        return $this->hasMany(ElementEntryValueEloquent::class, 'element_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function payrollBalanceFeeds()
    {
        return $this->hasMany(PayrollBalanceFeedEloquent::class, 'element_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function payrollElementValues()
    {
        return $this->hasMany(PayrollElementValueEloquent::class, 'element_value_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function element()
    {
        return $this->belongsTo(ElementEloquent::class, 'element_id');
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

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateElementValueEloquent",
 *     description="Create element value eloquent",
 *     title="Create element value eloquent",
 *     required={"element_id", "code", "name", "slug", "value", "seq_no"},
 *     @OA\Property(property="element_id", ref="#/components/schemas/ElementValueEloquent/properties/element_id"),
 *     @OA\Property(property="code", ref="#/components/schemas/ElementValueEloquent/properties/code"),
 *     @OA\Property(property="name", ref="#/components/schemas/ElementValueEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/ElementValueEloquent/properties/slug"),
 *     @OA\Property(property="value", ref="#/components/schemas/ElementValueEloquent/properties/value"),
 *     @OA\Property(property="seq_no", ref="#/components/schemas/ElementValueEloquent/properties/seq_no")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateElementValueEloquent",
 *     description="Update element value eloquent",
 *     title="Update element value eloquent",
 *     required={"id", "element_id", "code", "name", "slug", "value", "seq_no"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateElementValueEloquent")
 *     }
 * )
 */
