<?php

use App\Domains\HumanResources\Personal\Employee\Child as ChildDomain;
use App\Infrastructures\HumanResources\Personal\Employee\Child as ChildInfrastructure;

return [
    'providers' => [
        ChildDomain\Contracts\ChildServiceInterface::class => ChildDomain\ChildService::class,
        ChildDomain\Contracts\ChildInterface::class => ChildDomain\ChildEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ChildInfrastructure\Contracts\EloquentChildRepositoryInterface::class => [
                'class' => ChildInfrastructure\EloquentChildRepository::class,
                'model' => ChildDomain\ChildEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ChildDomain\Contracts\ChildRepositoryInterface::class => ChildDomain\ChildRepository::class,
    ]
];
