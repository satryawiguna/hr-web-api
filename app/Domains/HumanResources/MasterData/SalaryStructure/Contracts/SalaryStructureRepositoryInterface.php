<?php

namespace App\Domains\HumanResources\MasterData\SalaryStructure\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\SalaryStructure\Contracts\EloquentSalaryStructureRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface SalaryStructureRepositoryInterface.
 */
interface SalaryStructureRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SalaryStructureRepositoryInterface constructor.
     *
     * @param EloquentSalaryStructureRepositoryInterface $eloquent
     */
    public function __construct(EloquentSalaryStructureRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function create(SalaryStructureInterface $SalaryStructure);

    /**
     * Update SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function update(SalaryStructureInterface $SalaryStructure);

    /**
     * Delete SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function delete(SalaryStructureInterface $SalaryStructure);

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
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @return mixed
     */
    public function salaryStructureList(int $companyId = null, string $type = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function salaryStructureListSearch(ListedSearchParameter $parameter, int $companyId = null, string $type = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function salaryStructurePageSearch(PagedSearchParameter $parameter, int $companyId = null, string $type = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
