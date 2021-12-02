<?php

use App\Domains\WorkAgreementLetter as WorkAgreementLetterDomain;
use App\Infrastructures\WorkAgreementLetter as WorkAgreementLetterInfrastructure;

return [
    'providers' => [
        WorkAgreementLetterDomain\Contracts\WorkAgreementLetterServiceInterface::class => WorkAgreementLetterDomain\WorkAgreementLetterService::class,
        WorkAgreementLetterDomain\Contracts\WorkAgreementLetterInterface::class => WorkAgreementLetterDomain\WorkAgreementLetterEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        WorkAgreementLetterInfrastructure\Contracts\EloquentWorkAgreementLetterRepositoryInterface::class => [
                'class' => WorkAgreementLetterInfrastructure\EloquentWorkAgreementLetterRepository::class,
                'model' => WorkAgreementLetterDomain\WorkAgreementLetterEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        WorkAgreementLetterDomain\Contracts\WorkAgreementLetterRepositoryInterface::class => WorkAgreementLetterDomain\WorkAgreementLetterRepository::class,
    ]
];
