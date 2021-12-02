<?php

use App\Domains\HumanResources\Mutation\ProjectMutation as ProjectMutationDomain;
use App\Infrastructures\HumanResources\Mutation\ProjectMutation as ProjectMutationInfrastructure;

return [
    'providers' => [
        ProjectMutationDomain\Contracts\ProjectMutationServiceInterface::class => ProjectMutationDomain\ProjectMutationService::class,
        ProjectMutationDomain\Contracts\ProjectMutationInterface::class => ProjectMutationDomain\ProjectMutationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ProjectMutationInfrastructure\Contracts\EloquentProjectMutationRepositoryInterface::class => [
                'class' => ProjectMutationInfrastructure\EloquentProjectMutationRepository::class,
                'model' => ProjectMutationDomain\ProjectMutationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ProjectMutationDomain\Contracts\ProjectMutationRepositoryInterface::class => ProjectMutationDomain\ProjectMutationRepository::class,
    ]
];
