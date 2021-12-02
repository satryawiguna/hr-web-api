<?php

use App\Domains\HumanResources\Formula as FormulaDomain;
use App\Infrastructures\HumanResources\Formula as FormulaInfrastructure;

return [
    'providers' => [
        FormulaDomain\Contracts\FormulaServiceInterface::class => FormulaDomain\FormulaService::class,
        FormulaDomain\Contracts\FormulaInterface::class => FormulaDomain\FormulaEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        FormulaInfrastructure\Contracts\EloquentFormulaRepositoryInterface::class => [
                'class' => FormulaInfrastructure\EloquentFormulaRepository::class,
                'model' => FormulaDomain\FormulaEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        FormulaDomain\Contracts\FormulaRepositoryInterface::class => FormulaDomain\FormulaRepository::class,
    ]
];
