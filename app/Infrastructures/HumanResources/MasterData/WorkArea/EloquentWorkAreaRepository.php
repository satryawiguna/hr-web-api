<?php
namespace App\Infrastructures\HumanResources\MasterData\WorkArea;

use App\Infrastructures\HumanResources\MasterData\WorkArea\Contracts\EloquentWorkAreaRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentWorkAreaRepository Class.
 */
class EloquentWorkAreaRepository extends EloquentRepositoryAbstract implements EloquentWorkAreaRepositoryInterface
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
     * @param string $country
     * @return $this|mixed
     */
    public function findWhereByCountry(string $country)
    {
        $this->model = $this->model->where('country', $country);

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
            'code' => '%' . $searchQuery . '%',
            'title' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(code LIKE ?
            OR title LIKE ?
            OR slug LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
