<?php

namespace App\Domains\Commons\ContractType\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\ContractType\Contracts\EloquentContractTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ContractTypeRepositoryInterface.
 */
interface ContractTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ContractTypeRepositoryInterface constructor.
     *
     * @param EloquentContractTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentContractTypeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function create(ContractTypeInterface $ContractType);

    /**
     * Update ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function update(ContractTypeInterface $ContractType);

    /**
     * Delete ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function delete(ContractTypeInterface $ContractType);

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
    public function contractTypeList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function contractTypeListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function contractTypePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
