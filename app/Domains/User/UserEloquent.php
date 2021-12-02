<?php
namespace App\Domains\User;


use App\Domain\Auth\OAuthAccessToken;
use App\Domains\Auth\OAuthAccessToken\OAuthAccessTokenEloquent;
use App\Domains\Commons\Access\AccessEloquent;
use App\Domains\Commons\Application\ApplicationEloquent;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Group\GroupEloquent;
use App\Domains\Commons\Permission\PermissionEloquent;
use App\Domains\User\Profile\ProfileEloquent;
use App\Domains\Commons\Role\RoleEloquent;
use App\Domains\User\Contracts\UserInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     description="User eloquent",
 *     title="User eloquent",
 *     required={"company_id", "username", "email", "password"}
 * )
 *
 * UserEloquent.
 */
class UserEloquent extends EloquentAbstract implements UserInterface
{
    use HasApiTokens, Notifiable, SoftDeletes;


    //<editor-fold desc="#field">

    /**
     * @OA\Property(
     *     property="username",
     *     type="string",
     *     description="Username property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="Password property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="remember_token",
     *     type="string",
     *     description="Remember token property"
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
     *     property="is_block",
     *     type="integer",
     *     format="int32",
     *     description="Is block property (blocked = 1; not unblocked = 0)"
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="created_by",
     *     type="string",
     *     format="datetime",
     *     description="Created by property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="modified_by",
     *     type="string",
     *     format="datetime",
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
    protected $table = UserInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'remember_token', 'is_active', 'is_block', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'username', 'email', 'password', 'remember_token', 'is_active', 'is_block', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'username', 'email', 'password', 'remember_token', 'is_active', 'is_block', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password', 'pivot'
    ];

    protected $dates = [
        'deleted_at'
    ];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberToken($remember_token)
    {
        $this->remember_token = $remember_token;
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
    public function getIsBlock()
    {
        return $this->is_block;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsBlock($is_block)
    {
        $this->is_block = $is_block;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param $created_by
     * @return $this|mixed
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param $modified_by
     * @return $this|mixed
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function companies()
    {
        return $this->belongsToMany(CompanyEloquent::class, 'user_companies', 'user_id', 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function applications()
    {
        return $this->belongsToMany(ApplicationEloquent::class, 'user_applications', 'user_id', 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function groups()
    {
        return $this->belongsToMany(GroupEloquent::class, 'user_groups', 'user_id', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleEloquent::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquent::class, 'user_permissions', 'user_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function accesses()
    {
        return $this->belongsToMany(AccessEloquent::class, 'user_accesses', 'user_id', 'access_id')
            ->withPivot('permission_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has one relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function profile()
    {
        return $this->hasOne(ProfileEloquent::class, 'user_id');
    }

    public function oAuthAccessTokens()
    {
        return $this->hasMany(OAuthAccessTokenEloquent::class, 'user_id');
    }

    //</editor-fold>


    /**
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return $this->where('email', $username)
                ->where('is_active', 1)
                ->where('is_block', 0)->first();
        } else {
            return $this->where('username', $username)
                ->where('is_active', 1)
                ->where('is_block', 0)->first();
        }
    }

    /**
     * @param string $role
     * @param $user
     * @return bool|mixed
     */
    public function hasRole($user, string $role)
    {
        $user = $user->with(['roles'])->find($user->id);

        $role = $user->roles->where('slug', $role);

        return $role->count() > 0;
    }

    /**
     * @param string $permission
     * @param $user
     * @return bool
     */
    public function hasPermission($user, string $permission)
    {
        $_user = $user->with(['permissions' => function ($query) use ($permission) {
            $query->select('id', 'name', 'slug', 'value')
                ->where([
                    ['slug','=',$permission]
                ]);
            }])->find($user->id);

        if ($_user->permissions->count() > 0) {
            if ($_user->permissions->first()->value == 'ALLOW') {
                return true;
            }

            if ($_user->permissions->first()->value == 'DENY') {
                return false;
            }
        }

        $__user = $user->with(['roles' => function ($query) use ($permission) {
            $query->with(['permissions' => function ($query) use ($permission) {
                $query->select('id', 'name', 'slug', 'value')
                    ->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        if ($__user->roles->first()->permissions->count() > 0) {
            if ($__user->roles->first()->permissions->first()->value == 'ALLOW') {
                return true;
            }

            if ($__user->roles->first()->permissions->first()->value == 'DENY') {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $user
     * @param string $permission
     * @param string $access
     * @return bool
     */
    public function hasAccess($user, string $permission, string $access)
    {
        $permissionId = $this->getPermissionId($user, $permission);

        $_user = $user->with(['accesses' => function ($query) use ($permissionId, $access) {
            $query->select('id', 'name', 'slug', 'value')
                ->where([
                    ['slug','=',$access]
                ])
                ->wherePivot('permission_id', $permissionId);
        }])->find($user->id);

        if ($_user->accesses->count() > 0) {
            if ($_user->accesses->first()->value == 'ALLOW') {
                return true;
            }

            if ($_user->accesses->first()->value == 'DENY') {
                return false;
            }
        }

        $__user = $user->with(['roles' => function ($query) use ($permission, $access) {
            $query->with(['permissions' => function ($query) use ($permission, $access) {
                $query->select('id', 'name', 'slug', 'value')
                    ->with(['accesses' => function ($query) use ($access) {
                        $query->select('id', 'name', 'slug', 'value')
                            ->where([
                                ['slug','=',$access]
                            ]);
                    }])->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        if ($__user->roles->first()->permissions->first()->accesses->count() > 0) {
            if ($__user->roles->first()->permissions->first()->accesses->first()->value == 'ALLOW') {
                return true;
            }

            if ($__user->roles->first()->permissions->first()->accesses->first()->value == 'DENY') {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $user
     * @param string $permission
     * @return mixed
     */
    private function getPermissionId($user, string $permission)
    {
        $user = $user->with(['roles' => function ($query) use ($permission) {
            $query->with(['permissions' => function ($query) use ($permission) {
                $query->select('id')
                    ->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        return $user->roles->first()->permissions->first()->id;
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="UpdateUserPasswordEloquent",
 *     description="Update user password eloquent",
 *     title="Update user password eloquent",
 *     required={"id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="Id property",
 *          example=1
 *     ),
 *     @OA\Property(property="password", ref="#/components/schemas/UserEloquent/properties/password"),
 *     @OA\Property(
 *         property="confirm_password",
 *         description="Confirm password property",
 *         type="string"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateUserRoleEloquent",
 *     description="Update user role eloquent",
 *     title="Update user role eloquent",
 *     required={"id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="Id property",
 *          example=1
 *     ),
 *     @OA\Property(
 *          property="role_ids",
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int32"
 *          ),
 *          example={1,2,3}
 *     )
 * )
 *
 */

/**
 * @OA\Schema(
 *     schema="UpdateUserPermissionEloquent",
 *     description="Update user permission eloquent",
 *     title="Update user permission eloquent",
 *     required={"id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="Id property",
 *          example=1
 *     ),
 *     @OA\Property(
 *          property="permission_ids",
 *          type="array",
 *          @OA\Items(
 *              type="array",
 *              @OA\Items()
 *          ),
 *          example={{1, "ALLOW"},{2, "DENY"}}
 *     )
 * )
 */
