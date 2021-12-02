<?php

use App\Domains\Commons\Application as ApplicationDomain;
use App\Infrastructures\Commons\Application as ApplicationInfrastructure;

return [
    'providers' => [
        ApplicationDomain\Contracts\ApplicationServiceInterface::class => ApplicationDomain\ApplicationService::class,
        ApplicationDomain\Contracts\ApplicationInterface::class => ApplicationDomain\ApplicationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ApplicationInfrastructure\Contracts\EloquentApplicationRepositoryInterface::class => [
                'class' => ApplicationInfrastructure\EloquentApplicationRepository::class,
                'model' => ApplicationDomain\ApplicationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ApplicationDomain\Contracts\ApplicationRepositoryInterface::class => ApplicationDomain\ApplicationRepository::class,
    ]
];
