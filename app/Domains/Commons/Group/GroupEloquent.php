<?php

namespace App\Domains\Commons\Group;

use App\Domains\Commons\Application\ApplicationEloquent;
use App\Domains\Commons\Group\Contracts\GroupInterface;
use App\Domains\Commons\Role\RoleEloquent;
use App\Domains\User\UserEloquent;
use App\Infrastructures\EloquentAbstract;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Group eloquent",
 *     title="Group eloquent",
 *     required={"name", "slug", "description", "is_active"}
 * )
 * GroupEloquent.
 */
class GroupEloquent extends EloquentAbstract implements GroupInterface
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
     * Table name.
     *
     * @var string
     */
    protected $table =  GroupInterface::TABLE_NAME;

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
    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_groups', 'group_id', 'user_id');
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
 *     schema="CreateGroupEloquent",
 *     description="Create group eloquent",
 *     title="Create group eloquent",
 *     required={"name", "slug", "description", "is_active"},
 *     @OA\Property(property="name", ref="#/components/schemas/GroupEloquent/properties/name"),
 *     @OA\Property(property="slug", ref="#/components/schemas/GroupEloquent/properties/slug"),
 *     @OA\Property(property="description", ref="#/components/schemas/GroupEloquent/properties/description"),
 *     @OA\Property(property="is_active", ref="#/components/schemas/GroupEloquent/properties/is_active")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateGroupEloquent",
 *     description="Update group eloquent",
 *     title="Update group eloquent",
 *     required={"name", "slug", "description", "is_active"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateGroupEloquent")
 *     }
 * )
 */
