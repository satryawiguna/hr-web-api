<?php

use App\Domains\Commons\Religion as ReligionDomain;
use App\Infrastructures\Commons\Religion as ReligionInfrastructure;

return [
    'providers' => [
        ReligionDomain\Contracts\ReligionServiceInterface::class => ReligionDomain\ReligionService::class,
        ReligionDomain\Contracts\ReligionInterface::class => ReligionDomain\ReligionEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ReligionInfrastructure\Contracts\EloquentReligionRepositoryInterface::class => [
                'class' => ReligionInfrastructure\EloquentReligionRepository::class,
                'model' => ReligionDomain\ReligionEloquent::class
            ]
    ],
    'repositories' => [
        // Domains Repository
        ReligionDomain\Contracts\ReligionRepositoryInterface::class => ReligionDomain\ReligionRepository::class,
    ]
];
