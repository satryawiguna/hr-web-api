<?php

namespace App\Infrastructures\Commons\VacancyCategory\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentVacancyCategoryRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
