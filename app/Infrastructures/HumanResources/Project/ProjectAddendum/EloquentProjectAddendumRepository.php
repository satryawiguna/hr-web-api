<?php
namespace App\Infrastructures\HumanResources\Project\ProjectAddendum;

use App\Infrastructures\HumanResources\Project\ProjectAddendum\Contracts\EloquentProjectAddendumRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentProjectAddendumRepository Class.
 */
class EloquentProjectAddendumRepository extends EloquentRepositoryAbstract implements EloquentProjectAddendumRepositoryInterface
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
     * @param DateTime $date
     * @return $this|mixed
     */
    public function findWhereDateByDate(DateTime $date)
    {
        $this->model = $this->model
            ->whereDate('start_date', '<=', $date->format(Config::get('datetime.format.default')))
            ->whereDate('end_date', '>=', $date->format(Config::get('datetime.format.default')));

        return $this;
    }

    /**
     * @param DateTime $startIssueDate
     * @param DateTime $endIssueDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeIssueDate(DateTime $startIssueDate, DateTime $endIssueDate)
    {
        $this->model = $this->model->whereBetween('issue_date', [
            $startIssueDate->format(Config::get('datetime.format.default')),
            $endIssueDate->format(Config::get('datetime.format.default'))
        ]);

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
            'reference_number' => '%' . $searchQuery . '%',
            'name' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(reference_number LIKE ?
            OR name LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
