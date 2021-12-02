<?php
namespace App\Infrastructures\HumanResources\Element\ElementEntryValue;

use App\Infrastructures\HumanResources\Element\ElementEntryValue\Contracts\EloquentElementEntryValueRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentElementEntryValueRepository Class.
 */
class EloquentElementEntryValueRepository extends EloquentRepositoryAbstract implements EloquentElementEntryValueRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $elementEntryId
     * @return $this|mixed
     */
    public function findWhereByElementEntryId(int $elementEntryId)
    {
        $this->model = $this->model->where('element_entry_id', $elementEntryId);

        return $this;
    }

    /**
     * @param int $elementValueId
     * @return $this
     */
    public function findWhereByElementValueId(int $elementValueId)
    {
        $this->model = $this->model->where('element_value_id', $elementValueId);

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this|mixed
     */
    public function findWhereEffectiveDateByDate(DateTime $date)
    {
        $this->model = $this->model->whereDate([
            ['effective_start_date', '<=', $date->format(Config::get('datetime.format.default'))],
            ['effective_end_date', '>=', $date->format(Config::get('datetime.format.default'))]
        ]);

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
        return $this;
    }

    //</editor-fold>
}
