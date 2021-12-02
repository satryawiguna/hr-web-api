<?php

use App\Domains\HumanResources\Element\ElementValue as ElementValueDomain;
use App\Infrastructures\HumanResources\Element\ElementValue as ElementValueInfrastructure;

return [
    'providers' => [
        ElementValueDomain\Contracts\ElementValueServiceInterface::class => ElementValueDomain\ElementValueService::class,
        ElementValueDomain\Contracts\ElementValueInterface::class => ElementValueDomain\ElementValueEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ElementValueInfrastructure\Contracts\EloquentElementValueRepositoryInterface::class => [
                'class' => ElementValueInfrastructure\EloquentElementValueRepository::class,
                'model' => ElementValueDomain\ElementValueEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ElementValueDomain\Contracts\ElementValueRepositoryInterface::class => ElementValueDomain\ElementValueRepository::class,
    ]
];
