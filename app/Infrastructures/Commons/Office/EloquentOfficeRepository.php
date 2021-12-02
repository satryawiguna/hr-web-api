<?php
namespace App\Infrastructures\Commons\Office;

use App\Infrastructures\Commons\Office\Contracts\EloquentOfficeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentOfficeRepository Class.
 */
class EloquentOfficeRepository extends EloquentRepositoryAbstract implements EloquentOfficeRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->where('company_id', $companyId);

        return $this;
    }

    /**
     * @param string $type
     * @return $this|mixed
     */
    public function findWhereByType(string $type)
    {
        $this->model = $this->model->where('type', $type);

        return $this;
    }

    /**
     * @param string $company
     * @return $this|mixed
     */
    public function findWhereByCountry(string $company)
    {
        $this->model = $this->model->where('country', $company);

        return $this;
    }

    /**
     * @param int $isActive
     * @return $this|mixed
     */
    public function findWhereByIsActive(int $isActive)
    {
        $this->model = $this->model->where('is_active', $isActive);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%',
            'email' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?
            OR email LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
