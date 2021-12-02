<?php

namespace App\Domains\Commons\EmployeeNumberScale;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleRepositoryInterface;
use App\Infrastructures\Commons\EmployeeNumberScale\Contracts\EloquentEmployeeNumberScaleRepositoryInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleInterface;
use App\Domains\RepositoryAbstract;
use Closure;

/**
 * Class EmployeeNumberScaleRepository.
 */
class EmployeeNumberScaleRepository extends RepositoryAbstract implements EmployeeNumberScaleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeNumberScaleRepository constructor.
     *
     * @param EloquentEmployeeNumberScaleRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeNumberScaleRepositoryInterface $eloquent)
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
    public function setupPayload(EmployeeNumberScaleInterface $EmployeeNumberScale)
    {
        return [
            'name' => $EmployeeNumberScale->getName(),
            'slug' => $EmployeeNumberScale->getSlug(),
            'description' => $EmployeeNumberScale->getDescription(),
            'is_active' => (!is_null($EmployeeNumberScale->getIsActive())) ? $EmployeeNumberScale->getIsActive() : 0,
            'created_by' => $EmployeeNumberScale->getCreatedBy(),
            'modified_by' => $EmployeeNumberScale->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(EmployeeNumberScaleInterface $EmployeeNumberScale)
    {
        $data = $this->setupPayload($EmployeeNumberScale);

        return $this->eloquent->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(EmployeeNumberScaleInterface $EmployeeNumberScale)
    {
        $data = $this->setupPayload($EmployeeNumberScale);

        return $this->eloquent->update($data, $EmployeeNumberScale->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(EmployeeNumberScaleInterface $EmployeeNumberScale)
    {
        return $this->eloquent->delete($EmployeeNumberScale->getKey());
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
    public function employeeNumberScaleList(int $isActive = null)
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
    public function employeeNumberScaleListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function employeeNumberScalePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
