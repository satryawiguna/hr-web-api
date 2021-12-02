<?php

namespace App\Infrastructures\Commons\Bank;

use App\Infrastructures\Commons\Bank\Contracts\EloquentBankRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentBankRepository Class.
 */
class EloquentBankRepository extends EloquentRepositoryAbstract implements EloquentBankRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
