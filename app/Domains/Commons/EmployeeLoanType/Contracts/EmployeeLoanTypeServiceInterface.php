<?php

namespace App\Domains\Commons\EmployeeLoanType\Contracts;

/**
 * Interface EmployeeLoanTypeServiceInterface.
 */
interface EmployeeLoanTypeServiceInterface
{
    /**
     * EmployeeLoanTypeServiceInterface constructor.
     *
     * @param EmployeeLoanTypeRepositoryInterface $repository
     */
    public function __construct(EmployeeLoanTypeRepositoryInterface $repository);

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
