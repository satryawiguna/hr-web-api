<?php

use App\Domains\HumanResources\Personal\Employee\WorkExperience as WorkExperienceDomain;
use App\Infrastructures\HumanResources\Personal\Employee\WorkExperience as WorkExperienceInfrastructure;

return [
    'providers' => [
        WorkExperienceDomain\Contracts\WorkExperienceServiceInterface::class => WorkExperienceDomain\WorkExperienceService::class,
        WorkExperienceDomain\Contracts\WorkExperienceInterface::class => WorkExperienceDomain\WorkExperienceEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkExperienceInfrastructure\Contracts\EloquentWorkExperienceRepositoryInterface::class => [
                'class' => WorkExperienceInfrastructure\EloquentWorkExperienceRepository::class,
                'model' => WorkExperienceDomain\WorkExperienceEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkExperienceDomain\Contracts\WorkExperienceRepositoryInterface::class => WorkExperienceDomain\WorkExperienceRepository::class,
    ]
];
