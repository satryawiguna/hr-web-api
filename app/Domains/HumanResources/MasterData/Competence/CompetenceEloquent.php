<?php

namespace App\Domains\HumanResources\MasterData\Competence;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Competence eloquent",
 *     title="Competence eloquent",
 *     required={"code", "name", "slug"}
 * )
 * CompetenceEloquent.
 */
class CompetenceEloquent extends EloquentAbstract implements CompetenceInterface
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
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
     *
     * @var string
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
    protected $table =  CompetenceInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'code', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'company_id', 'code', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'company_id', 'code', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    //</editor-fold>

    //<editor-fold desc="#has one relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function workCompetence()
    {
        return $this->hasOne(WorkCompetenceEloquent::class, 'competence_id');
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

    /**
     * @param Builder $query
     * @param Model $model
     * @param $attribute
     * @param $config
     * @param $slug
     * @return mixed
     */
    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug)
    {
        return $query->where('company_id', $config['company_id']);
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateCompetenceEloquent",
 *     description="Create competence eloquent",
 *     title="Create competence eloquent",
 *     required={"company_id", "code", "name", "slug"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/CompetenceEloquent/properties/company_id"),
 *     @OA\Property(property="code", ref="#/components/schemas/CompetenceEloquent/properties/code"),
 *     @OA\Property(property="name", ref="#/components/schemas/CompetenceEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/CompetenceEloquent/properties/slug"),
 *     @OA\Property(property="description", ref="#/components/schemas/CompetenceEloquent/properties/description")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateCompetenceEloquent",
 *     description="Update competence eloquent",
 *     title="Update competence eloquent",
 *     required={"id", "company_id", "code", "name", "slug"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateCompetenceEloquent")
 *     }
 * )
 */