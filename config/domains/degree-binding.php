<?php

use App\Domains\Commons\Degree as DegreeDomain;
use App\Infrastructures\Commons\Degree as DegreeInfrastructure;

return [
    'providers' => [
        DegreeDomain\Contracts\DegreeServiceInterface::class => DegreeDomain\DegreeService::class,
        DegreeDomain\Contracts\DegreeInterface::class => DegreeDomain\DegreeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        DegreeInfrastructure\Contracts\EloquentDegreeRepositoryInterface::class => [
                'class' => DegreeInfrastructure\EloquentDegreeRepository::class,
                'model' => DegreeDomain\DegreeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        DegreeDomain\Contracts\DegreeRepositoryInterface::class => DegreeDomain\DegreeRepository::class,
    ]
];
