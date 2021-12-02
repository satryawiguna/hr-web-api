<?php
namespace App\Infrastructures\HumanResources\Formula;

use App\Infrastructures\HumanResources\Formula\Contracts\EloquentFormulaRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentFormulaRepository Class.
 */
class EloquentFormulaRepository extends EloquentRepositoryAbstract implements EloquentFormulaRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $formulaCategoryId
     * @return $this|mixed
     */
    public function findWhereByFormulaCategoryId(int $formulaCategoryId)
    {
        $this->model = $this->model->where('formula_category_id', $formulaCategoryId);

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
