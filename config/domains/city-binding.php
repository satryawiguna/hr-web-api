<?php

use App\Domains\Area\City as CityDomain;
use App\Infrastructures\Area\City as CityInfrastructure;

return [
    'providers' => [
        CityDomain\Contracts\CityServiceInterface::class => CityDomain\CityService::class,
        CityDomain\Contracts\CityInterface::class => CityDomain\CityEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        CityInfrastructure\Contracts\EloquentCityRepositoryInterface::class => [
                'class' => CityInfrastructure\EloquentCityRepository::class,
                'model' => CityDomain\CityEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        CityDomain\Contracts\CityRepositoryInterface::class => CityDomain\CityRepository::class,
    ]
];
