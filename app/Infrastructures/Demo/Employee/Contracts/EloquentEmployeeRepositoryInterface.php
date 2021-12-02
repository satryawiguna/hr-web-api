<?php


namespace App\Infrastructures\Demo\Employee\Contracts;


use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentEmployeeRepositoryInterface extends EloquentRepositoryInterface
{
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, Datetime $endBirthDate);

    public function findWhereBySearchQuery(string $searchQuery);
}