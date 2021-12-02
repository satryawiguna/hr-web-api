<?php
namespace App\Infrastructures\HumanResources\Formula\FormulaCategory;

use App\Infrastructures\HumanResources\Formula\FormulaCategory\Contracts\EloquentFormulaCategoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentFormulaCategoryRepository Class.
 */
class EloquentFormulaCategoryRepository extends EloquentRepositoryAbstract implements EloquentFormulaCategoryRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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
