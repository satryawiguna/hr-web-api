<?php
namespace App\Infrastructures\HumanResources\Project\ProjectTerms;

use App\Infrastructures\HumanResources\Project\ProjectTerms\Contracts\EloquentProjectTermsRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentProjectTermsRepository Class.
 */
class EloquentProjectTermsRepository extends EloquentRepositoryAbstract implements EloquentProjectTermsRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $projectId
     * @return $this
     */
    public function findWhereByProjectId(int $projectId)
    {
        $this->model = $this->model->where('project_id', $projectId);

        return $this;
    }

    /**
     * @param float $startValue
     * @param float $endValue
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeValue(float $startValue, float $endValue)
    {
        $this->model = $this->model->whereBetween('value', [$startValue, $endValue]);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
