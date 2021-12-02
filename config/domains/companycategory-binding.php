<?php

use App\Domains\Commons\CompanyCategory as CompanyCategoryDomain;
use App\Infrastructures\Commons\CompanyCategory as CompanyCategoryInfrastructure;

return [
    'providers' => [
        CompanyCategoryDomain\Contracts\CompanyCategoryServiceInterface::class => CompanyCategoryDomain\CompanyCategoryService::class,
        CompanyCategoryDomain\Contracts\CompanyCategoryInterface::class => CompanyCategoryDomain\CompanyCategoryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        CompanyCategoryInfrastructure\Contracts\EloquentCompanyCategoryRepositoryInterface::class => [
                'class' => CompanyCategoryInfrastructure\EloquentCompanyCategoryRepository::class,
                'model' => CompanyCategoryDomain\CompanyCategoryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        CompanyCategoryDomain\Contracts\CompanyCategoryRepositoryInterface::class => CompanyCategoryDomain\CompanyCategoryRepository::class,
    ]
];
