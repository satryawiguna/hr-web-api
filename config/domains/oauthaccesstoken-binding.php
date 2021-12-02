<?php

use App\Domains\Auth\OAuthAccessToken as OAuthAccessTokenDomain;
use App\Infrastructures\Auth\OAuthAccessToken as OAuthAccessTokenInfrastructure;

return [
    'providers' => [
        OAuthAccessTokenDomain\Contracts\OAuthAccessTokenServiceInterface::class => OAuthAccessTokenDomain\OAuthAccessTokenService::class,
        OAuthAccessTokenDomain\Contracts\OAuthAccessTokenInterface::class => OAuthAccessTokenDomain\OAuthAccessTokenEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        OAuthAccessTokenInfrastructure\Contracts\EloquentOAuthAccessTokenRepositoryInterface::class => [
                'class' => OAuthAccessTokenInfrastructure\EloquentOAuthAccessTokenRepository::class,
                'model' => OAuthAccessTokenDomain\OAuthAccessTokenEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        OAuthAccessTokenDomain\Contracts\OAuthAccessTokenRepositoryInterface::class => OAuthAccessTokenDomain\OAuthAccessTokenRepository::class,
    ]
];
