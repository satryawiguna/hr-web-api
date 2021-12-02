<?php

namespace App\Domains\Commons\Access;

use App\Domains\Commons\Access\Contracts\AccessInterface;
use App\Domains\Commons\Permission\PermissionEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;

/**
 * @OA\Schema(
 *     description="Access eloquent",
 *     title="Access eloquent",
 *     required={"name", "slug"}
 * )
 * AccessEloquent.
 */
class AccessEloquent extends EloquentAbstract implements AccessInterface
{
    use Sluggable;

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

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  AccessInterface::TABLE_NAME;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquent::class, 'permission_accesses', 'access_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_accesses', 'access_id', 'user_id')
            ->withPivot(['permission_id']);
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
 *     schema="CreateAccessEloquent",
 *     description="Create access eloquent",
 *     title="Create access eloquent",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", ref="#/components/schemas/AccessEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/AccessEloquent/properties/slug"),
 *     @OA\Property(property="description", ref="#/components/schemas/AccessEloquent/properties/description"),
 *     @OA\Property(property="is_active", ref="#/components/schemas/AccessEloquent/properties/is_active")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateAccessEloquent",
 *     description="Update access eloquent",
 *     title="Update access eloquent",
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
 *          @OA\Schema(ref="#/components/schemas/CreateAccessEloquent")
 *     }
 * )
 */
