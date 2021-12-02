<?php

use App\Domains\HumanResources\MasterData\Competence as CompetenceDomain;
use App\Infrastructures\HumanResources\MasterData\Competence as CompetenceInfrastructure;

return [
    'providers' => [
        CompetenceDomain\Contracts\CompetenceServiceInterface::class => CompetenceDomain\CompetenceService::class,
        CompetenceDomain\Contracts\CompetenceInterface::class => CompetenceDomain\CompetenceEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        CompetenceInfrastructure\Contracts\EloquentCompetenceRepositoryInterface::class => [
                'class' => CompetenceInfrastructure\EloquentCompetenceRepository::class,
                'model' => CompetenceDomain\CompetenceEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        CompetenceDomain\Contracts\CompetenceRepositoryInterface::class => CompetenceDomain\CompetenceRepository::class,
    ]
];
