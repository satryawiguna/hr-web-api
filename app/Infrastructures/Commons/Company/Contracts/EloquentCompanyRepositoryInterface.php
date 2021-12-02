<?php

namespace App\Infrastructures\Commons\Company\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentCompanyRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $fields
     * @return mixed
     */
    public function select(string $fields);

    /**
     * @param string $table
     * @param string $foreignKeyField
     * @param string $conditional
     * @param string $keyField
     * @param string|null $type
     * @return mixed
     */
    public function join(string $table, string $foreignKeyField, string $conditional, string $keyField, string $type = null);

    /**
     * @param int $companyCategoryId
     * @return mixed
     */
    public function findWhereByCompanyCategoryId(int $companyCategoryId);

    /**
     * @param int $employeeNumberScaleId
     * @return mixed
     */
    public function findWhereByEmployeeNumberScaleId(int $employeeNumberScaleId);

    /**
     * @param int $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param ListedSearchParameter $parameter
     * @param string|null $collection
     * @return mixed
     */
    public function withListSearchMediaLibraries(ListedSearchParameter $parameter, string $collection = null);

    /**
     * @param PagedSearchParameter $parameter
     * @param string|null $collection
     * @return mixed
     */
    public function withPageSearchMediaLibraries(PagedSearchParameter $parameter, string $collection = null);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);


    //</editor-fold>
}
