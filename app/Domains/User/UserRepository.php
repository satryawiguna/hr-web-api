<?php

namespace App\Domains\User;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\User\Contracts\UserRepositoryInterface;
use App\Infrastructures\User\Contracts\EloquentUserRepositoryInterface;
use App\Domains\User\Contracts\UserInterface;
use App\Domains\RepositoryAbstract;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository.
 */
class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    //<editor-fold desc="#constructor">

    private $applicationId;
    private $groupId;
    private $roleId;

    /**
     * UserRepository constructor.
     *
     * @param EloquentUserRepositoryInterface $eloquent
     */
    public function __construct(EloquentUserRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(UserInterface $User)
    {
        $data = [
            'profile_id' => $User->getProfileId(),
            'username' => $User->getUsername(),
            'email' => $User->getEmail(),
            'password' => $User->getPassword(),
            'is_active' => (!is_null($User->getIsActive())) ? $User->getIsActive() : 0,
            'is_block' => (!is_null($User->getIsBlock())) ? $User->getIsBlock() : 0,
            'created_by' => $User->getCreatedBy(),
            'modified_by' => $User->getModifiedBy()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, array $relations = null)
    {
        $data = $this->setupPayload($user);

        return $this->eloquent->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserInterface $User, array $relations = null)
    {
        $data = $this->setupPayload($User);

        return $this->eloquent->update($data, $User->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(UserInterface $User, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent->delete($User->getKey(), $isPermanentDelete, $relations);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->eloquent->with(['groups', 'roles', 'companies', 'applications', 'profile' => function($q) {
            $q->with(['morphMediaLibraries'])->get();
        }])
            ->find($id);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserLoginByEmail(string $email)
    {
        return $this->eloquent->with([
            'applications' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'companies' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['applications' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    }]);
            }])->whereHas('roles', function($query) {
                $query->whereHas('group', function($query) {
                    $query->whereIn('id', [1, 2, 3, 5]);
                });
            })->findWhere([
                ['email', '=', $email],
                ['is_active', '=', 1]
            ], ['id', 'username', 'email', 'password']);
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function findUserLoginByUsername(string $username)
    {
        return $this->eloquent->with([
            'applications' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'companies' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['applications' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    }]);
            }])->whereHas('roles', function($query) {
                $query->whereHas('group', function($query) {
                    $query->whereIn('id', [1, 2, 3, 5]);
                });
            })->findWhere([
                ['username', '=', $username],
                ['is_active', '=', 1]
            ], ['id', 'username', 'email', 'password']);
    }

    /**
     * @param int $userId
     * @param int $permissionId
     * @return mixed
     */
    public function findUserPermission(int $userId, int $permissionId)
    {
        return $this->eloquent->with(['permissions' => function ($query) use ($permissionId) {
            $query->select('id', 'name', 'slug', 'server', 'path', 'value')
                ->wherePivot('permission_id', $permissionId);
        }])
            ->find($userId);
    }

    /**
     * @param int $userId
     * @param int $permissionId
     * @param int $accessId
     * @return mixed
     */
    public function findUserAccess(int $userId, int $permissionId, int $accessId)
    {
        return $this->eloquent->with(['accesses' => function ($query) use ($permissionId, $accessId) {
            $query->select('id', 'name', 'slug', 'value')
                ->wherePivot('permission_id', $permissionId)
                ->wherePivot('access_id', $accessId);
        }])
            ->find($userId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserCompany(int $id)
    {
        $user = $this->eloquent->with(['companies'])
            ->find($id);

        return $user->companies;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserWhereHasCompany(int $id)
    {
        $user = $this->eloquent->whereHas('companies', function ($query) use ($id) {
            $query->where('id', '=', $id);
        })->all();

        return $user->pluck('id');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserApplication(int $id)
    {
        $user = $this->eloquent->with(['applications'])
            ->find($id);

        return $user->applications;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserRole(int $id)
    {
        $user = $this->eloquent->with(['roles'])
            ->find($id);

        return $user->roles;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserRolePermission(int $id)
    {
        $user = $this->eloquent->with(['roles' => function($q) {
            $q->with(['permissions'])->get();
        }])
            ->find($id);

        return $user->roles;
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserLoginToApiDocumentByEmail(string $email)
    {
        return $this->eloquent->whereHas('roles', function($query) {
            $query->whereHas('group', function($query) {
                $query->where('id', '=', 4);
            });
        })->findWhere([
            ['email', '=', $email],
            ['is_active', '=', 1],
        ]);
    }

    /**
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return mixed
     */
    public function userList(int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereHasCompanyByCompanyId($companyId);
        }

        if (!is_null($applicationId)) {
            $this->eloquent->findWhereHasApplicationByApplicationId($applicationId);
            $this->eloquent->findWhereHasCompanyByApplicationId($applicationId);
        }

        if (!is_null($roleId)) {
            $this->eloquent->findWhereHasRoleByRoleId($roleId);
        }

        if (!is_null($permissionId)) {
            $this->eloquent->findWhereHasPermissionByPermissionId($permissionId);
        }

        if (!is_null($isActive)) {
//            $this->eloquent->findWhere(['is_active' => $isActive]);
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!is_null($isBlock)) {
//            $this->eloquent->findWhere(['is_block' => $isBlock]);
            $this->eloquent->findWhereByIsBlock($isBlock);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @param bool $count
     * @return mixed
     */
    public function userListSearch(ListedSearchParameter $parameter, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereHasCompanyByCompanyId($companyId);
        }

        if (!is_null($applicationId)) {
            $this->eloquent->findWhereHasApplicationByApplicationId($applicationId);
            $this->eloquent->findWhereHasCompanyByApplicationId($applicationId);
        }

        if (!is_null($roleId)) {
            $this->eloquent->findWhereHasRoleByRoleId($roleId);
        }

        if (!is_null($permissionId)) {
            $this->eloquent->findWhereHasPermissionByPermissionId($permissionId);
        }

        if (!is_null($isActive)) {
//            $this->eloquent->findWhere(['is_active' => $isActive]);
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!is_null($isBlock)) {
//            $this->eloquent->findWhere(['is_block' => $isBlock]);
            $this->eloquent->findWhereByIsBlock($isBlock);
        }

        if (!$count) {
            return $this->eloquent->with(['applications', 'roles', 'permissions', 'companies'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @param bool $count
     * @return mixed
     */
    public function userPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null, bool $count = false)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereHasCompanyByCompanyId($companyId);
        }

        if (!is_null($applicationId)) {
            $this->eloquent->findWhereHasApplicationByApplicationId($applicationId);
            $this->eloquent->findWhereHasCompanyByApplicationId($applicationId);
        }

        if (!is_null($roleId)) {
            $this->eloquent->findWhereHasRoleByRoleId($roleId);
        }

        if (!is_null($permissionId)) {
            $this->eloquent->findWhereHasPermissionByPermissionId($permissionId);
        }

        if (!is_null($isActive)) {
//            $this->eloquent->findWhere(['is_active' => $isActive]);
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!is_null($isBlock)) {
//            $this->eloquent->findWhere(['is_block' => $isBlock]);
            $this->eloquent->findWhereByIsBlock($isBlock);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['applications', 'roles', 'permissions', 'companies'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['applications', 'roles', 'permissions', 'companies'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], $parameter->pagination['page'] - 1);
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
