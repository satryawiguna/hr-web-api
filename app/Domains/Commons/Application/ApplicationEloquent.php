<?php

namespace App\Domains\Commons\Application;

use App\Domains\Commons\Application\Contracts\ApplicationInterface;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Group\GroupEloquent;
use App\Domains\Commons\Permission\PermissionEloquent;
use App\Domains\Commons\Role\RoleEloquent;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Application eloquent",
 *     title="Application eloquent",
 *     required={"name", "slug"}
 * )
 * ApplicationEloquent.
 */
class ApplicationEloquent extends EloquentAbstract implements ApplicationInterface
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
    protected $table = ApplicationInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

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

    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_applications', 'application_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function companies()
    {
        return $this->belongsToMany(CompanyEloquent::class, 'company_applications', 'application_id', 'company_id');
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
 *     schema="CreateApplicationEloquent",
 *     description="Create application eloquent",
 *     title="Create application eloquent",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", ref="#/components/schemas/ApplicationEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/ApplicationEloquent/properties/slug"),
 *     @OA\Property(property="description", ref="#/components/schemas/ApplicationEloquent/properties/description")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateApplicationEloquent",
 *     description="Update application eloquent",
 *     title="Update application eloquent",
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
 *          @OA\Schema(ref="#/components/schemas/CreateApplicationEloquent")
 *     }
 * )
 */
