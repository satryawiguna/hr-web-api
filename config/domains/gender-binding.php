<?php

use App\Domains\Commons\Gender as GenderDomain;
use App\Infrastructures\Commons\Gender as GenderInfrastructure;

return [
    'providers' => [
        GenderDomain\Contracts\GenderServiceInterface::class => GenderDomain\GenderService::class,
        GenderDomain\Contracts\GenderInterface::class => GenderDomain\GenderEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        GenderInfrastructure\Contracts\EloquentGenderRepositoryInterface::class => [
                'class' => GenderInfrastructure\EloquentGenderRepository::class,
                'model' => GenderDomain\GenderEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        GenderDomain\Contracts\GenderRepositoryInterface::class => GenderDomain\GenderRepository::class,
    ]
];
