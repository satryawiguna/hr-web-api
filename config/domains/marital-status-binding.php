<?php

use App\Domains\Commons\MaritalStatus as MaritalStatusDomain;
use App\Infrastructures\Commons\MaritalStatus as MaritalStatusInfrastructure;

return [
    'providers' => [
        MaritalStatusDomain\Contracts\MaritalStatusServiceInterface::class => MaritalStatusDomain\MaritalStatusService::class,
        MaritalStatusDomain\Contracts\MaritalStatusInterface::class => MaritalStatusDomain\MaritalStatusEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        MaritalStatusInfrastructure\Contracts\EloquentMaritalStatusRepositoryInterface::class => [
                'class' => MaritalStatusInfrastructure\EloquentMaritalStatusRepository::class,
                'model' => MaritalStatusDomain\MaritalStatusEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        MaritalStatusDomain\Contracts\MaritalStatusRepositoryInterface::class => MaritalStatusDomain\MaritalStatusRepository::class,
    ]
];
