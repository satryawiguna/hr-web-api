<?php
namespace App\Infrastructures\Area\State;

use App\Infrastructures\Area\State\Contracts\EloquentStateRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentStateRepository Class.
 */
class EloquentStateRepository extends EloquentRepositoryAbstract implements EloquentStateRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int|null $countryId
     * @return $this|mixed
     */
    public function findWereByCountryId(int $countryId)
    {
        $this->model = $this->model->where('country_id', $countryId);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'state_name' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(state_name LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
