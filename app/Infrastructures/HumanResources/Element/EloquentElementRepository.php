<?php
namespace App\Infrastructures\HumanResources\Element;

use App\Infrastructures\HumanResources\Element\Contracts\EloquentElementRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentElementRepository Class.
 */
class EloquentElementRepository extends EloquentRepositoryAbstract implements EloquentElementRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $formulaId
     * @return $this|mixed
     */
    public function findWhereByFormulaId(int $formulaId)
    {
        $this->model = $this->model->where('formula_id', $formulaId);

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
