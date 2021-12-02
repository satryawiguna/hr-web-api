<?php
namespace App\Infrastructures\HumanResources\Termination;

use App\Infrastructures\HumanResources\Termination\Contracts\EloquentTerminationRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentTerminationRepository Class.
 */
class EloquentTerminationRepository extends EloquentRepositoryAbstract implements EloquentTerminationRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $employeeId
     * @return $this|mixed
     */
    public function findWhereByEmployeeId(int $employeeId)
    {
        $this->model = $this->model->where('employee_id', $employeeId);

        return $this;
    }

    /**
     * @param string $type
     * @return $this|mixed
     */
    public function findWhereByType(string $type)
    {
        $this->model = $this->model->where('type', $type);

        return $this;
    }

    /**
     * @param DateTime $startTerminationDate
     * @param DateTime $endTerminationDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeTerminationDate(DateTime $startTerminationDate, DateTime $endTerminationDate)
    {
        $this->model = $this->model->whereBetween('termination_date', [
            $startTerminationDate->format(Config::get('datetime.format.default')),
            $endTerminationDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param float $startSeverance
     * @param float $endSeverance
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeSeverance(float $startSeverance, float $endSeverance)
    {
        $this->model = $this->model->whereBetween('severance', [
            $startSeverance,
            $endSeverance
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
            'note' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(note LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
