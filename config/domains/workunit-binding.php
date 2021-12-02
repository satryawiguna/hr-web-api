<?php

use App\Domains\HumanResources\MasterData\WorkUnit as WorkUnitDomain;
use App\Infrastructures\HumanResources\MasterData\WorkUnit as WorkUnitInfrastructure;

return [
    'providers' => [
        WorkUnitDomain\Contracts\WorkUnitServiceInterface::class => WorkUnitDomain\WorkUnitService::class,
        WorkUnitDomain\Contracts\WorkUnitInterface::class => WorkUnitDomain\WorkUnitEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkUnitInfrastructure\Contracts\EloquentWorkUnitRepositoryInterface::class => [
                'class' => WorkUnitInfrastructure\EloquentWorkUnitRepository::class,
                'model' => WorkUnitDomain\WorkUnitEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkUnitDomain\Contracts\WorkUnitRepositoryInterface::class => WorkUnitDomain\WorkUnitRepository::class,
    ]
];
