<?php

namespace App\Domains\Commons\VacancyLocation;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\Commons\VacancyLocation\Contracts\VacancyLocationInterface;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="VacancyLocation eloquent",
 *     title="VacancyLocation eloquent",
 *     required={"name", "slug"}
 * )
 * VacancyLocationEloquent.
 */
class VacancyLocationEloquent extends EloquentAbstract implements VacancyLocationInterface
{
    use SoftDeletes, Sluggable;

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
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     *
     * @var string
     */

     /**
     * @OA\Property(
     *     property="_lft",
     *     type="integer",
     *     description="_lft property",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     property="_rgt",
     *     type="integer",
     *     description="_rgt property",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     property="parent_id",
     *     type="integer",
     *     format="int64",
     *     description="Parent id property",
     *     example=1
     * )
     *
     * @var integer
     */

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  VacancyLocationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'country', '_lft', '_rgt', 'parent_id'
    ];

    protected $searchable = [
        'name', 'slug', 'country', '_lft', '_rgt', 'parent_id'
    ];

    protected $orderable = [
        'name', 'slug', 'country', '_lft', '_rgt', 'parent_id'
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
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLft()
    {
        return $this->_lft;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLft($_lft)
    {
        $this->_lft = $_lft;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRgt()
    {
        return $this->_rgt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRgt($_rgt)
    {
        $this->_rgt = $_rgt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentId()
    {
        return $this->parent_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vacancyLocationParent()
    {
        return $this->belongsTo(VacancyLocationEloquent::class, 'parent_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function vacancy()
    {
        return $this->hasMany(VacancyEloquent::class, 'vacancy_location_id');
    }

    public function vacancyLocationChilds()
    {
        return $this->hasMany(VacancyLocationEloquent::class, 'parent_id');
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
 *     schema="CreateVacancyLocationEloquent",
 *     description="Create gender eloquent",
 *     title="Create gender eloquent",
 *     required={"name", "slug", "_lft", "_rgt", "parent_id"},
 *     @OA\Property(property="name", ref="#/components/schemas/VacancyLocationEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/VacancyLocationEloquent/properties/slug"),
 *     @OA\Property(property="country", ref="#/components/schemas/VacancyLocationEloquent/properties/country"),
 *     @OA\Property(property="_lft", ref="#/components/schemas/VacancyLocationEloquent/properties/_lft"),
 *     @OA\Property(property="_rgt", ref="#/components/schemas/VacancyLocationEloquent/properties/_rgt"),
 *     @OA\Property(property="parent_id", ref="#/components/schemas/VacancyLocationEloquent/properties/parent_id")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateVacancyLocationEloquent",
 *     description="Update gender eloquent",
 *     title="Update gender eloquent",
 *     required={"id","name", "slug", "_lft", "_rgt"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateVacancyLocationEloquent")
 *     }
 * )
 */