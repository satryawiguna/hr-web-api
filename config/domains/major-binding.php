<?php

use App\Domains\Commons\Major as MajorDomain;
use App\Infrastructures\Commons\Major as MajorInfrastructure;

return [
    'providers' => [
        MajorDomain\Contracts\MajorServiceInterface::class => MajorDomain\MajorService::class,
        MajorDomain\Contracts\MajorInterface::class => MajorDomain\MajorEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        MajorInfrastructure\Contracts\EloquentMajorRepositoryInterface::class => [
                'class' => MajorInfrastructure\EloquentMajorRepository::class,
                'model' => MajorDomain\MajorEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        MajorDomain\Contracts\MajorRepositoryInterface::class => MajorDomain\MajorRepository::class,
    ]
];
