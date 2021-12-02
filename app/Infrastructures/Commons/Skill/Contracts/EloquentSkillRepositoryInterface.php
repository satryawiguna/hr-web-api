<?php

namespace App\Infrastructures\Commons\Skill\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentSkillRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
