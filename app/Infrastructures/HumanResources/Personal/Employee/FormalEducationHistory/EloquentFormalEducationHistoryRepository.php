<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory;

use App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\EloquentFormalEducationHistoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentFormalEducationHistoryRepository Class.
 */
class EloquentFormalEducationHistoryRepository extends EloquentRepositoryAbstract implements EloquentFormalEducationHistoryRepositoryInterface
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
     * @param int $degreeId
     * @return $this
     */
    public function findWhereByDegreeId(int $degreeId)
    {
        $this->model = $this->model->where('degree_id', $degreeId);

        return $this;
    }

    /**
     * @param int $majorId
     * @return $this
     */
    public function findWhereByMajorId(int $majorId)
    {
        $this->model = $this->model->where('major_id', $majorId);

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this|mixed
     */
    public function findWhereDateByDate(DateTime $date)
    {
        $this->model = $this->model->where([
            ['start_date', '<=', $date->format(Config::get('datetime.format.default'))],
            ['end_date', '>=', $date->format(Config::get('datetime.format.default'))]
        ]);

        return $this;
    }

    /**
     * @param $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
