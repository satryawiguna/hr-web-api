<?php

namespace App\Domains\HumanResources\Element;

use App\Domains\HumanResources\Element\Contracts\ElementInterface;
use App\Domains\HumanResources\Element\ElementEntry\ElementEntryEloquent;
use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use App\Domains\HumanResources\Formula\FormulaEloquent;
use App\Domains\HumanResources\Formula\FormulaResult\FormulaResultEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Element eloquent",
 *     title="Element eloquent",
 *     required={"code", "name", "slug"}
 * )
 * ElementEloquent.
 */
class ElementEloquent extends EloquentAbstract implements ElementInterface
{
    use SoftDeletes, Sluggable;

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
     *     property="formula_id",
     *     type="integer",
     *     format="int64",
     *     description="Formula id property",
     *     example=1
     * )
     *
     * @var integer
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
    protected $table =  ElementInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'slug', 'formula_id', 'seq_no', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'code', 'name', 'slug', 'formula_id', 'seq_no', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'code', 'name', 'slug', 'formula_id', 'seq_no', 'created_by', 'modified_by'
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
    public function getFormulaId()
    {
        return $this->formula_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFormulaId($formula_id)
    {
        $this->formula_id = $formula_id;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementValues()
    {
        return $this->hasMany(ElementValueEloquent::class, 'element_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function elementEntries()
    {
        return $this->hasMany(ElementEntryEloquent::class, 'element_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function formulaResults()
    {
        return $this->hasMany(ElementEntryEloquent::class, 'element_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function payrollBalanceFeeds()
    {
        return $this->hasMany(ElementEntryEloquent::class, 'element_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function payrollElements()
    {
        return $this->hasMany(ElementEntryEloquent::class, 'element_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function formulas()
    {
        return $this->belongsToMany(FormulaEloquent::class, 'formula_results', 'formula_id', 'element_id');
    }

    //</editor-fold>

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
}

/**
 * @OA\Schema(
 *     schema="CreateElementEloquent",
 *     description="Create element eloquent",
 *     title="Create element eloquent",
 *     required={"code", "name", "slug"},
 *     @OA\Property(property="code", ref="#/components/schemas/ElementEloquent/properties/code"),
 *     @OA\Property(property="name", ref="#/components/schemas/ElementEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/ElementEloquent/properties/slug"),
 *     @OA\Property(property="seq_no", ref="#/components/schemas/ElementEloquent/properties/seq_no")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateElementEloquent",
 *     description="Update element eloquent",
 *     title="Update element eloquent",
 *     required={"id", "code", "name", "slug"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateElementEloquent")
 *     }
 * )
 */
