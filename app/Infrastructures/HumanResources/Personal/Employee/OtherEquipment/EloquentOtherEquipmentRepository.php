<?php
namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\EloquentOtherEquipmentRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentOtherEquipmentRepository Class.
 */
class EloquentOtherEquipmentRepository extends EloquentRepositoryAbstract implements EloquentOtherEquipmentRepositoryInterface
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
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }


    //</editor-fold>
}
