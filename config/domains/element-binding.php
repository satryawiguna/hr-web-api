<?php

use App\Domains\HumanResources\Element as ElementDomain;
use App\Infrastructures\HumanResources\Element as ElementInfrastructure;

return [
    'providers' => [
        ElementDomain\Contracts\ElementServiceInterface::class => ElementDomain\ElementService::class,
        ElementDomain\Contracts\ElementInterface::class => ElementDomain\ElementEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ElementInfrastructure\Contracts\EloquentElementRepositoryInterface::class => [
                'class' => ElementInfrastructure\EloquentElementRepository::class,
                'model' => ElementDomain\ElementEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ElementDomain\Contracts\ElementRepositoryInterface::class => ElementDomain\ElementRepository::class,
    ]
];
