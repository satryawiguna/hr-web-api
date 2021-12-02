<?php

use App\Domains\HumanResources\MasterData\AdditionalQuestion as AdditionalQuestionDomain;
use App\Infrastructures\HumanResources\MasterData\AdditionalQuestion as AdditionalQuestionInfrastructure;

return [
    'providers' => [
        AdditionalQuestionDomain\Contracts\AdditionalQuestionServiceInterface::class => AdditionalQuestionDomain\AdditionalQuestionService::class,
        AdditionalQuestionDomain\Contracts\AdditionalQuestionInterface::class => AdditionalQuestionDomain\AdditionalQuestionEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        AdditionalQuestionInfrastructure\Contracts\EloquentAdditionalQuestionRepositoryInterface::class => [
                'class' => AdditionalQuestionInfrastructure\EloquentAdditionalQuestionRepository::class,
                'model' => AdditionalQuestionDomain\AdditionalQuestionEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        AdditionalQuestionDomain\Contracts\AdditionalQuestionRepositoryInterface::class => AdditionalQuestionDomain\AdditionalQuestionRepository::class,
    ]
];
