<?php

use App\Domains\HumanResources\Mutation\WorkUnitMutation as WorkUnitMutationDomain;
use App\Infrastructures\HumanResources\Mutation\WorkUnitMutation as WorkUnitMutationInfrastructure;

return [
    'providers' => [
        WorkUnitMutationDomain\Contracts\WorkUnitMutationServiceInterface::class => WorkUnitMutationDomain\WorkUnitMutationService::class,
        WorkUnitMutationDomain\Contracts\WorkUnitMutationInterface::class => WorkUnitMutationDomain\WorkUnitMutationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkUnitMutationInfrastructure\Contracts\EloquentWorkUnitMutationRepositoryInterface::class => [
                'class' => WorkUnitMutationInfrastructure\EloquentWorkUnitMutationRepository::class,
                'model' => WorkUnitMutationDomain\WorkUnitMutationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkUnitMutationDomain\Contracts\WorkUnitMutationRepositoryInterface::class => WorkUnitMutationDomain\WorkUnitMutationRepository::class,
    ]
];
