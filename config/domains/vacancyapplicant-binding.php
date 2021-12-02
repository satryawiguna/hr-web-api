<?php

use App\Domains\HumanResources\Recruitment\VacancyApplicant as VacancyApplicantDomain;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicant as VacancyApplicantInfrastructure;

return [
    'providers' => [
        VacancyApplicantDomain\Contracts\VacancyApplicantServiceInterface::class => VacancyApplicantDomain\VacancyApplicantService::class,
        VacancyApplicantDomain\Contracts\VacancyApplicantInterface::class => VacancyApplicantDomain\VacancyApplicantEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        VacancyApplicantInfrastructure\Contracts\EloquentVacancyApplicantRepositoryInterface::class => [
                'class' => VacancyApplicantInfrastructure\EloquentVacancyApplicantRepository::class,
                'model' => VacancyApplicantDomain\VacancyApplicantEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        VacancyApplicantDomain\Contracts\VacancyApplicantRepositoryInterface::class => VacancyApplicantDomain\VacancyApplicantRepository::class,
    ]
];
