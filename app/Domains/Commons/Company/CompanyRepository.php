<?php

namespace App\Domains\Commons\Company;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Infrastructures\Commons\Company\Contracts\EloquentCompanyRepositoryInterface;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\RepositoryAbstract;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use App\Infrastructures\MediaLibrary\EloquentMediaLibraryRepository;

/**
 * Class CompanyRepository.
 */
class CompanyRepository extends RepositoryAbstract implements CompanyRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyRepository constructor.
     *
     * @param EloquentCompanyRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompanyRepositoryInterface $eloquent)
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
    public function setupPayload(CompanyInterface $Company)
    {
        $data = [
            'company_category_id' => $Company->getCompanyCategoryId(),
            'employee_number_scale_id' => $Company->getEmployeeNumberScaleId(),
            'name' => $Company->getName(),
            'slug' => $Company->getSlug(),
            'email' => $Company->getEmail(),
            'url' => $Company->getUrl(),
            'description' => $Company->getDescription(),
            'is_active' => (!is_null($Company->getIsActive())) ? $Company->getIsActive() : 0,
            'created_by' => $Company->getCreatedBy(),
            'modified_by' => $Company->getModifiedBy()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(CompanyInterface $Company, array $relations = null)
    {
        $data = $this->setupPayload($Company);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(CompanyInterface $Company, array $relations = null)
    {
        $data = $this->setupPayload($Company);

        return $this->eloquent()->update($data, $Company->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CompanyInterface $Company, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($Company->getKey(), $isPermanentDelete, $relations);
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
    public function find(int $id)
    {
        return $this->eloquent->with(['companyCategory', 'employeeNumberScale'])
            ->findWithoutFail($id);
    }

    /**
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return mixed
     */
    public function companyList(int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null)
    {
        if (!is_null($companyCategoryId)) {
            $this->eloquent->findWhereByCompanyCategoryId($companyCategoryId);
        }

        if (!is_null($employeeNumberScaleId)) {
            $this->eloquent->findWhereByEmployeeNumberScaleId($employeeNumberScaleId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyListSearch(ListedSearchParameter $parameter, int $companyCategoryId= null, int $employeeNumberScaleId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyCategoryId)) {
            $this->eloquent->findWhereByCompanyCategoryId($companyCategoryId);
        }

        if (!is_null($employeeNumberScaleId)) {
            $this->eloquent->findWhereByEmployeeNumberScaleId($employeeNumberScaleId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->with(['companyCategory', 'employeeNumberScale'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyPageSearch(PagedSearchParameter $parameter, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null, bool $count = false)
    {
        $this->eloquent->select('companies.*');
        $this->eloquent->join('company_categories', 'companies.company_category_id', '=', 'company_categories.id');
        $this->eloquent->join('employee_number_scales', 'companies.employee_number_scale_id', '=', 'employee_number_scales.id');

        if (!is_null($companyCategoryId)) {
            $this->eloquent->findWhereByCompanyCategoryId($companyCategoryId);
        }

        if (!is_null($employeeNumberScaleId)) {
            $this->eloquent->findWhereByEmployeeNumberScaleId($employeeNumberScaleId);
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
                return $this->eloquent->with(['companyCategory', 'employeeNumberScale'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['companyCategory', 'employeeNumberScale'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()
                ->count();
        }
    }

    //</editor-fold>
}
