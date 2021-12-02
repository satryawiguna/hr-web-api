<?php

namespace App\Domains\HumanResources\Formula;

use App\Domains\HumanResources\Element\ElementEloquent;
use App\Domains\HumanResources\Element\ElementValue\ElementValueEloquent;
use App\Domains\HumanResources\Formula\Contracts\FormulaInterface;
use App\Domains\HumanResources\Formula\FormulaCategory\FormulaCategoryEloquent;
use App\Domains\HumanResources\Formula\FormulaResult\FormulaResultEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Formula eloquent",
 *     title="Formula eloquent",
 *     required={"formula_category_id", "name", "slug", "type"}
 * )
 * FormulaEloquent.
 */
class FormulaEloquent extends EloquentAbstract implements FormulaInterface
{
    use SoftDeletes, Sluggable;

    /**
     * @OA\Property(
     *     property="formula_category_id",
     *     type="integer",
     *     format="int64",
     *     description="Formula category id property",
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
     *     description="Type property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
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
    protected $table =  FormulaInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formula_category_id', 'name', 'slug', 'type', 'description', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'formula_category_id', 'name', 'slug', 'type', 'description', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'formula_category_id', 'name', 'slug', 'type', 'description', 'created_by', 'modified_by'
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
    public function getFormulaCategoryId()
    {
        return $this->formula_category_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormulaCategoryId($formula_category_id)
    {
        $this->formula_category_id = $formula_category_id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function elements()
    {
        return $this->hasMany(ElementEloquent::class, 'formula_id');
    }

    public function formulaResults()
    {
        return $this->hasMany(FormulaResultEloquent::class, 'formula_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function formulaCategory()
    {
        return $this->belongsTo(FormulaCategoryEloquent::class, 'formula_category_id');
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
 *     schema="CreateFormulaEloquent",
 *     description="Create formula eloquent",
 *     title="Create formula eloquent",
 *     required={"formula_category_id", "name", "slug", "type"},
 *     @OA\Property(property="formula_category_id", ref="#/components/schemas/FormulaEloquent/properties/formula_category_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/FormulaEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/FormulaEloquent/properties/slug"),
 *     @OA\Property(property="type", ref="#/components/schemas/FormulaEloquent/properties/type"),
 *     @OA\Property(property="description", ref="#/components/schemas/FormulaEloquent/properties/description")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateFormulaEloquent",
 *     description="Update formula eloquent",
 *     title="Update formula eloquent",
 *     required={"id", "formula_category_id", "name", "slug", "type"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateFormulaEloquent")
 *     }
 * )
 */
