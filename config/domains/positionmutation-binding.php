<?php

use App\Domains\HumanResources\Mutation\PositionMutation as PositionMutationDomain;
use App\Infrastructures\HumanResources\Mutation\PositionMutation as PositionMutationInfrastructure;

return [
    'providers' => [
        PositionMutationDomain\Contracts\PositionMutationServiceInterface::class => PositionMutationDomain\PositionMutationService::class,
        PositionMutationDomain\Contracts\PositionMutationInterface::class => PositionMutationDomain\PositionMutationEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PositionMutationInfrastructure\Contracts\EloquentPositionMutationRepositoryInterface::class => [
                'class' => PositionMutationInfrastructure\EloquentPositionMutationRepository::class,
                'model' => PositionMutationDomain\PositionMutationEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PositionMutationDomain\Contracts\PositionMutationRepositoryInterface::class => PositionMutationDomain\PositionMutationRepository::class,
    ]
];
