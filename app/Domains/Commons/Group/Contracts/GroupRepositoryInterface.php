<?php

namespace App\Domains\Commons\Group\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Group\Contracts\EloquentGroupRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface GroupRepositoryInterface.
 */
interface GroupRepositoryInterface
{
    /**
     * GroupRepositoryInterface constructor.
     *
     * @param EloquentGroupRepositoryInterface $eloquent
     */
    public function __construct(EloquentGroupRepositoryInterface $eloquent);

    /**
     * Create Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function create(GroupInterface $Group);

    /**
     * Update Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function update(GroupInterface $Group);

    /**
     * Delete Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function delete(GroupInterface $Group);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function groupList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function groupListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function groupPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
