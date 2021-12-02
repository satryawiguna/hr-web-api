<?php

use App\Domains\HumanResources\Personal\Employee\OrganizationHistory as OrganizationHistoryDomain;
use App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory as OrganizationHistoryInfrastructure;

return [
    'providers' => [
        OrganizationHistoryDomain\Contracts\OrganizationHistoryServiceInterface::class => OrganizationHistoryDomain\OrganizationHistoryService::class,
        OrganizationHistoryDomain\Contracts\OrganizationHistoryInterface::class => OrganizationHistoryDomain\OrganizationHistoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        OrganizationHistoryInfrastructure\Contracts\EloquentOrganizationHistoryRepositoryInterface::class => [
                'class' => OrganizationHistoryInfrastructure\EloquentOrganizationHistoryRepository::class,
                'model' => OrganizationHistoryDomain\OrganizationHistoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        OrganizationHistoryDomain\Contracts\OrganizationHistoryRepositoryInterface::class => OrganizationHistoryDomain\OrganizationHistoryRepository::class,
    ]
];
