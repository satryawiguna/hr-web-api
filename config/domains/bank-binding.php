<?php

use App\Domains\Commons\Bank as BankDomain;
use App\Infrastructures\Commons\Bank as BankInfrastructure;

return [
    'providers' => [
        BankDomain\Contracts\BankServiceInterface::class => BankDomain\BankService::class,
        BankDomain\Contracts\BankInterface::class => BankDomain\BankEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        BankInfrastructure\Contracts\EloquentBankRepositoryInterface::class => [
                'class' => BankInfrastructure\EloquentBankRepository::class,
                'model' => BankDomain\BankEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        BankDomain\Contracts\BankRepositoryInterface::class => BankDomain\BankRepository::class,
    ]
];
