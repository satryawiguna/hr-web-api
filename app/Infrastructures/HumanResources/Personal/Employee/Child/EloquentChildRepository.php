<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\Child;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Infrastructures\HumanResources\Personal\Employee\Child\Contracts\EloquentChildRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentChildRepository Class.
 */
class EloquentChildRepository extends EloquentRepositoryAbstract implements EloquentChildRepositoryInterface
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
     * @param int $genderId
     * @return $this|mixed
     */
    public function findWhereByGenderId(int $genderId)
    {
        $this->model = $this->model->where('gender_id', $genderId);

        return $this;
    }

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, DateTime $endBirthDate)
    {
        $this->model = $this->model->whereBetween('birth_date', [
            $startBirthDate->format(Config::get('datetime.format.default')),
            $endBirthDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    public function findWhereBetweenByRangeBPJSKesehatanDate(DateTime $startBPJSKesehatanhDate, DateTime $endBPJSKesehatanhDate)
    {
        $this->model = $this->model->whereBetween('bpjs_kesehatan_date', [
            $startBPJSKesehatanhDate->format(Config::get('datetime.format.default')),
            $endBPJSKesehatanhDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $bpjsKesehatanClass
     * @return $this|mixed
     */
    public function findWhereByBPJSKesehatanClass(string $bpjsKesehatanClass)
    {
        $this->model = $this->model->where('bpjs_kesehatan_class', $bpjsKesehatanClass);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'full_name' => '%' . $searchQuery . '%',
            'nick_name' => '%' . $searchQuery . '%',
            'birth_place' => '%' . $searchQuery . '%',
            'bpjs_kesehatan_number' => '%' . $searchQuery . '%',
            'bpjs_kesehatan_class' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(full_name LIKE ?
            OR nick_name LIKE ?
            OR birth_place LIKE ?
            OR bpjs_kesehatan_number LIKE ?
            OR bpjs_kesehatan_class LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
