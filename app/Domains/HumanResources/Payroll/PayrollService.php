<?php

namespace App\Domains\HumanResources\Payroll;

use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Payroll\Contracts\PayrollRepositoryInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollServiceInterface;
use App\Domains\HumanResources\Payroll\Contracts\PayrollInterface;

/**
 * PayrollService Class
 * It has all useful methods for business logic.
 */
class PayrollService extends ServiceAbstract implements PayrollServiceInterface
{
    /**
     * @var PayrollRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our PayrollInterface
     * PayrollService constructor.
     *
     * @param PayrollRepositoryInterface $repository
     */
    public function __construct(PayrollRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(PayrollInterface $Payroll)
    {
        return $this->repository->create($Payroll);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollInterface $Payroll)
    {
        return $this->repository->update($Payroll);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollInterface $Payroll)
    {
        return $this->repository->delete($Payroll);
    }
}
