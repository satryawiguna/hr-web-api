<?php

use App\Domains\Commons\Permission as PermissionDomain;
use App\Infrastructures\Commons\Permission as PermissionInfrastructure;

return [
    'providers' => [
        PermissionDomain\Contracts\PermissionServiceInterface::class => PermissionDomain\PermissionService::class,
        PermissionDomain\Contracts\PermissionInterface::class => PermissionDomain\PermissionEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PermissionInfrastructure\Contracts\EloquentPermissionRepositoryInterface::class => [
                'class' => PermissionInfrastructure\EloquentPermissionRepository::class,
                'model' => PermissionDomain\PermissionEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PermissionDomain\Contracts\PermissionRepositoryInterface::class => PermissionDomain\PermissionRepository::class,
    ]
];
