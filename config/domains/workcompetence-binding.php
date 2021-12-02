<?php

use App\Domains\HumanResources\Personal\Employee\WorkCompetence as WorkCompetenceDomain;
use App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence as WorkCompetenceInfrastructure;

return [
    'providers' => [
        WorkCompetenceDomain\Contracts\WorkCompetenceServiceInterface::class => WorkCompetenceDomain\WorkCompetenceService::class,
        WorkCompetenceDomain\Contracts\WorkCompetenceInterface::class => WorkCompetenceDomain\WorkCompetenceEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkCompetenceInfrastructure\Contracts\EloquentWorkCompetenceRepositoryInterface::class => [
                'class' => WorkCompetenceInfrastructure\EloquentWorkCompetenceRepository::class,
                'model' => WorkCompetenceDomain\WorkCompetenceEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkCompetenceDomain\Contracts\WorkCompetenceRepositoryInterface::class => WorkCompetenceDomain\WorkCompetenceRepository::class,
    ]
];
