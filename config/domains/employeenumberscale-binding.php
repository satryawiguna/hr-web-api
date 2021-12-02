<?php

use App\Domains\Commons\EmployeeNumberScale as EmployeeNumberScaleDomain;
use App\Infrastructures\Commons\EmployeeNumberScale as EmployeeNumberScaleInfrastructure;

return [
    'providers' => [
        EmployeeNumberScaleDomain\Contracts\EmployeeNumberScaleServiceInterface::class => EmployeeNumberScaleDomain\EmployeeNumberScaleService::class,
        EmployeeNumberScaleDomain\Contracts\EmployeeNumberScaleInterface::class => EmployeeNumberScaleDomain\EmployeeNumberScaleEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        EmployeeNumberScaleInfrastructure\Contracts\EloquentEmployeeNumberScaleRepositoryInterface::class => [
                'class' => EmployeeNumberScaleInfrastructure\EloquentEmployeeNumberScaleRepository::class,
                'model' => EmployeeNumberScaleDomain\EmployeeNumberScaleEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        EmployeeNumberScaleDomain\Contracts\EmployeeNumberScaleRepositoryInterface::class => EmployeeNumberScaleDomain\EmployeeNumberScaleRepository::class,
    ]
];
