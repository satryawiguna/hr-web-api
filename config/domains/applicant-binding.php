<?php

use App\Domains\HumanResources\Recruitment\Applicant as ApplicantDomain;
use App\Infrastructures\HumanResources\Recruitment\Applicant as ApplicantInfrastructure;

return [
    'providers' => [
        ApplicantDomain\Contracts\ApplicantServiceInterface::class => ApplicantDomain\ApplicantService::class,
        ApplicantDomain\Contracts\ApplicantInterface::class => ApplicantDomain\ApplicantEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ApplicantInfrastructure\Contracts\EloquentApplicantRepositoryInterface::class => [
                'class' => ApplicantInfrastructure\EloquentApplicantRepository::class,
                'model' => ApplicantDomain\ApplicantEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ApplicantDomain\Contracts\ApplicantRepositoryInterface::class => ApplicantDomain\ApplicantRepository::class,
    ]
];
