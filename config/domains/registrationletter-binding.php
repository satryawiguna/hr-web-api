<?php

use App\Domains\RegistrationLetter as RegistrationLetterDomain;
use App\Infrastructures\RegistrationLetter as RegistrationLetterInfrastructure;

return [
    'providers' => [
        RegistrationLetterDomain\Contracts\RegistrationLetterServiceInterface::class => RegistrationLetterDomain\RegistrationLetterService::class,
        RegistrationLetterDomain\Contracts\RegistrationLetterInterface::class => RegistrationLetterDomain\RegistrationLetterEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        RegistrationLetterInfrastructure\Contracts\EloquentRegistrationLetterRepositoryInterface::class => [
                'class' => RegistrationLetterInfrastructure\EloquentRegistrationLetterRepository::class,
                'model' => RegistrationLetterDomain\RegistrationLetterEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        RegistrationLetterDomain\Contracts\RegistrationLetterRepositoryInterface::class => RegistrationLetterDomain\RegistrationLetterRepository::class,
    ]
];
