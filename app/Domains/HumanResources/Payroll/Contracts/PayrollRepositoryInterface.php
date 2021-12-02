<?php
namespace App\Domains\HumanResources\Payroll\Contracts;


use App\Infrastructures\HumanResources\Payroll\Contracts\EloquentPayrollRepositoryInterface;

/**
 * Interface PayrollRepositoryInterface.
 */
interface PayrollRepositoryInterface
{
    /**
     * PayrollRepositoryInterface constructor.
     *
     * @param EloquentPayrollRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollRepositoryInterface $eloquent);

    /**
     * Create Payroll.
     *
     * @param PayrollInterface $Payroll
     *
     * @return mixed
     */
    public function create(PayrollInterface $Payroll);

    /**
     * Update Payroll.
     *
     * @param PayrollInterface $Payroll
     *
     * @return mixed
     */
    public function update(PayrollInterface $Payroll);

    /**
     * Delete Payroll.
     *
     * @param PayrollInterface $Payroll
     *
     * @return mixed
     */
    public function delete(PayrollInterface $Payroll);
}
