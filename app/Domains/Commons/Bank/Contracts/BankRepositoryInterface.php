<?php

namespace App\Domains\Commons\Bank\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Bank\Contracts\EloquentBankRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface BankRepositoryInterface.
 */
interface BankRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BankRepositoryInterface constructor.
     *
     * @param EloquentBankRepositoryInterface $eloquent
     */
    public function __construct(EloquentBankRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function create(BankInterface $Bank);

    /**
     * Update Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function update(BankInterface $Bank);

    /**
     * Delete Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function delete(BankInterface $Bank);

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
     * @param int|null $isActive
     * @return mixed
     */
    public function bankList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function bankListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function bankPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
