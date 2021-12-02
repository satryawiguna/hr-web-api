<?php

namespace App\Domains\Commons\Major;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Major\Contracts\MajorRepositoryInterface;
use App\Infrastructures\Commons\Major\Contracts\EloquentMajorRepositoryInterface;
use App\Domains\Commons\Major\Contracts\MajorInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class MajorRepository.
 */
class MajorRepository extends RepositoryAbstract implements MajorRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MajorRepository constructor.
     *
     * @param EloquentMajorRepositoryInterface $eloquent
     */
    public function __construct(EloquentMajorRepositoryInterface $eloquent)
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
    public function setupPayload(MajorInterface $Major)
    {
        return [
            'name' => $Major->getName(),
            'slug' => $Major->getSlug(),
            'description' => $Major->getDescription(),
            'is_active' => (!is_null($Major->getIsActive())) ? $Major->getIsActive() : 0,
            'created_by' => $Major->getCreatedBy(),
            'modified_by' => $Major->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(MajorInterface $Major)
    {
        $data = $this->setupPayload($Major);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(MajorInterface $Major)
    {
        $data = $this->setupPayload($Major);

        return $this->eloquent()->update($data, $Major->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MajorInterface $Major)
    {
        return $this->eloquent()->delete($Major->getKey());
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
    public function majorList(int $isActive = null)
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
    public function majorListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function majorPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
