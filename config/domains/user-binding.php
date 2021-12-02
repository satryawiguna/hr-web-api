<?php

use App\Domains\User as UserDomain;
use App\Infrastructures\User as UserInfrastructure;

return [
    'providers' => [
        UserDomain\Contracts\UserServiceInterface::class => UserDomain\UserService::class,
        UserDomain\Contracts\UserInterface::class => UserDomain\UserEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        UserInfrastructure\Contracts\EloquentUserRepositoryInterface::class => [
                'class' => UserInfrastructure\EloquentUserRepository::class,
                'model' => UserDomain\UserEloquent::class
            ]
    ],
    'repositories' => [
        // Domains Repository
        UserDomain\Contracts\UserRepositoryInterface::class => UserDomain\UserRepository::class,
    ]
];
