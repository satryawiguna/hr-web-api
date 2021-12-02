<?php

use App\Domains\HumanResources\Termination as TerminationDomain;
use App\Infrastructures\HumanResources\Termination as TerminationInfrastructure;

return [
    'providers' => [
        TerminationDomain\Contracts\TerminationServiceInterface::class => TerminationDomain\TerminationService::class,
        TerminationDomain\Contracts\TerminationInterface::class => TerminationDomain\TerminationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        TerminationInfrastructure\Contracts\EloquentTerminationRepositoryInterface::class => [
                'class' => TerminationInfrastructure\EloquentTerminationRepository::class,
                'model' => TerminationDomain\TerminationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        TerminationDomain\Contracts\TerminationRepositoryInterface::class => TerminationDomain\TerminationRepository::class,
    ]
];
