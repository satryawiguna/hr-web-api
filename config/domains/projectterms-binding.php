<?php

use App\Domains\HumanResources\Project\ProjectTerms as ProjectTermsDomain;
use App\Infrastructures\HumanResources\Project\ProjectTerms as ProjectTermsInfrastructure;

return [
    'providers' => [
        ProjectTermsDomain\Contracts\ProjectTermsInterface::class => ProjectTermsDomain\ProjectTermsEloquent::class
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ProjectTermsInfrastructure\Contracts\EloquentProjectTermsRepositoryInterface::class => [
                'class' => ProjectTermsInfrastructure\EloquentProjectTermsRepository::class,
                'model' => ProjectTermsDomain\ProjectTermsEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ProjectTermsDomain\Contracts\ProjectTermsRepositoryInterface::class => ProjectTermsDomain\ProjectTermsRepository::class,
    ]
];
