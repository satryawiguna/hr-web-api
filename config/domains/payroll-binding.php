<?php

use App\Domains\HumanResources\Payroll as PayrollDomain;
use App\Infrastructures\HumanResources\Payroll as PayrollInfrastructure;

return [
    'providers' => [
        PayrollDomain\Contracts\PayrollServiceInterface::class => PayrollDomain\PayrollService::class,
        PayrollDomain\Contracts\PayrollInterface::class => PayrollDomain\PayrollEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PayrollInfrastructure\Contracts\EloquentPayrollRepositoryInterface::class => [
                'class' => PayrollInfrastructure\EloquentPayrollRepository::class,
                'model' => PayrollDomain\PayrollEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PayrollDomain\Contracts\PayrollRepositoryInterface::class => PayrollDomain\PayrollRepository::class,
    ]
];
