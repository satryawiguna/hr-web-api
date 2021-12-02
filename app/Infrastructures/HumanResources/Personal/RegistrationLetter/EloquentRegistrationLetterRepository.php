<?php
namespace App\Infrastructures\RegistrationLetter;

use App\Infrastructures\RegistrationLetter\Contracts\EloquentRegistrationLetterRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentRegistrationLetterRepository Class.
 */
class EloquentRegistrationLetterRepository extends EloquentRepositoryAbstract implements EloquentRegistrationLetterRepositoryInterface
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
     * @param int $letterTypeId
     * @return $this|mixed
     */
    public function findWhereByLetterTypeId(int $letterTypeId)
    {
        $this->model = $this->model->where('letter_type_id', $letterTypeId);

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this|mixed
     */
    public function findWhereDateByDate(DateTime $date)
    {
        $this->model = $this->model->whereDate([
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
            'reference_number' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(reference_number LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
