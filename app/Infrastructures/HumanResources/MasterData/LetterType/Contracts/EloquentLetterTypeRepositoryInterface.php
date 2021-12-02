<?php

namespace App\Infrastructures\HumanResources\MasterData\LetterType\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentLetterTypeRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
