<?php

use App\Domains\HumanResources\MasterData\BaseSalaryCustomType as BaseSalaryCustomTypeDomain;
use App\Infrastructures\HumanResources\MasterData\BaseSalaryCustomType as BaseSalaryCustomTypeInfrastructure;

return [
    'providers' => [
        BaseSalaryCustomTypeDomain\Contracts\BaseSalaryCustomTypeServiceInterface::class => BaseSalaryCustomTypeDomain\BaseSalaryCustomTypeService::class,
        BaseSalaryCustomTypeDomain\Contracts\BaseSalaryCustomTypeInterface::class => BaseSalaryCustomTypeDomain\BaseSalaryCustomTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        BaseSalaryCustomTypeInfrastructure\Contracts\EloquentBaseSalaryCustomTypeRepositoryInterface::class => [
                'class' => BaseSalaryCustomTypeInfrastructure\EloquentBaseSalaryCustomTypeRepository::class,
                'model' => BaseSalaryCustomTypeDomain\BaseSalaryCustomTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        BaseSalaryCustomTypeDomain\Contracts\BaseSalaryCustomTypeRepositoryInterface::class => BaseSalaryCustomTypeDomain\BaseSalaryCustomTypeRepository::class,
    ]
];
