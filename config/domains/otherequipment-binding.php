<?php

use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment as OtherEquipmentDomain;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment as OtherEquipmentInfrastructure;

return [
    'providers' => [
        OtherEquipmentDomain\Contracts\OtherEquipmentServiceInterface::class => OtherEquipmentDomain\OtherEquipmentService::class,
        OtherEquipmentDomain\Contracts\OtherEquipmentInterface::class => OtherEquipmentDomain\OtherEquipmentEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        OtherEquipmentInfrastructure\Contracts\EloquentOtherEquipmentRepositoryInterface::class => [
                'class' => OtherEquipmentInfrastructure\EloquentOtherEquipmentRepository::class,
                'model' => OtherEquipmentDomain\OtherEquipmentEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        OtherEquipmentDomain\Contracts\OtherEquipmentRepositoryInterface::class => OtherEquipmentDomain\OtherEquipmentRepository::class,
    ]
];
