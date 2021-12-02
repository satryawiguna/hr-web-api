<?php
namespace App\Infrastructures\HumanResources\Mutation\ProjectMutation;

use App\Infrastructures\HumanResources\Mutation\ProjectMutation\Contracts\EloquentProjectMutationRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentProjectMutationRepository Class.
 */
class EloquentProjectMutationRepository extends EloquentRepositoryAbstract implements EloquentProjectMutationRepositoryInterface
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
     * @param int $projectId
     * @return $this|mixed
     */
    public function findWhereByProjectId(int $projectId)
    {
        $this->model = $this->model->where('project_id', $projectId);

        return $this;
    }

    /**
     * @param DateTime $startMutationDate
     * @param DateTime $endMutationDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeMutationDate(DateTime $startMutationDate, DateTime $endMutationDate)
    {
        $this->model = $this->model->whereBetween('mutation_date', [
            $startMutationDate->format(Config::get('datetime.format.default')),
            $endMutationDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
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
