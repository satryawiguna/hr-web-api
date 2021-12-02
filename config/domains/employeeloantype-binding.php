<?php

use App\Domains\Commons\EmployeeLoanType as EmployeeLoanTypeDomain;
use App\Infrastructures\Commons\EmployeeLoanType as EmployeeLoanTypeInfrastructure;

return [
    'providers' => [
        EmployeeLoanTypeDomain\Contracts\EmployeeLoanTypeServiceInterface::class => EmployeeLoanTypeDomain\EmployeeLoanTypeService::class,
        EmployeeLoanTypeDomain\Contracts\EmployeeLoanTypeInterface::class => EmployeeLoanTypeDomain\EmployeeLoanTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        EmployeeLoanTypeInfrastructure\Contracts\EloquentEmployeeLoanTypeRepositoryInterface::class => [
                'class' => EmployeeLoanTypeInfrastructure\EloquentEmployeeLoanTypeRepository::class,
                'model' => EmployeeLoanTypeDomain\EmployeeLoanTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        EmployeeLoanTypeDomain\Contracts\EmployeeLoanTypeRepositoryInterface::class => EmployeeLoanTypeDomain\EmployeeLoanTypeRepository::class,
    ]
];
