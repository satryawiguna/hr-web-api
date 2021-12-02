<?php

use App\Domains\HumanResources\MasterData\OtherType as OtherTypeDomain;
use App\Infrastructures\HumanResources\MasterData\OtherType as OtherTypeInfrastructure;

return [
    'providers' => [
        OtherTypeDomain\Contracts\OtherTypeServiceInterface::class => OtherTypeDomain\OtherTypeService::class,
        OtherTypeDomain\Contracts\OtherTypeInterface::class => OtherTypeDomain\OtherTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        OtherTypeInfrastructure\Contracts\EloquentOtherTypeRepositoryInterface::class => [
                'class' => OtherTypeInfrastructure\EloquentOtherTypeRepository::class,
                'model' => OtherTypeDomain\OtherTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        OtherTypeDomain\Contracts\OtherTypeRepositoryInterface::class => OtherTypeDomain\OtherTypeRepository::class,
    ]
];
