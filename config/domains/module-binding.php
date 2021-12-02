<?php

use App\Domains\Commons\Module as ModuleDomain;
use App\Infrastructures\Commons\Module as ModuleInfrastructure;

return [
    'providers' => [
        ModuleDomain\Contracts\ModuleServiceInterface::class => ModuleDomain\ModuleService::class,
        ModuleDomain\Contracts\ModuleInterface::class => ModuleDomain\ModuleEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ModuleInfrastructure\Contracts\EloquentModuleRepositoryInterface::class => [
                'class' => ModuleInfrastructure\EloquentModuleRepository::class,
                'model' => ModuleDomain\ModuleEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ModuleDomain\Contracts\ModuleRepositoryInterface::class => ModuleDomain\ModuleRepository::class,
    ]
];
