<?php

use App\Domains\HumanResources\MasterData\WorkArea as WorkAreaDomain;
use App\Infrastructures\HumanResources\MasterData\WorkArea as WorkAreaInfrastructure;

return [
    'providers' => [
        WorkAreaDomain\Contracts\WorkAreaServiceInterface::class => WorkAreaDomain\WorkAreaService::class,
        WorkAreaDomain\Contracts\WorkAreaInterface::class => WorkAreaDomain\WorkAreaEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkAreaInfrastructure\Contracts\EloquentWorkAreaRepositoryInterface::class => [
                'class' => WorkAreaInfrastructure\EloquentWorkAreaRepository::class,
                'model' => WorkAreaDomain\WorkAreaEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkAreaDomain\Contracts\WorkAreaRepositoryInterface::class => WorkAreaDomain\WorkAreaRepository::class,
    ]
];
