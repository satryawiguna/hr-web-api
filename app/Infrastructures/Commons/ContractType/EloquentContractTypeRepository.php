<?php
namespace App\Infrastructures\Commons\ContractType;

use App\Infrastructures\Commons\ContractType\Contracts\EloquentContractTypeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentContractTypeRepository Class.
 */
class EloquentContractTypeRepository extends EloquentRepositoryAbstract implements EloquentContractTypeRepositoryInterface
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
