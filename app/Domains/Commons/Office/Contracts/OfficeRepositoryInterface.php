<?php

namespace App\Domains\Commons\Office\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Office\Contracts\EloquentOfficeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface OfficeRepositoryInterface.
 */
interface OfficeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OfficeRepositoryInterface constructor.
     *
     * @param EloquentOfficeRepositoryInterface $eloquent
     */
    public function __construct(EloquentOfficeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function create(OfficeInterface $Office);

    /**
     * Update Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function update(OfficeInterface $Office);

    /**
     * Delete Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function delete(OfficeInterface $Office);

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
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function officeList(int $companyId = null, string $type = null, string $country = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function officeListSearch(ListedSearchParameter $parameter, int $companyId = null, string $type = null, string $country = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function officePageSearch(PagedSearchParameter $parameter, int $companyId = null, string $type = null, string $country = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
