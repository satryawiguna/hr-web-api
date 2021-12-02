<?php
namespace App\Infrastructures\HumanResources\Element\ElementEntry;

use App\Infrastructures\HumanResources\Element\ElementEntry\Contracts\EloquentElementEntryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentElementEntryRepository Class.
 */
class EloquentElementEntryRepository extends EloquentRepositoryAbstract implements EloquentElementEntryRepositoryInterface
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
     * @param int $employeeId
     * @return $this
     */
    public function findWhereByEmployeeId(int $employeeId)
    {
        $this->model = $this->model->where('employee_id', $employeeId);

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
