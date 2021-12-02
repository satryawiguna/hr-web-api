<?php

use App\Domains\HumanResources\MasterData\SalaryStructure as SalaryStructureDomain;
use App\Infrastructures\HumanResources\MasterData\SalaryStructure as SalaryStructureInfrastructure;

return [
    'providers' => [
        SalaryStructureDomain\Contracts\SalaryStructureServiceInterface::class => SalaryStructureDomain\SalaryStructureService::class,
        SalaryStructureDomain\Contracts\SalaryStructureInterface::class => SalaryStructureDomain\SalaryStructureEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        SalaryStructureInfrastructure\Contracts\EloquentSalaryStructureRepositoryInterface::class => [
                'class' => SalaryStructureInfrastructure\EloquentSalaryStructureRepository::class,
                'model' => SalaryStructureDomain\SalaryStructureEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        SalaryStructureDomain\Contracts\SalaryStructureRepositoryInterface::class => SalaryStructureDomain\SalaryStructureRepository::class,
    ]
];
