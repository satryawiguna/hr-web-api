<?php

use App\Domains\Area\Country as CountryDomain;
use App\Infrastructures\Area\Country as CountryInfrastructure;

return [
    'providers' => [
        CountryDomain\Contracts\CountryServiceInterface::class => CountryDomain\CountryService::class,
        CountryDomain\Contracts\CountryInterface::class => CountryDomain\CountryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        CountryInfrastructure\Contracts\EloquentCountryRepositoryInterface::class => [
                'class' => CountryInfrastructure\EloquentCountryRepository::class,
                'model' => CountryDomain\CountryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        CountryDomain\Contracts\CountryRepositoryInterface::class => CountryDomain\CountryRepository::class,
    ]
];
