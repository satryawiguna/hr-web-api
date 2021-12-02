<?php

namespace App\Infrastructures\HumanResources\Formula\FormulaCategory\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentFormulaCategoryRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
