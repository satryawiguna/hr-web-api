<?php

use App\Domains\HumanResources\MasterData\Grade as GradeDomain;
use App\Infrastructures\HumanResources\MasterData\Grade as GradeInfrastructure;

return [
    'providers' => [
        GradeDomain\Contracts\GradeServiceInterface::class => GradeDomain\GradeService::class,
        GradeDomain\Contracts\GradeInterface::class => GradeDomain\GradeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        GradeInfrastructure\Contracts\EloquentGradeRepositoryInterface::class => [
                'class' => GradeInfrastructure\EloquentGradeRepository::class,
                'model' => GradeDomain\GradeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        GradeDomain\Contracts\GradeRepositoryInterface::class => GradeDomain\GradeRepository::class,
    ]
];
