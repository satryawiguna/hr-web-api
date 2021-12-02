<?php

use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory as FormalEducationHistoryDomain;
use App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory as FormalEducationHistoryInfrastructure;

return [
    'providers' => [
        FormalEducationHistoryDomain\Contracts\FormalEducationHistoryServiceInterface::class => FormalEducationHistoryDomain\FormalEducationHistoryService::class,
        FormalEducationHistoryDomain\Contracts\FormalEducationHistoryInterface::class => FormalEducationHistoryDomain\FormalEducationHistoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        FormalEducationHistoryInfrastructure\Contracts\EloquentFormalEducationHistoryRepositoryInterface::class => [
                'class' => FormalEducationHistoryInfrastructure\EloquentFormalEducationHistoryRepository::class,
                'model' => FormalEducationHistoryDomain\FormalEducationHistoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        FormalEducationHistoryDomain\Contracts\FormalEducationHistoryRepositoryInterface::class => FormalEducationHistoryDomain\FormalEducationHistoryRepository::class,
    ]
];
