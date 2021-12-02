<?php

use App\Domains\Area\State as StateDomain;
use App\Infrastructures\Area\State as StateInfrastructure;

return [
    'providers' => [
        StateDomain\Contracts\StateServiceInterface::class => StateDomain\StateService::class,
        StateDomain\Contracts\StateInterface::class => StateDomain\StateEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        StateInfrastructure\Contracts\EloquentStateRepositoryInterface::class => [
                'class' => StateInfrastructure\EloquentStateRepository::class,
                'model' => StateDomain\StateEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        StateDomain\Contracts\StateRepositoryInterface::class => StateDomain\StateRepository::class,
    ]
];
