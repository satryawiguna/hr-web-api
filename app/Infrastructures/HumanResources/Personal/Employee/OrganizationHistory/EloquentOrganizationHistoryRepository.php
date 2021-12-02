<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory;

use App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory\Contracts\EloquentOrganizationHistoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentOrganizationHistoryRepository Class.
 */
class EloquentOrganizationHistoryRepository extends EloquentRepositoryAbstract implements EloquentOrganizationHistoryRepositoryInterface
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
            'activity' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR activity LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
