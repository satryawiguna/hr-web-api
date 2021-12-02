<?php

namespace App\Infrastructures\HumanResources\Formula\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentFormulaRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $formulaCategoryId
     * @return mixed
     */
    public function findWhereByFormulaCategoryId(int $formulaCategoryId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
