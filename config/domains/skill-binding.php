<?php

use App\Domains\Commons\Skill as SkillDomain;
use App\Infrastructures\Commons\Skill as SkillInfrastructure;

return [
    'providers' => [
        SkillDomain\Contracts\SkillServiceInterface::class => SkillDomain\SkillService::class,
        SkillDomain\Contracts\SkillInterface::class => SkillDomain\SkillEloquent::class,
    ],
    'eloquent_repositories' => [
        // Eloquent Repository
        SkillInfrastructure\Contracts\EloquentSkillRepositoryInterface::class => [
                'class' => SkillInfrastructure\EloquentSkillRepository::class,
                'model' => SkillDomain\SkillEloquent::class
            ]
    ],
    'repositories' => [
        // Domain Repository
        SkillDomain\Contracts\SkillRepositoryInterface::class => SkillDomain\SkillRepository::class,
    ]
];
