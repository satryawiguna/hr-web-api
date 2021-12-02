<?php

use App\Domains\HumanResources\Recruitment\RecruitmentSchedule as RecruitmentScheduleDomain;
use App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule as RecruitmentScheduleInfrastructure;

return [
    'providers' => [
        RecruitmentScheduleDomain\Contracts\RecruitmentScheduleServiceInterface::class => RecruitmentScheduleDomain\RecruitmentScheduleService::class,
        RecruitmentScheduleDomain\Contracts\RecruitmentScheduleInterface::class => RecruitmentScheduleDomain\RecruitmentScheduleEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        RecruitmentScheduleInfrastructure\Contracts\EloquentRecruitmentScheduleRepositoryInterface::class => [
                'class' => RecruitmentScheduleInfrastructure\EloquentRecruitmentScheduleRepository::class,
                'model' => RecruitmentScheduleDomain\RecruitmentScheduleEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        RecruitmentScheduleDomain\Contracts\RecruitmentScheduleRepositoryInterface::class => RecruitmentScheduleDomain\RecruitmentScheduleRepository::class,
    ]
];
