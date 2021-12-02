<?php

namespace App\Domains\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\Contracts\PayrollRepositoryInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use App\Infrastructures\HumanResources\Payroll\Contracts\EloquentPayrollRepositoryInterface;
use Closure;

/**
 * Class PayrollRepository.
 */
class PayrollRepository extends RepositoryAbstract implements PayrollRepositoryInterface
{
    /**
     * PayrollRepository constructor.
     *
     * @param EloquentPayrollRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(PayrollInterface $Payroll)
    {
        return [
            'employee_id' => $Payroll->getEmployeeId(),
            'payroll_batch_id' => $Payroll->getPayrollBatchId(),
            'pay_period' => $Payroll->getPayPeriod(),
            'process_date' => $Payroll->getProcessDate(),
            'payroll_process_type_id' => $Payroll->getPayrollProcessTypeId(),
            'description' => $Payroll->getDescription(),
            'created_by' => $Payroll->getCreatedBy(),
            'modified_by' => $Payroll->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollInterface $Payroll)
    {
        $data = $this->setupPayload($Payroll);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollInterface $Payroll)
    {
        $data = $this->setupPayload($Payroll);
       
        return $this->eloquent()->update($data, $Payroll->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollInterface $Payroll)
    {
        return $this->eloquent()->delete($Payroll->getKey());
    }
}
