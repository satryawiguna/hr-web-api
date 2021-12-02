<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence;

use App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence\Contracts\EloquentWorkCompetenceRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentWorkCompetenceRepository Class.
 */
class EloquentWorkCompetenceRepository extends EloquentRepositoryAbstract implements EloquentWorkCompetenceRepositoryInterface
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
     * @param int $competenceId
     * @return $this|mixed
     */
    public function findWhereByCompetenceId(int $competenceId)
    {
        $this->model = $this->model->where('competence_id', $competenceId);

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
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'reference_number' => '%' . $searchQuery . '%',
            'validity' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(reference_number LIKE ?
            OR validity LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
