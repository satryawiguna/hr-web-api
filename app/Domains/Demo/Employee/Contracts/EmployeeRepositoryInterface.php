<?php


namespace App\Domains\Demo\Employee\Contracts;



use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Infrastructures\Demo\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use DateTime;

interface EmployeeRepositoryInterface
{
    public function __construct(EloquentEmployeeRepositoryInterface $eloquent);

    public function create(EmployeeInterface $Employee, array $relations = null);

    public function update(EmployeeInterface $Employee, array $relations = null);

    public function delete(EmployeeInterface $Employee, array $relations = null);

    public function find(int $id);

    public function employeePageSearch(PagedSearchParameter $parameter, object $rangeBirthDate = null, bool $count = false);
}