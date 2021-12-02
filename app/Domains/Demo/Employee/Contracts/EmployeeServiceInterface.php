<?php


namespace App\Domains\Demo\Employee\Contracts;


use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Demo\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\Demo\Employee\Contracts\Request\EditEmployeeRequest;

interface EmployeeServiceInterface
{
    public function __construct(EmployeeRepositoryInterface $repository);

    public function create(CreateEmployeeRequest $request): ObjectResponse;

    public function update(EditEmployeeRequest $request): ObjectResponse;

    public function delete(int $id): BasicResponse;

    public function find(int $id): ObjectResponse;

    public function employeePageSearch(PageSearchRequest $request, object $rangeBirthDate = null): GenericPageSearchResponse;
}