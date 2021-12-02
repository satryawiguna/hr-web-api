<?php

namespace App\Domains\Commons\Access;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Access\Contracts\AccessRepositoryInterface;
use App\Infrastructures\Commons\Access\Contracts\EloquentAccessRepositoryInterface;
use App\Domains\Commons\Access\Contracts\AccessInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class AccessRepository.
 */
class AccessRepository extends RepositoryAbstract implements AccessRepositoryInterface
{
    /**
     * AccessRepository constructor.
     *
     * @param EloquentAccessRepositoryInterface $eloquent
     */
    public function __construct(EloquentAccessRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(AccessInterface $Access)
    {
        return [
            'name' => $Access->getName(),
            'slug' => $Access->getSlug(),
            'description' => $Access->getDescription(),
            'is_active' => (!is_null($Access->getIsActive())) ? $Access->getIsActive() : 0,
            'created_by' => $Access->getCreatedBy(),
            'modified_by' => $Access->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(AccessInterface $Access)
    {
        $data = $this->setupPayload($Access);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(AccessInterface $Access)
    {
        $data = $this->setupPayload($Access);
       
        return $this->eloquent()->update($data, $Access->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AccessInterface $Access)
    {
        return $this->eloquent()->delete($Access->getKey());
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids)
    {
        return $this->eloquent()->delete($ids);
    }

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function accessList(int $isActive = null)
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
    public function accessListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function accessPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }
}
