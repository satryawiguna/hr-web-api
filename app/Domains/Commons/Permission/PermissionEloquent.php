<?php

namespace App\Domains\Commons\Permission;

use App\Domains\Commons\Access\AccessEloquent;
use App\Domains\Commons\Permission\Contracts\PermissionInterface;
use App\Domains\Commons\Role\RoleEloquent;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Permission eloquent",
 *     title="Permission eloquent",
 *     required={"name", "slug", "server", "path"}
 * )
 *
 * PermissionEloquent.
 */
class PermissionEloquent extends EloquentAbstract implements PermissionInterface
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
     *     property="server",
     *     type="string",
     *     description="Server property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     description="Path property"
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

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  PermissionInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'server', 'path', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'name', 'slug', 'server', 'path', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'name', 'slug', 'server', 'path', 'description', 'is_active', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    

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
    public function getServer()
    {
        return $this->server;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_permissions', 'permission_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleEloquent::class, 'role_permissions', 'permission_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function accesses()
    {
        return $this->belongsToMany(AccessEloquent::class, 'permission_accesses', 'permission_id', 'access_id')
            ->withPivot('type', 'value');
    }

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
 *     schema="CreatePermissionEloquent",
 *     description="Create permission eloquent",
 *     title="Create permission eloquent",
 *     required={"name", "slug", "server", "path"},
 *     @OA\Property(property="name", ref="#/components/schemas/PermissionEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/PermissionEloquent/properties/slug"),
 *     @OA\Property(property="server", ref="#/components/schemas/PermissionEloquent/properties/server"),
 *     @OA\Property(property="path", ref="#/components/schemas/PermissionEloquent/properties/path"),
 *     @OA\Property(property="description", ref="#/components/schemas/PermissionEloquent/properties/description"),
 *     @OA\Property(property="is_active", ref="#/components/schemas/PermissionEloquent/properties/is_active"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdatePermissionEloquent",
 *     description="Update permission eloquent",
 *     title="Update permission eloquent",
 *     required={"id", "name", "slug", "server", "path"},
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
 *          @OA\Schema(ref="#/components/schemas/CreatePermissionEloquent")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdatePermissionAccessEloquent",
 *     description="Update permission access eloquent",
 *     title="Update permission access eloquent",
 *     required={"id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="Id property",
 *          example=1
 *     ),
 *     @OA\Property(
 *         property="access_ids",
 *         description="Access ids property",
 *         example={{1, "READ", "ALLOW"},{2, "WRITE", "DENY"}}
 *     ),
 * )
 */
