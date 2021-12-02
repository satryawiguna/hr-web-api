<?php
namespace App\Infrastructures\Area\City;

use App\Infrastructures\Area\City\Contracts\EloquentCityRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentCityRepository Class.
 */
class EloquentCityRepository extends EloquentRepositoryAbstract implements EloquentCityRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int|null $stateId
     * @return $this|mixed
     */
    public function findWereByStateId(int $stateId)
    {
        $this->model = $this->model->where('state_id', $stateId);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'city_name' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(city_name LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
