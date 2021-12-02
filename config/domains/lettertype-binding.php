<?php

use App\Domains\HumanResources\MasterData\LetterType as LetterTypeDomain;
use App\Infrastructures\HumanResources\MasterData\LetterType as LetterTypeInfrastructure;

return [
    'providers' => [
        LetterTypeDomain\Contracts\LetterTypeServiceInterface::class => LetterTypeDomain\LetterTypeService::class,
        LetterTypeDomain\Contracts\LetterTypeInterface::class => LetterTypeDomain\LetterTypeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        LetterTypeInfrastructure\Contracts\EloquentLetterTypeRepositoryInterface::class => [
                'class' => LetterTypeInfrastructure\EloquentLetterTypeRepository::class,
                'model' => LetterTypeDomain\LetterTypeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        LetterTypeDomain\Contracts\LetterTypeRepositoryInterface::class => LetterTypeDomain\LetterTypeRepository::class,
    ]
];
