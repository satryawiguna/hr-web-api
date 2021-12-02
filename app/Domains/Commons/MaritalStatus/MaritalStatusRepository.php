<?php

namespace App\Domains\Commons\MaritalStatus;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusRepositoryInterface;
use App\Infrastructures\Commons\MaritalStatus\Contracts\EloquentMaritalStatusRepositoryInterface;
use App\Domains\Commons\MaritalStatus\Contracts\MaritalStatusInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class MaritalStatusRepository.
 */
class MaritalStatusRepository extends RepositoryAbstract implements MaritalStatusRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MaritalStatusRepository constructor.
     *
     * @param EloquentMaritalStatusRepositoryInterface $eloquent
     */
    public function __construct(EloquentMaritalStatusRepositoryInterface $eloquent)
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
    public function setupPayload(MaritalStatusInterface $MaritalStatus)
    {
        return [
            'name' => $MaritalStatus->getName(),
            'slug' => $MaritalStatus->getSlug(),
            'description' => $MaritalStatus->getDescription(),
            'is_active' => (!is_null($MaritalStatus->getIsActive())) ? $MaritalStatus->getIsActive() : 0,
            'created_by' => $MaritalStatus->getCreatedBy(),
            'modified_by' => $MaritalStatus->getModifiedBy(),

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(MaritalStatusInterface $MaritalStatus)
    {
        $data = $this->setupPayload($MaritalStatus);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(MaritalStatusInterface $MaritalStatus)
    {
        $data = $this->setupPayload($MaritalStatus);

        return $this->eloquent()->update($data, $MaritalStatus->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MaritalStatusInterface $MaritalStatus)
    {
        return $this->eloquent()->delete($MaritalStatus->getKey());
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
    public function maritalStatusList(int $isActive = null)
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
    public function maritalStatusListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function maritalStatusPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
