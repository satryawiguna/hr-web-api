<?php

use App\Domains\HumanResources\Element\ElementEntryValue as ElementEntryValueDomain;
use App\Infrastructures\HumanResources\Element\ElementEntryValue as ElementEntryValueInfrastructure;

return [
    'providers' => [
        ElementEntryValueDomain\Contracts\ElementEntryValueServiceInterface::class => ElementEntryValueDomain\ElementEntryValueService::class,
        ElementEntryValueDomain\Contracts\ElementEntryValueInterface::class => ElementEntryValueDomain\ElementEntryValueEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ElementEntryValueInfrastructure\Contracts\EloquentElementEntryValueRepositoryInterface::class => [
                'class' => ElementEntryValueInfrastructure\EloquentElementEntryValueRepository::class,
                'model' => ElementEntryValueDomain\ElementEntryValueEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ElementEntryValueDomain\Contracts\ElementEntryValueRepositoryInterface::class => ElementEntryValueDomain\ElementEntryValueRepository::class,
    ]
];
