<?php

namespace App\Domains\Commons\Role;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Role\Contracts\RoleRepositoryInterface;
use App\Infrastructures\Commons\Role\Contracts\EloquentRoleRepositoryInterface;
use App\Domains\Commons\Role\Contracts\RoleInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class RoleRepository.
 */
class RoleRepository extends RepositoryAbstract implements RoleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RoleRepository constructor.
     *
     * @param EloquentRoleRepositoryInterface $eloquent
     */
    public function __construct(EloquentRoleRepositoryInterface $eloquent)
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
    public function setupPayload(RoleInterface $Role)
    {
        return [
            'group_id' => $Role->getGroupId(),
            'name' => $Role->getName(),
            'slug' => $Role->getSlug(),
            'description' => $Role->getDescription(),
            'is_active' => (!is_null($Role->getIsActive())) ? $Role->getIsActive() : 0,
            'created_by' => $Role->getCreatedBy(),
            'modified_by' => $Role->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(RoleInterface $Role, array $relations = null)
    {
        $data = $this->setupPayload($Role);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(RoleInterface $Role, array $relations = null)
    {
        $data = $this->setupPayload($Role);

        return $this->eloquent()->update($data, $Role->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RoleInterface $Role, array $relations = null)
    {
        return $this->eloquent()->delete($Role->getKey(), false, $relations);
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
    public function findRolePermission(int $id)
    {
        $role = $this->eloquent->with(['permissions'])
            ->find($id);

        return $role->permissions;
    }

    /**
     * @param int $isActive
     * @return mixed
     */
    public function roleList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int $isActive
     * @param bool $count
     * @return mixed|void
     */
    public function roleListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function rolePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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

    //</editor-fold>
}
