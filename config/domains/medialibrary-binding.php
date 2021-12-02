<?php

use App\Domains\MediaLibrary as MediaLibraryDomain;
use App\Infrastructures\MediaLibrary as MediaLibraryInfrastructure;

return [
    'providers' => [
        MediaLibraryDomain\Contracts\MediaLibraryServiceInterface::class => MediaLibraryDomain\MediaLibraryService::class,
        MediaLibraryDomain\Contracts\MediaLibraryInterface::class => MediaLibraryDomain\MediaLibraryEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        MediaLibraryInfrastructure\Contracts\EloquentMediaLibraryRepositoryInterface::class => [
                'class' => MediaLibraryInfrastructure\EloquentMediaLibraryRepository::class,
                'model' => MediaLibraryDomain\MediaLibraryEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        MediaLibraryDomain\Contracts\MediaLibraryRepositoryInterface::class => MediaLibraryDomain\MediaLibraryRepository::class,
    ]
];
