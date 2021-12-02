<?php

namespace App\Domains\Commons\Religion\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Religion\Contracts\EloquentReligionRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ReligionRepositoryInterface.
 */
interface ReligionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ReligionRepositoryInterface constructor.
     *
     * @param EloquentReligionRepositoryInterface $eloquent
     */
    public function __construct(EloquentReligionRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function create(ReligionInterface $Religion);

    /**
     * Update Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function update(ReligionInterface $Religion);

    /**
     * Delete Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function delete(ReligionInterface $Religion);

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
    public function religionList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function religionListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function religionPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
