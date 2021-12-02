<?php
namespace App\Infrastructures\NonFormalEducationHistory;

use App\Infrastructures\NonFormalEducationHistory\Contracts\EloquentNonFormalEducationHistoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentNonFormalEducationHistoryRepository Class.
 */
class EloquentNonFormalEducationHistoryRepository extends EloquentRepositoryAbstract implements EloquentNonFormalEducationHistoryRepositoryInterface
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
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'type' => '%' . $searchQuery . '%',
            'institution' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR type LIKE ?
            OR institution LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
