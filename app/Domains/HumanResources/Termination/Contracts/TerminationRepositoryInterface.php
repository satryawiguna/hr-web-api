<?php

namespace App\Domains\HumanResources\Termination\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Termination\Contracts\EloquentTerminationRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface TerminationRepositoryInterface.
 */
interface TerminationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * TerminationRepositoryInterface constructor.
     *
     * @param EloquentTerminationRepositoryInterface $eloquent
     */
    public function __construct(EloquentTerminationRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function create(TerminationInterface $Termination);

    /**
     * Update Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function update(TerminationInterface $Termination);

    /**
     * Delete Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function delete(TerminationInterface $Termination);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return mixed
     */
    public function terminationList(int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param bool $count
     * @return mixed
     */
    public function terminationListSearch(ListedSearchParameter $parameter, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param bool $count
     * @return mixed
     */
    public function terminationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null, bool $count = false);

    //</editor-fold>
}
