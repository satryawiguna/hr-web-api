<?php

use App\Domains\User\Profile as ProfileDomain;
use App\Infrastructures\User\Profile as ProfileInfrastructure;

return [
    'providers' => [
        ProfileDomain\Contracts\ProfileServiceInterface::class => ProfileDomain\ProfileService::class,
        ProfileDomain\Contracts\ProfileInterface::class => ProfileDomain\ProfileEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ProfileInfrastructure\Contracts\EloquentProfileRepositoryInterface::class => [
                'class' => ProfileInfrastructure\EloquentProfileRepository::class,
                'model' => ProfileDomain\ProfileEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ProfileDomain\Contracts\ProfileRepositoryInterface::class => ProfileDomain\ProfileRepository::class,
    ]
];
