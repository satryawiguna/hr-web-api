<?php

use App\Domains\Commons\VacancyLocation as VacancyLocationDomain;
use App\Infrastructures\Commons\VacancyLocation as VacancyLocationInfrastructure;

return [
    'providers' => [
        VacancyLocationDomain\Contracts\VacancyLocationServiceInterface::class => VacancyLocationDomain\VacancyLocationService::class,
        VacancyLocationDomain\Contracts\VacancyLocationInterface::class => VacancyLocationDomain\VacancyLocationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        VacancyLocationInfrastructure\Contracts\EloquentVacancyLocationRepositoryInterface::class => [
                'class' => VacancyLocationInfrastructure\EloquentVacancyLocationRepository::class,
                'model' => VacancyLocationDomain\VacancyLocationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        VacancyLocationDomain\Contracts\VacancyLocationRepositoryInterface::class => VacancyLocationDomain\VacancyLocationRepository::class,
    ]
];
