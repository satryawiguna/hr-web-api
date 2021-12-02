<?php
namespace App\Infrastructures\HumanResources\Mutation\PositionMutation;

use App\Infrastructures\HumanResources\Mutation\PositionMutation\Contracts\EloquentPositionMutationRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentPositionMutationRepository Class.
 */
class EloquentPositionMutationRepository extends EloquentRepositoryAbstract implements EloquentPositionMutationRepositoryInterface
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
     * @param int $positionId
     * @return $this|mixed
     */
    public function findWhereByPositionId(int $positionId)
    {
        $this->model = $this->model->where('position_id', $positionId);

        return $this;
    }

    /**
     * @param int $gradeId
     * @return $this|mixed
     */
    public function findWhereByGradeId(int $gradeId)
    {
        $this->model = $this->model->where('grade_id', $gradeId);

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
        $searchParameter = [
            'note' => '%' . $searchQuery . '%',
        ];

        $this->model = $this->model->whereRaw('(note LIKE ?)', $searchParameter);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQueryEmployee(string $searchQuery)
    {
        $this->model = $this->model->whereHas('employee', function($query) use ($searchQuery) {
            return $query
                ->where('full_name', 'like', "%".$searchQuery."%")
                ->orWhere('nip', 'like', "%".$searchQuery."%");
        });

        return $this;
    }

    //</editor-fold>
}
