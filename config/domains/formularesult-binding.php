<?php

use App\Domains\HumanResources\Formula\FormulaResult as FormulaResultDomain;
use App\Infrastructures\HumanResources\Formula\FormulaResult as FormulaResultInfrastructure;

return [
    'providers' => [
        FormulaResultDomain\Contracts\FormulaResultServiceInterface::class => FormulaResultDomain\FormulaResultService::class,
        FormulaResultDomain\Contracts\FormulaResultInterface::class => FormulaResultDomain\FormulaResultEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        FormulaResultInfrastructure\Contracts\EloquentFormulaResultRepositoryInterface::class => [
                'class' => FormulaResultInfrastructure\EloquentFormulaResultRepository::class,
                'model' => FormulaResultDomain\FormulaResultEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        FormulaResultDomain\Contracts\FormulaResultRepositoryInterface::class => FormulaResultDomain\FormulaResultRepository::class,
    ]
];
