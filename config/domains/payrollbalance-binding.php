<?php

use App\Domains\HumanResources\Payroll\PayrollBalance as PayrollBalanceDomain;
use App\Infrastructures\HumanResources\Payroll\PayrollBalance as PayrollBalanceInfrastructure;

return [
    'providers' => [
        PayrollBalanceDomain\Contracts\PayrollBalanceServiceInterface::class => PayrollBalanceDomain\PayrollBalanceService::class,
        PayrollBalanceDomain\Contracts\PayrollBalanceInterface::class => PayrollBalanceDomain\PayrollBalanceEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PayrollBalanceInfrastructure\Contracts\EloquentPayrollBalanceRepositoryInterface::class => [
                'class' => PayrollBalanceInfrastructure\EloquentPayrollBalanceRepository::class,
                'model' => PayrollBalanceDomain\PayrollBalanceEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PayrollBalanceDomain\Contracts\PayrollBalanceRepositoryInterface::class => PayrollBalanceDomain\PayrollBalanceRepository::class,
    ]
];
