<?php

namespace App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentVacancyApplicationNoteRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $vacancyApplicationId
     * @return mixed
     */
    public function findWhereByVacancyApplicationId(int $vacancyApplicationId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
