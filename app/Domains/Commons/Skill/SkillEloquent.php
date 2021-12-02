<?php

namespace App\Domains\Commons\Skill;

use App\Domains\Applicant\ApplicantEloquent;
use App\Domains\Commons\Skill\Contracts\SkillInterface;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Skill eloquent",
 *     title="Skill eloquent",
 *     required={"name", "slug"}
 * )
 * SkillEloquent.
 */
class SkillEloquent extends EloquentAbstract implements SkillInterface
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
    protected $table =  SkillInterface::TABLE_NAME;

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

    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function vacancy()
    {
        return $this->belongsToMany(VacancyEloquent::class, 'vacancy_skills', 'skill_id', 'vacancy_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    // public function vacancy_application()
    // {
    //     return $this->belongsToMany(VacancyApplicationEloquent::class, 'vacancy_application_skills', 'skill_id', 'vacancy_application_id');
    // }

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
 *     schema="CreateSkillEloquent",
 *     description="Create gender eloquent",
 *     title="Create gender eloquent",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", ref="#/components/schemas/SkillEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/SkillEloquent/properties/slug")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateSkillEloquent",
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
 *          @OA\Schema(ref="#/components/schemas/CreateSkillEloquent")
 *     }
 * )
 */
