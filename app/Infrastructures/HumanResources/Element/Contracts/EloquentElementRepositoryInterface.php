<?php

namespace App\Infrastructures\HumanResources\Element\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentElementRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $formulaId
     * @return mixed
     */
    public function findWhereByFormulaId(int $formulaId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
