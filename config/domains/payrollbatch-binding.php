<?php

use App\Domains\HumanResources\Payroll\PayrollBatch as PayrollBatchDomain;
use App\Infrastructures\HumanResources\Payroll\PayrollBatch as PayrollBatchInfrastructure;

return [
    'providers' => [
        PayrollBatchDomain\Contracts\PayrollBatchServiceInterface::class => PayrollBatchDomain\PayrollBatchService::class,
        PayrollBatchDomain\Contracts\PayrollBatchInterface::class => PayrollBatchDomain\PayrollBatchEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PayrollBatchInfrastructure\Contracts\EloquentPayrollBatchRepositoryInterface::class => [
                'class' => PayrollBatchInfrastructure\EloquentPayrollBatchRepository::class,
                'model' => PayrollBatchDomain\PayrollBatchEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PayrollBatchDomain\Contracts\PayrollBatchRepositoryInterface::class => PayrollBatchDomain\PayrollBatchRepository::class,
    ]
];
