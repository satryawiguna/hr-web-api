<?php

namespace App\Infrastructures\HumanResources\MasterData\AdditionalQuestion\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentAdditionalQuestionRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $isRequired
     * @return mixed
     */
    public function findWhereByIsRequired(int $isRequired);

    /**
     * @param string $status
     * @return mixed
     */
    public function findWhereByStatus(string $status);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
