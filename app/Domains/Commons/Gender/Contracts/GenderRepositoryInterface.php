<?php

namespace App\Domains\Commons\Gender\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Gender\Contracts\EloquentGenderRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface GenderRepositoryInterface.
 */
interface GenderRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GenderRepositoryInterface constructor.
     *
     * @param EloquentGenderRepositoryInterface $eloquent
     */
    public function __construct(EloquentGenderRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function create(GenderInterface $Gender);

    /**
     * Update Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function update(GenderInterface $Gender);

    /**
     * Delete Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function delete(GenderInterface $Gender);

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
    public function genderList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function genderListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function genderPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
