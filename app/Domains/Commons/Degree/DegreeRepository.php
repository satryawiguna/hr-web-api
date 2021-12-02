<?php

namespace App\Domains\Commons\Degree;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Degree\Contracts\DegreeRepositoryInterface;
use App\Infrastructures\Commons\Degree\Contracts\EloquentDegreeRepositoryInterface;
use App\Domains\Commons\Degree\Contracts\DegreeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class DegreeRepository.
 */
class DegreeRepository extends RepositoryAbstract implements DegreeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * DegreeRepository constructor.
     *
     * @param EloquentDegreeRepositoryInterface $eloquent
     */
    public function __construct(EloquentDegreeRepositoryInterface $eloquent)
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
    public function setupPayload(DegreeInterface $Degree)
    {
        return [
            'name' => $Degree->getName(),
            'slug' => $Degree->getSlug(),
            'description' => $Degree->getDescription(),
            'is_active' => (!is_null($Degree->getIsActive())) ? $Degree->getIsActive() : 0,
            'created_by' => $Degree->getCreatedBy(),
            'modified_by' => $Degree->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(DegreeInterface $Degree)
    {
        $data = $this->setupPayload($Degree);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(DegreeInterface $Degree)
    {
        $data = $this->setupPayload($Degree);

        return $this->eloquent()->update($data, $Degree->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(DegreeInterface $Degree)
    {
        return $this->eloquent()->delete($Degree->getKey());
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
     * @param null $isActive
     * @return mixed
     */
    public function degreeList($isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $isActive
     * @param bool $count
     * @return mixed|void
     */
    public function degreeListSearch(ListedSearchParameter $parameter, $isActive = null, $count = false)
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
     * @param null $isActive
     * @param bool $count
     * @return mixed
     */
    public function degreePageSearch(PagedSearchParameter $parameter, $isActive = null, $count = false)
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
