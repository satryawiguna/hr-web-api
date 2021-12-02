<?php

use App\Domains\HumanResources\Project\ProjectAddendum as ProjectAddendumDomain;
use App\Infrastructures\HumanResources\Project\ProjectAddendum as ProjectAddendumInfrastructure;

return [
    'providers' => [
        ProjectAddendumDomain\Contracts\ProjectAddendumInterface::class => ProjectAddendumDomain\ProjectAddendumEloquent::class
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        ProjectAddendumInfrastructure\Contracts\EloquentProjectAddendumRepositoryInterface::class => [
                'class' => ProjectAddendumInfrastructure\EloquentProjectAddendumRepository::class,
                'model' => ProjectAddendumDomain\ProjectAddendumEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        ProjectAddendumDomain\Contracts\ProjectAddendumRepositoryInterface::class => ProjectAddendumDomain\ProjectAddendumRepository::class,
    ]
];
