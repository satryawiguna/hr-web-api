<?php
namespace App\Infrastructures\HumanResources\Mutation\WorkUnitMutation;

use App\Infrastructures\HumanResources\Mutation\WorkUnitMutation\Contracts\EloquentWorkUnitMutationRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentWorkUnitMutationRepository Class.
 */
class EloquentWorkUnitMutationRepository extends EloquentRepositoryAbstract implements EloquentWorkUnitMutationRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->whereIn('employee_id', function($query) use($companyId) {
            return $query->select('id')
                ->from('employees')
                ->where('company_id', '=', $companyId);
        });

        return $this;
    }

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
     * @param int $workUnitId
     * @return $this|mixed
     */
    public function findWhereByWorkUnitId(int $workUnitId)
    {
        $this->model = $this->model->where('work_unit_id', $workUnitId);

        return $this;
    }

    /**
     * @param DateTime $startMutationDate
     * @param DateTime $endMutationDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeMutationDate(DateTime $startMutationDate, DateTime $endMutationDate)
    {
        $this->model = $this->model->where("mutation_date", ">=", $startMutationDate->format(Config::get('datetime.format.default')))
            ->where("mutation_date", "<=", $endMutationDate->format(Config::get('datetime.format.default')));

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'note' => '%' . $searchQuery . '%',
        ];

        $this->model = $this->model->whereRaw('(note LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
