<?php

use App\Domains\Commons\Company as CompanyDomain;
use App\Infrastructures\Commons\Company as CompanyInfrastructure;

return [
    'providers' => [
        CompanyDomain\Contracts\CompanyServiceInterface::class => CompanyDomain\CompanyService::class,
        CompanyDomain\Contracts\CompanyInterface::class => CompanyDomain\CompanyEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        CompanyInfrastructure\Contracts\EloquentCompanyRepositoryInterface::class => [
                'class' => CompanyInfrastructure\EloquentCompanyRepository::class,
                'model' => CompanyDomain\CompanyEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        CompanyDomain\Contracts\CompanyRepositoryInterface::class => CompanyDomain\CompanyRepository::class,
    ]
];
