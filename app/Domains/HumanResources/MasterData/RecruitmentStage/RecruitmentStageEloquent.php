<?php

namespace App\Domains\HumanResources\MasterData\RecruitmentStage;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageInterface;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Recruitment Stage eloquent",
 *     title="Recruitment Stage eloquent",
 *     required={"company_id", "name", "slug", "color", "sort_order", "is_scheduled", "is_init", "is_hired", "is_reject"}
 * )
 * RecruitmentStageEloquent.
 */
class RecruitmentStageEloquent extends EloquentAbstract implements RecruitmentStageInterface
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
     *     property="color",
     *     type="string",
     *     description="Color property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="sort_order",
     *     type="integer",
     *     format="int32",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="is_scheduled",
     *     description="Is scheduled property",
     *     type="boolean"
     * )
     *
     * @var
     */

     /**
     * @OA\Property(
     *     property="is_init",
     *     description="Is init property",
     *     type="boolean"
     * )
     *
     * @var
     */

     /**
     * @OA\Property(
     *     property="is_hired",
     *     description="Is hired property",
     *     type="boolean"
     * )
     *
     * @var
     */

     /**
     * @OA\Property(
     *     property="is_reject",
     *     description="Is reject property",
     *     type="boolean"
     * )
     *
     * @var
     */

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  RecruitmentStageInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'slug', 'color', 'sort_order', 'is_scheduled', 'is_init', 'is_hired', 'is_reject'
    ];

    protected $searchable = [
        'company_id', 'name', 'slug', 'color', 'sort_order', 'is_scheduled', 'is_init', 'is_hired', 'is_reject'
    ];

    protected $orderable = [
        'company_id', 'name', 'slug', 'color', 'sort_order', 'is_scheduled', 'is_init', 'is_hired', 'is_reject'
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
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSortOrder($sort_order)
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsScheduled()
    {
        return $this->is_scheduled;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsScheduled($is_scheduled)
    {
        $this->is_scheduled = $is_scheduled;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsInit()
    {
        return $this->is_init;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsInit($is_init)
    {
        $this->is_init = $is_init;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsHired()
    {
        return $this->is_hired;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsHired($is_hired)
    {
        $this->is_hired = $is_hired;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsReject()
    {
        return $this->is_reject;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsReject($is_reject)
    {
        $this->is_reject = $is_reject;
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


    //<editor-fold desc="#has many relation">
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
 *     schema="CreateRecruitmentStageEloquent",
 *     description="Create recruitment stage eloquent",
 *     title="Create recruitment stage eloquent",
 *     required={"company_id", "name", "slug", "color", "sort_order", "is_scheduled", "is_init", "is_hired", "is_reject"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/RecruitmentStageEloquent/properties/company_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/RecruitmentStageEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/RecruitmentStageEloquent/properties/slug"),
 *     @OA\Property(property="color", ref="#/components/schemas/RecruitmentStageEloquent/properties/color"),
 *     @OA\Property(property="sort_order", ref="#/components/schemas/RecruitmentStageEloquent/properties/sort_order"),
 *     @OA\Property(property="is_scheduled", ref="#/components/schemas/RecruitmentStageEloquent/properties/is_scheduled"),
 *     @OA\Property(property="is_init", ref="#/components/schemas/RecruitmentStageEloquent/properties/is_init"),
 *     @OA\Property(property="is_hired", ref="#/components/schemas/RecruitmentStageEloquent/properties/is_hired"),
 *     @OA\Property(property="is_reject", ref="#/components/schemas/RecruitmentStageEloquent/properties/is_reject"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateRecruitmentStageEloquent",
 *     description="Update recruitment stage eloquent",
 *     title="Update recruitment stage eloquent",
 *     required={"id", "company_id", "name", "slug", "color", "sort_order", "is_scheduled", "is_init", "is_hired", "is_reject"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateRecruitmentStageEloquent")
 *     }
 * )
 */
