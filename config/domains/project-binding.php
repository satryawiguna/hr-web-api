<?php

use App\Domains\HumanResources\Project as ProjectDomain;
use App\Infrastructures\HumanResources\Project as ProjectInfrastructure;

return [
    'providers' => [
        ProjectDomain\Contracts\ProjectServiceInterface::class => ProjectDomain\ProjectService::class,
        ProjectDomain\Contracts\ProjectInterface::class => ProjectDomain\ProjectEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ProjectInfrastructure\Contracts\EloquentProjectRepositoryInterface::class => [
                'class' => ProjectInfrastructure\EloquentProjectRepository::class,
                'model' => ProjectDomain\ProjectEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ProjectDomain\Contracts\ProjectRepositoryInterface::class => ProjectDomain\ProjectRepository::class,
    ]
];
