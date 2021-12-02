<?php

use App\Domains\HumanResources\MasterData\RecruitmentStage as RecruitmentStageDomain;
use App\Infrastructures\HumanResources\MasterData\RecruitmentStage as RecruitmentStageInfrastructure;

return [
    'providers' => [
        RecruitmentStageDomain\Contracts\RecruitmentStageServiceInterface::class => RecruitmentStageDomain\RecruitmentStageService::class,
        RecruitmentStageDomain\Contracts\RecruitmentStageInterface::class => RecruitmentStageDomain\RecruitmentStageEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        RecruitmentStageInfrastructure\Contracts\EloquentRecruitmentStageRepositoryInterface::class => [
                'class' => RecruitmentStageInfrastructure\EloquentRecruitmentStageRepository::class,
                'model' => RecruitmentStageDomain\RecruitmentStageEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        RecruitmentStageDomain\Contracts\RecruitmentStageRepositoryInterface::class => RecruitmentStageDomain\RecruitmentStageRepository::class,
    ]
];
