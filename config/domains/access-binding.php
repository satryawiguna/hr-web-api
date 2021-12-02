<?php

use App\Domains\Commons\Access as AccessDomain;
use App\Infrastructures\Commons\Access as AccessInfrastructure;

return [
    'providers' => [
        AccessDomain\Contracts\AccessServiceInterface::class => AccessDomain\AccessService::class,
        AccessDomain\Contracts\AccessInterface::class => AccessDomain\AccessEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        AccessInfrastructure\Contracts\EloquentAccessRepositoryInterface::class => [
                'class' => AccessInfrastructure\EloquentAccessRepository::class,
                'model' => AccessDomain\AccessEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        AccessDomain\Contracts\AccessRepositoryInterface::class => AccessDomain\AccessRepository::class,
    ]
];
