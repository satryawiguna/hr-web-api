<?php

use App\Domains\HumanResources\Vacancy as VacancyDomain;
use App\Infrastructures\HumanResources\Vacancy as VacancyInfrastructure;

return [
    'providers' => [
        VacancyDomain\Contracts\VacancyServiceInterface::class => VacancyDomain\VacancyService::class,
        VacancyDomain\Contracts\VacancyInterface::class => VacancyDomain\VacancyEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        VacancyInfrastructure\Contracts\EloquentVacancyRepositoryInterface::class => [
                'class' => VacancyInfrastructure\EloquentVacancyRepository::class,
                'model' => VacancyDomain\VacancyEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        VacancyDomain\Contracts\VacancyRepositoryInterface::class => VacancyDomain\VacancyRepository::class,
    ]
];
