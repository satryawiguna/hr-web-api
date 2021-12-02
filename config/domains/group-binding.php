<?php

use App\Domains\Commons\Group as GroupDomain;
use App\Infrastructures\Commons\Group as GroupInfrastructure;

return [
    'providers' => [
        GroupDomain\Contracts\GroupServiceInterface::class => GroupDomain\GroupService::class,
        GroupDomain\Contracts\GroupInterface::class => GroupDomain\GroupEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        GroupInfrastructure\Contracts\EloquentGroupRepositoryInterface::class => [
                'class' => GroupInfrastructure\EloquentGroupRepository::class,
                'model' => GroupDomain\GroupEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        GroupDomain\Contracts\GroupRepositoryInterface::class => GroupDomain\GroupRepository::class,
    ]
];
