<?php
namespace App\Infrastructures\Commons\Skill;

use App\Infrastructures\Commons\Skill\Contracts\EloquentSkillRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentSkillRepository Class.
 */
class EloquentSkillRepository extends EloquentRepositoryAbstract implements EloquentSkillRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
