<?php

namespace App\Infrastructures\WorkAgreementLetter\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentWorkAgreementLetterRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param int $leterTypeId
     * @return mixed
     */
    public function findWhereByLetterTypeId(int $leterTypeId);

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function findWhereDateByDate(DateTime $date);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
