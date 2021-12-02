<?php

use App\Domains\HumanResources\Recruitment\VacancyApplicationNote as VacancyApplicationNoteDomain;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicationNote as VacancyApplicationNoteInfrastructure;

return [
    'providers' => [
        VacancyApplicationNoteDomain\Contracts\VacancyApplicationNoteServiceInterface::class => VacancyApplicationNoteDomain\VacancyApplicationNoteService::class,
        VacancyApplicationNoteDomain\Contracts\VacancyApplicationNoteInterface::class => VacancyApplicationNoteDomain\VacancyApplicationNoteEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        VacancyApplicationNoteInfrastructure\Contracts\EloquentVacancyApplicationNoteRepositoryInterface::class => [
                'class' => VacancyApplicationNoteInfrastructure\EloquentVacancyApplicationNoteRepository::class,
                'model' => VacancyApplicationNoteDomain\VacancyApplicationNoteEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        VacancyApplicationNoteDomain\Contracts\VacancyApplicationNoteRepositoryInterface::class => VacancyApplicationNoteDomain\VacancyApplicationNoteRepository::class,
    ]
];
