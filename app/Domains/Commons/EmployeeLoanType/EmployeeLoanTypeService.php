<?php

namespace App\Domains\Commons\EmployeeLoanType;

use App\Domains\ServiceAbstract;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeRepositoryInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeServiceInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeInterface;

/**
 * EmployeeLoanTypeService Class
 * It has all useful methods for business logic.
 */
class EmployeeLoanTypeService extends ServiceAbstract implements EmployeeLoanTypeServiceInterface
{
    /**
     * @var EmployeeLoanTypeRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our EmployeeLoanTypeInterface
     * EmployeeLoanTypeService constructor.
     *
     * @param EmployeeLoanTypeRepositoryInterface $repository
     */
    public function __construct(EmployeeLoanTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        return $this->repository->create($EmployeeLoanType);
    }

    /**
     * {@inheritdoc}
     */
    public function update(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        return $this->repository->update($EmployeeLoanType);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        return $this->repository->delete($EmployeeLoanType);
    }
}
