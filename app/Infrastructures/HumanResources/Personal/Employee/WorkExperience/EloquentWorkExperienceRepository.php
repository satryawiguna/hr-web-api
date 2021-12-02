<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\WorkExperience;

use App\Infrastructures\HumanResources\Personal\Employee\WorkExperience\Contracts\EloquentWorkExperienceRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentWorkExperienceRepository Class.
 */
class EloquentWorkExperienceRepository extends EloquentRepositoryAbstract implements EloquentWorkExperienceRepositoryInterface
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
            'company' => '%' . $searchQuery . '%',
            'business_type' => '%' . $searchQuery . '%',
            'position' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(company LIKE ?
            OR business_type LIKE ?
            OR position LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
