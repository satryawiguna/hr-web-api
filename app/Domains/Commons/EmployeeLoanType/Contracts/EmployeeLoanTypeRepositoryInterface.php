<?php

namespace App\Domains\Commons\EmployeeLoanType\Contracts;

use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\EmployeeLoanType\Contracts\EloquentEmployeeLoanTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface EmployeeLoanTypeRepositoryInterface.
 */
interface EmployeeLoanTypeRepositoryInterface
{
    /**
     * EmployeeLoanTypeRepositoryInterface constructor.
     *
     * @param EloquentEmployeeLoanTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeLoanTypeRepositoryInterface $eloquent);

    /**
     * Create EmployeeLoanType.
     *
     * @param EmployeeLoanTypeInterface $EmployeeLoanType
     *
     * @return mixed
     */
    public function create(EmployeeLoanTypeInterface $EmployeeLoanType);

    /**
     * Update EmployeeLoanType.
     *
     * @param EmployeeLoanTypeInterface $EmployeeLoanType
     *
     * @return mixed
     */
    public function update(EmployeeLoanTypeInterface $EmployeeLoanType);

    /**
     * Delete EmployeeLoanType.
     *
     * @param EmployeeLoanTypeInterface $EmployeeLoanType
     *
     * @return mixed
     */
    public function delete(EmployeeLoanTypeInterface $EmployeeLoanType);

    /**
     * Get EmployeeLoanType.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * Lists EmployeeLoanTypes.
     *
     * @return mixed
     */
    public function lists();
}
