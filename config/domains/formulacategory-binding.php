<?php

use App\Domains\HumanResources\Formula\FormulaCategory as FormulaCategoryDomain;
use App\Infrastructures\HumanResources\Formula\FormulaCategory as FormulaCategoryInfrastructure;

return [
    'providers' => [
        FormulaCategoryDomain\Contracts\FormulaCategoryServiceInterface::class => FormulaCategoryDomain\FormulaCategoryService::class,
        FormulaCategoryDomain\Contracts\FormulaCategoryInterface::class => FormulaCategoryDomain\FormulaCategoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        FormulaCategoryInfrastructure\Contracts\EloquentFormulaCategoryRepositoryInterface::class => [
                'class' => FormulaCategoryInfrastructure\EloquentFormulaCategoryRepository::class,
                'model' => FormulaCategoryDomain\FormulaCategoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        FormulaCategoryDomain\Contracts\FormulaCategoryRepositoryInterface::class => FormulaCategoryDomain\FormulaCategoryRepository::class,
    ]
];
