<?php

use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory as NonFormalEducationHistoryDomain;
use App\Infrastructures\NonFormalEducationHistory as NonFormalEducationHistoryInfrastructure;

return [
    'providers' => [
        NonFormalEducationHistoryDomain\Contracts\NonFormalEducationHistoryServiceInterface::class => NonFormalEducationHistoryDomain\NonFormalEducationHistoryService::class,
        NonFormalEducationHistoryDomain\Contracts\NonFormalEducationHistoryInterface::class => NonFormalEducationHistoryDomain\NonFormalEducationHistoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        NonFormalEducationHistoryInfrastructure\Contracts\EloquentNonFormalEducationHistoryRepositoryInterface::class => [
                'class' => NonFormalEducationHistoryInfrastructure\EloquentNonFormalEducationHistoryRepository::class,
                'model' => NonFormalEducationHistoryDomain\NonFormalEducationHistoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        NonFormalEducationHistoryDomain\Contracts\NonFormalEducationHistoryRepositoryInterface::class => NonFormalEducationHistoryDomain\NonFormalEducationHistoryRepository::class,
    ]
];
