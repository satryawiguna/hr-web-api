<?php

use App\Domains\HumanResources\Payroll\PayrollProcessType as PayrollProcessTypeDomain;
use App\Infrastructures\HumanResources\Payroll\PayrollProcessType as PayrollProcessTypeInfrastructure;

return [
    'providers' => [
        PayrollProcessTypeDomain\Contracts\PayrollProcessTypeServiceInterface::class => PayrollProcessTypeDomain\PayrollProcessTypeService::class,
        PayrollProcessTypeDomain\Contracts\PayrollProcessTypeInterface::class => PayrollProcessTypeDomain\PayrollProcessTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PayrollProcessTypeInfrastructure\Contracts\EloquentPayrollProcessTypeRepositoryInterface::class => [
                'class' => PayrollProcessTypeInfrastructure\EloquentPayrollProcessTypeRepository::class,
                'model' => PayrollProcessTypeDomain\PayrollProcessTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PayrollProcessTypeDomain\Contracts\PayrollProcessTypeRepositoryInterface::class => PayrollProcessTypeDomain\PayrollProcessTypeRepository::class,
    ]
];
