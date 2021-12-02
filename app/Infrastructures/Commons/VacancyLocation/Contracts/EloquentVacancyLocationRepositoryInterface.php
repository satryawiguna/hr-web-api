<?php

namespace App\Infrastructures\Commons\VacancyLocation\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentVacancyLocationRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $parentId
     * @return mixed
     */
    public function findWhereByParentId(int $parentId);

    /**
     * @return mixed
     */
    public function findWhereByParentIdIsNull();

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
