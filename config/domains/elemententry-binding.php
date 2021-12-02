<?php

use App\Domains\HumanResources\Element\ElementEntry as ElementEntryDomain;
use App\Infrastructures\HumanResources\Element\ElementEntry as ElementEntryInfrastructure;

return [
    'providers' => [
        ElementEntryDomain\Contracts\ElementEntryServiceInterface::class => ElementEntryDomain\ElementEntryService::class,
        ElementEntryDomain\Contracts\ElementEntryInterface::class => ElementEntryDomain\ElementEntryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ElementEntryInfrastructure\Contracts\EloquentElementEntryRepositoryInterface::class => [
                'class' => ElementEntryInfrastructure\EloquentElementEntryRepository::class,
                'model' => ElementEntryDomain\ElementEntryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ElementEntryDomain\Contracts\ElementEntryRepositoryInterface::class => ElementEntryDomain\ElementEntryRepository::class,
    ]
];
