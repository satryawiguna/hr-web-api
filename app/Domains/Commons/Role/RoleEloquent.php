<?php

namespace App\Domains\Commons\Role;


use App\Domains\Commons\Group\GroupEloquent;
use App\Domains\Commons\Permission\PermissionEloquent;
use App\Domains\Commons\Role\Contracts\RoleInterface;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Role eloquent",
 *     title="Role eloquent",
 *     required={"name", "slug"}
 * )
 *
 * RoleEloquent.
 */
class RoleEloquent extends EloquentAbstract implements RoleInterface
{
    use SoftDeletes, Sluggable;

    /**
     * @OA\Property(
     *     property="group_id",
     *     type="integer",
     *     format="int32",
     *     description="Group id property",
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
    protected $table = RoleInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'group_id', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'group_id', 'name', 'slug', 'description', 'is_active', 'created_by', 'modified_by'
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
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(GroupEloquent::class, 'group_id');
    }

    //</editor-fold>


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquent::class, 'role_permissions', 'role_id', 'permission_id')
            ->withPivot('type', 'value');
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
 *     schema="CreateRoleEloquent",
 *     description="Create role eloquent",
 *     title="Create role eloquent",
 *     required={"group_id", "name", "slug", "description", "is_active"},
 *     @OA\Property(property="group_id", ref="#/components/schemas/RoleEloquent/properties/group_id"),
 *     @OA\Property(property="name", ref="#/components/schemas/RoleEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/RoleEloquent/properties/slug"),
 *     @OA\Property(property="description", ref="#/components/schemas/RoleEloquent/properties/description"),
 *     @OA\Property(property="is_active", ref="#/components/schemas/RoleEloquent/properties/is_active"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateRoleEloquent",
 *     description="Update role eloquent",
 *     title="Update role eloquent",
 *     required={"id", "name", "slug"},
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(
 *                   property="id",
 *                   type="integer",
 *                   format="int32",
 *                   description="Id property",
 *                   example=1
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/CreateRoleEloquent")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateRolePermissionEloquent",
 *     description="Update role permission eloquent",
 *     title="Update role permission eloquent",
 *     required={"id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="Id property",
 *          example=1
 *     ),
 *     @OA\Property(
 *         property="permission_ids",
 *         description="Permission ids property",
 *         example={{1, "READ", "ALLOW"},{2, "WRITE", "DENY"}}
 *     ),
 * )
 */
