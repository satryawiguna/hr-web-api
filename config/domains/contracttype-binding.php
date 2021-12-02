<?php

use App\Domains\Commons\ContractType as ContractTypeDomain;
use App\Infrastructures\Commons\ContractType as ContractTypeInfrastructure;

return [
    'providers' => [
        ContractTypeDomain\Contracts\ContractTypeServiceInterface::class => ContractTypeDomain\ContractTypeService::class,
        ContractTypeDomain\Contracts\ContractTypeInterface::class => ContractTypeDomain\ContractTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ContractTypeInfrastructure\Contracts\EloquentContractTypeRepositoryInterface::class => [
                'class' => ContractTypeInfrastructure\EloquentContractTypeRepository::class,
                'model' => ContractTypeDomain\ContractTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ContractTypeDomain\Contracts\ContractTypeRepositoryInterface::class => ContractTypeDomain\ContractTypeRepository::class,
    ]
];
