<?php

use App\Domains\HumanResources\Personal\Employee as EmployeeDomain;
use App\Domains\Demo\Employee as DemoEmployeeDomain;
use App\Infrastructures\HumanResources\Personal\Employee as EmployeeInfrastructure;
use App\Infrastructures\Demo\Employee as DemoEmployeeInfrastructure;

return [
    'providers' => [
        EmployeeDomain\Contracts\EmployeeServiceInterface::class => EmployeeDomain\EmployeeService::class,
        EmployeeDomain\Contracts\EmployeeInterface::class => EmployeeDomain\EmployeeEloquent::class,

        DemoEmployeeDomain\Contracts\EmployeeServiceInterface::class => DemoEmployeeDomain\EmployeeService::class,
        DemoEmployeeDomain\Contracts\EmployeeInterface::class => DemoEmployeeDomain\EmployeeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        EmployeeInfrastructure\Contracts\EloquentEmployeeRepositoryInterface::class => [
                'class' => EmployeeInfrastructure\EloquentEmployeeRepository::class,
                'model' => EmployeeDomain\EmployeeEloquent::class
            ],
        DemoEmployeeInfrastructure\Contracts\EloquentEmployeeRepositoryInterface::class => [
                'class' => DemoEmployeeInfrastructure\EloquentEmployeeRepository::class,
                'model' => DemoEmployeeDomain\EmployeeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        EmployeeDomain\Contracts\EmployeeRepositoryInterface::class => EmployeeDomain\EmployeeRepository::class,
        DemoEmployeeDomain\Contracts\EmployeeRepositoryInterface::class => DemoEmployeeDomain\EmployeeRepository::class,
    ]
];
