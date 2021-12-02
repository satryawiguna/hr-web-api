<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\Child\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentChildRepositoryInterface extends EloquentRepositoryInterface
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
     * @param int $genderId
     * @return mixed
     */
    public function findWhereByGenderId(int $genderId);

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, Datetime $endBirthDate);

    /**
     * @param DateTime $startBPJSKesehatanhDate
     * @param DateTime $endBPJSKesehatanhDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBPJSKesehatanDate(DateTime $startBPJSKesehatanhDate, Datetime $endBPJSKesehatanhDate);

    /**
     * @param string $bpjsKesehatanClass
     * @return mixed
     */
    public function findWhereByBPJSKesehatanClass(string $bpjsKesehatanClass);

    /**
     * @param string $searchQuery
     * @return mixedx
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
