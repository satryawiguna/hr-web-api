<?php

namespace App\Domains\Commons\Permission;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;
use App\Infrastructures\Commons\Permission\Contracts\EloquentPermissionRepositoryInterface;
use App\Domains\Commons\Permission\Contracts\PermissionInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends RepositoryAbstract implements PermissionRepositoryInterface
{
    /**
     * PermissionRepository constructor.
     *
     * @param EloquentPermissionRepositoryInterface $eloquent
     */
    public function __construct(EloquentPermissionRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(PermissionInterface $Permission)
    {
        return [
            'name' => $Permission->getName(),
            'slug' => $Permission->getSlug(),
            'server' => $Permission->getServer(),
            'path' => $Permission->getPath(),
            'description' => $Permission->getDescription(),
            'is_active' => $Permission->getIsActive(),
            'created_by' => $Permission->getCreatedBy(),
            'modified_by' => $Permission->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PermissionInterface $Permission, array $relations = null)
    {
        $data = $this->setupPayload($Permission);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PermissionInterface $Permission, array $relations = null)
    {
        $data = $this->setupPayload($Permission);
        return $this->eloquent()->update($data, $Permission->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PermissionInterface $Permission, array $relations = null, bool $isPermanentDelete = false)
    {
        return $this->eloquent()->delete($Permission->getKey(), $isPermanentDelete, $relations);
    }

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($ids, $isPermanentDelete, $relations);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findPermissionAccess(int $id)
    {
        $permission = $this->eloquent->with(['accesses'])
            ->find($id);

        return $permission->accesses;
    }

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function permissionList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function permissionListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function permissionPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], $parameter->pagination['page'] - 1);
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }
}
