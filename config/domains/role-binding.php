<?php

use App\Domains\Commons\Role as RoleDomain;
use App\Infrastructures\Commons\Role as RoleInfrastructure;

return [
    'providers' => [
        RoleDomain\Contracts\RoleServiceInterface::class => RoleDomain\RoleService::class,
        RoleDomain\Contracts\RoleInterface::class => RoleDomain\RoleEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        RoleInfrastructure\Contracts\EloquentRoleRepositoryInterface::class => [
                'class' => RoleInfrastructure\EloquentRoleRepository::class,
                'model' => RoleDomain\RoleEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        RoleDomain\Contracts\RoleRepositoryInterface::class => RoleDomain\RoleRepository::class,
    ]
];
