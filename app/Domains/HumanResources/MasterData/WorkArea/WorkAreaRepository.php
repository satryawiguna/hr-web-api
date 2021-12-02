<?php

namespace App\Domains\HumanResources\MasterData\WorkArea;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\WorkArea\Contracts\EloquentWorkAreaRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class WorkAreaRepository.
 */
class WorkAreaRepository extends RepositoryAbstract implements WorkAreaRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAreaRepository constructor.
     *
     * @param EloquentWorkAreaRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkAreaRepositoryInterface $eloquent)
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
    public function setupPayload(WorkAreaInterface $WorkArea)
    {
        return [
            'company_id' => $WorkArea->getCompanyId(),
            'code' => $WorkArea->getCode(),
            'title' => $WorkArea->getTitle(),
            'slug' => $WorkArea->getSlug(),
            'country' => $WorkArea->getCountry(),
            'state_or_province' => $WorkArea->getStateOrProvince(),
            'city' => $WorkArea->getCity(),
            'address' => $WorkArea->getAddress(),
            'postcode' => $WorkArea->getPostcode(),
            'phone' => $WorkArea->getPhone(),
            'fax' => $WorkArea->getFax(),
            'email' => $WorkArea->getEmail(),
            'url' => $WorkArea->getUrl(),
            'is_active' => (!is_null($WorkArea->getIsActive())) ? $WorkArea->getIsActive() : 0,
            'created_by' => $WorkArea->getCreatedBy(),
            'modified_by' => $WorkArea->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkAreaInterface $WorkArea)
    {
        $data = $this->setupPayload($WorkArea);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkAreaInterface $WorkArea)
    {
        $data = $this->setupPayload($WorkArea);

        return $this->eloquent()->update($data, $WorkArea->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WorkAreaInterface $WorkArea)
    {
        return $this->eloquent()->delete($WorkArea->getKey());
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
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workAreaList(int $companyId = null, string $country = null, int $isActive = null)
    {
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
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workAreaListSearch(ListedSearchParameter $parameter, int $companyId = null, string $country = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
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
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workAreaPageSearch(PagedSearchParameter $parameter, int $companyId = null, string $country = null, int $isActive = null, bool $count = false)
    {
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
