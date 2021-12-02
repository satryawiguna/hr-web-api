<?php

namespace App\Domains\Commons\Office;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Office\Contracts\OfficeRepositoryInterface;
use App\Infrastructures\Commons\Office\Contracts\EloquentOfficeRepositoryInterface;
use App\Domains\Commons\Office\Contracts\OfficeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class OfficeRepository.
 */
class OfficeRepository extends RepositoryAbstract implements OfficeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OfficeRepository constructor.
     *
     * @param EloquentOfficeRepositoryInterface $eloquent
     */
    public function __construct(EloquentOfficeRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @param OfficeInterface $Office
     * @return array
     */
    public function setupPayload(OfficeInterface $Office)
    {
        return [
            'company_id' => $Office->getCompanyId(),
            'name' => $Office->getName(),
            'slug' => $Office->getSlug(),
            'type' => $Office->getType(),
            'country' => $Office->getCountry(),
            'state_or_province' => $Office->getStateOrProvince(),
            'city' => $Office->getCity(),
            'address' => $Office->getAddress(),
            'postcode' => $Office->getPostcode(),
            'phone' => $Office->getPhone(),
            'fax' => $Office->getFax(),
            'email' => $Office->getEmail(),
            'latitude' => $Office->getLatitude(),
            'longitude' => $Office->getLongitude(),
            'is_active' => (!is_null($Office->getIsActive())) ? $Office->getIsActive() : 0,
            'created_by' => $Office->getCreatedBy(),
            'modified_by' => $Office->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(OfficeInterface $Office)
    {
        $data = $this->setupPayload($Office);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(OfficeInterface $Office)
    {
        $data = $this->setupPayload($Office);
       
        return $this->eloquent()->update($data, $Office->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OfficeInterface $Office)
    {
        return $this->eloquent()->delete($Office->getKey());
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
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->eloquent->with(['company', 'employees'])
            ->findWithoutFail($id);
    }

    /**
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function officeList(int $companyId = null, string $type = null, string $country = null, int $isActive = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function officeListSearch(ListedSearchParameter $parameter, int $companyId = null, string $type = null, string $country = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($country)) {
            $this->eloquent->findWhereByCountry($country);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->with(['company', 'employees'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function officePageSearch(PagedSearchParameter $parameter, int $companyId = null, string $type = null, string $country = null, int $isActive = null, bool $count = false)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
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
                return $this->eloquent->with(['company', 'employees'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company', 'employees'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
