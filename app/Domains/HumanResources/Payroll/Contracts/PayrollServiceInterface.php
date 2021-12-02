<?php

namespace App\Domains\HumanResources\Payroll\Contracts;

/**
 * Interface PayrollServiceInterface.
 */
interface PayrollServiceInterface
{
    /**
     * PayrollServiceInterface constructor.
     *
     * @param PayrollRepositoryInterface $repository
     */
    public function __construct(PayrollRepositoryInterface $repository);

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

    /**
     * Get Payroll.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * Lists Payrolls.
     *
     * @return mixed
     */
    public function lists();
}
