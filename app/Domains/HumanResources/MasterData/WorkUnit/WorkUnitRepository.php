<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\WorkUnit\Contracts\EloquentWorkUnitRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class WorkUnitRepository.
 */
class WorkUnitRepository extends RepositoryAbstract implements WorkUnitRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitRepository constructor.
     *
     * @param EloquentWorkUnitRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkUnitRepositoryInterface $eloquent)
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
    public function setupPayload(WorkUnitInterface $WorkUnit)
    {
        return [
            'company_id' => $WorkUnit->getCompanyId(),
            'parent_id' => $WorkUnit->getParentId(),
            'code' => $WorkUnit->getCode(),
            'title' => $WorkUnit->getTitle(),
            'slug' => $WorkUnit->getSlug(),
            'country' => $WorkUnit->getCountry(),
            'state_or_province' => $WorkUnit->getStateOrProvince(),
            'city' => $WorkUnit->getCity(),
            'address' => $WorkUnit->getAddress(),
            'postcode' => $WorkUnit->getPostcode(),
            'phone' => $WorkUnit->getPhone(),
            'fax' => $WorkUnit->getFax(),
            'email' => $WorkUnit->getEmail(),
            'url' => $WorkUnit->getUrl(),
            'is_active' => (!is_null($WorkUnit->getIsActive())) ? $WorkUnit->getIsActive() : 0,
            'created_by' => $WorkUnit->getCreatedBy(),
            'modified_by' => $WorkUnit->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkUnitInterface $WorkUnit)
    {
        $data = $this->setupPayload($WorkUnit);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkUnitInterface $WorkUnit)
    {
        $data = $this->setupPayload($WorkUnit);

        return $this->eloquent()->update($data, $WorkUnit->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WorkUnitInterface $WorkUnit)
    {
        return $this->eloquent()->delete($WorkUnit->getKey());
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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workUnitList(int $parentId = null, int $companyId = null, string $country = null, int $isActive = null)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($country)) {
            $this->eloquent->findWhereByCountry($country);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workUnitListHierarchical(int $companyId = null, string $country = null, int $isActive = null)
    {
        $this->eloquent->findWhereByParentIdIsNull();

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($country)) {
            $this->eloquent->findWhereByCountry($country);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->with(['workUnitChilds' => function($query) use($companyId, $country, $isActive) {
            if (!is_null($companyId)) {
                $query->where('company_id', $companyId);
            }

            if (!is_null($country)) {
                $query->where('country', $country);
            }

            if (!is_null($isActive)) {
                $query->where('is_active', $isActive);
            }

            return $query;
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int $parentId
     * @param int $companyId
     * @param string $country
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function workUnitListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($country)) {
            $this->eloquent->findWhereByCountry($country);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->with(['company'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int $parentId
     * @param int $companyId
     * @param string $country
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function workUnitPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null, bool $count = false)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($country)) {
            $this->eloquent->findWhereByCountry($country);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
