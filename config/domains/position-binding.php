<?php

use App\Domains\HumanResources\MasterData\Position as PositionDomain;
use App\Infrastructures\HumanResources\MasterData\Position as PositionInfrastructure;

return [
    'providers' => [
        PositionDomain\Contracts\PositionServiceInterface::class => PositionDomain\PositionService::class,
        PositionDomain\Contracts\PositionInterface::class => PositionDomain\PositionEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        PositionInfrastructure\Contracts\EloquentPositionRepositoryInterface::class => [
                'class' => PositionInfrastructure\EloquentPositionRepository::class,
                'model' => PositionDomain\PositionEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        PositionDomain\Contracts\PositionRepositoryInterface::class => PositionDomain\PositionRepository::class,
    ]
];
