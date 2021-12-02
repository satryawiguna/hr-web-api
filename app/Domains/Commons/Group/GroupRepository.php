<?php

namespace App\Domains\Commons\Group;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Group\Contracts\GroupRepositoryInterface;
use App\Infrastructures\Commons\Group\Contracts\EloquentGroupRepositoryInterface;
use App\Domains\Commons\Group\Contracts\GroupInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class GroupRepository.
 */
class GroupRepository extends RepositoryAbstract implements GroupRepositoryInterface
{
    /**
     * GroupRepository constructor.
     *
     * @param EloquentGroupRepositoryInterface $eloquent
     */
    public function __construct(EloquentGroupRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(GroupInterface $Group)
    {
        return [
            'name' => $Group->getName(),
            'slug' => $Group->getSlug(),
            'description' => $Group->getDescription(),
            'is_active' => (!is_null($Group->getIsActive())) ? $Group->getIsActive() : 0,
            'created_by' => $Group->getCreatedBy(),
            'modified_by' => $Group->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(GroupInterface $Group)
    {
        $data = $this->setupPayload($Group);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(GroupInterface $Group)
    {
        $data = $this->setupPayload($Group);
       
        return $this->eloquent()->update($data, $Group->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(GroupInterface $Group)
    {
        return $this->eloquent()->delete($Group->getKey());
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
     * @return mixed|void
     */
    public function groupList(int $isActive = null)
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
    public function groupListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function groupPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }
}
