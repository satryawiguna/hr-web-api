<?php

use App\Domains\Commons\VacancyCategory as VacancyCategoryDomain;
use App\Infrastructures\Commons\VacancyCategory as VacancyCategoryInfrastructure;

return [
    'providers' => [
        VacancyCategoryDomain\Contracts\VacancyCategoryServiceInterface::class => VacancyCategoryDomain\VacancyCategoryService::class,
        VacancyCategoryDomain\Contracts\VacancyCategoryInterface::class => VacancyCategoryDomain\VacancyCategoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        VacancyCategoryInfrastructure\Contracts\EloquentVacancyCategoryRepositoryInterface::class => [
                'class' => VacancyCategoryInfrastructure\EloquentVacancyCategoryRepository::class,
                'model' => VacancyCategoryDomain\VacancyCategoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        VacancyCategoryDomain\Contracts\VacancyCategoryRepositoryInterface::class => VacancyCategoryDomain\VacancyCategoryRepository::class,
    ]
];
