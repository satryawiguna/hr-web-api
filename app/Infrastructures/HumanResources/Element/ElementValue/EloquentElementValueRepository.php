<?php
namespace App\Infrastructures\HumanResources\Element\ElementValue;

use App\Infrastructures\HumanResources\Element\ElementValue\Contracts\EloquentElementValueRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentElementValueRepository Class.
 */
class EloquentElementValueRepository extends EloquentRepositoryAbstract implements EloquentElementValueRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $elementId
     * @return $this|mixed
     */
    public function findWhereByElementId(int $elementId)
    {
        $this->model = $this->model->where('element_id', $elementId);

        return $this;
    }

    /**
     * @param float $startValue
     * @param float $endValue
     * @return mixed|void
     */
    public function findWhereBetweenByRangeValue(float $startValue, float $endValue)
    {
        $this->model = $this->model->whereBetween('value', [
            $startValue,
            $endValue
        ]);
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
