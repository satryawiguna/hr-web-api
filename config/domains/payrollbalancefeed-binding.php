<?php

use App\Domains\HumanResources\Payroll\PayrollBalanceFeed as PayrollBalanceFeedDomain;
use App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed as PayrollBalanceFeedInfrastructure;

return [
    'providers' => [
        PayrollBalanceFeedDomain\Contracts\PayrollBalanceFeedServiceInterface::class => PayrollBalanceFeedDomain\PayrollBalanceFeedService::class,
        PayrollBalanceFeedDomain\Contracts\PayrollBalanceFeedInterface::class => PayrollBalanceFeedDomain\PayrollBalanceFeedEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PayrollBalanceFeedInfrastructure\Contracts\EloquentPayrollBalanceFeedRepositoryInterface::class => [
                'class' => PayrollBalanceFeedInfrastructure\EloquentPayrollBalanceFeedRepository::class,
                'model' => PayrollBalanceFeedDomain\PayrollBalanceFeedEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PayrollBalanceFeedDomain\Contracts\PayrollBalanceFeedRepositoryInterface::class => PayrollBalanceFeedDomain\PayrollBalanceFeedRepository::class,
    ]
];
