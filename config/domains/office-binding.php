<?php

use App\Domains\Commons\Office as OfficeDomain;
use App\Infrastructures\Commons\Office as OfficeInfrastructure;

return [
    'providers' => [
        OfficeDomain\Contracts\OfficeServiceInterface::class => OfficeDomain\OfficeService::class,
        OfficeDomain\Contracts\OfficeInterface::class => OfficeDomain\OfficeEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        OfficeInfrastructure\Contracts\EloquentOfficeRepositoryInterface::class => [
                'class' => OfficeInfrastructure\EloquentOfficeRepository::class,
                'model' => OfficeDomain\OfficeEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        OfficeDomain\Contracts\OfficeRepositoryInterface::class => OfficeDomain\OfficeRepository::class,
    ]
];
