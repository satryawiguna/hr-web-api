<?php

namespace App\Domains\Commons\Major\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Major\Contracts\EloquentMajorRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface MajorRepositoryInterface.
 */
interface MajorRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MajorRepositoryInterface constructor.
     *
     * @param EloquentMajorRepositoryInterface $eloquent
     */
    public function __construct(EloquentMajorRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function create(MajorInterface $Major);

    /**
     * Update Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function update(MajorInterface $Major);

    /**
     * Delete Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function delete(MajorInterface $Major);

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
    public function majorList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function majorListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function majorPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
