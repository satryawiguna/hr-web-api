<?php

namespace App\Domains\Commons\VacancyCategory;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\VacancyCategory\Contracts\VacancyCategoryInterface;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="VacancyCategory eloquent",
 *     title="VacancyCategory eloquent",
 *     required={"name", "slug"}
 * )
 * VacancyCategoryEloquent.
 */
class VacancyCategoryEloquent extends EloquentAbstract implements VacancyCategoryInterface
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

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = VacancyCategoryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    protected $searchable = [
        'name', 'slug'
    ];

    protected $orderable = [
        'name', 'slug'
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

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    //<editor-fold desc="#has many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function vacancy()
    {
        return $this->hasMany(VacancyEloquent::class, 'vacancy_category_id');
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
 *     schema="CreateVacancyCategoryEloquent",
 *     description="Create gender eloquent",
 *     title="Create gender eloquent",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", ref="#/components/schemas/VacancyCategoryEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/VacancyCategoryEloquent/properties/slug")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateVacancyCategoryEloquent",
 *     description="Update gender eloquent",
 *     title="Update gender eloquent",
 *     required={"id", "name", "slug"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateVacancyCategoryEloquent")
 *     }
 * )
 */
