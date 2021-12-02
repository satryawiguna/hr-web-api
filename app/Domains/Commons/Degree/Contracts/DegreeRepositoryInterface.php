<?php

namespace App\Domains\Commons\Degree\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Degree\Contracts\EloquentDegreeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface DegreeRepositoryInterface.
 */
interface DegreeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * DegreeRepositoryInterface constructor.
     *
     * @param EloquentDegreeRepositoryInterface $eloquent
     */
    public function __construct(EloquentDegreeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function create(DegreeInterface $Degree);

    /**
     * Update Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function update(DegreeInterface $Degree);

    /**
     * Delete Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function delete(DegreeInterface $Degree);

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
     * @param null $isActive
     * @return mixed
     */
    public function degreeList($isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param null $isActive
     * @param bool $count
     * @return mixed
     */
    public function degreeListSearch(ListedSearchParameter $parameter, $isActive = null, $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param null $isActive
     * @param bool $count
     * @return mixed
     */
    public function degreePageSearch(PagedSearchParameter $parameter, $isActive = null, $count = false);

    //</editor-fold>
}
