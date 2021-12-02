<?php

namespace App\Domains\Commons\Access\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Access\Contracts\EloquentAccessRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface AccessRepositoryInterface.
 */
interface AccessRepositoryInterface
{
    /**
     * AccessRepositoryInterface constructor.
     *
     * @param EloquentAccessRepositoryInterface $eloquent
     */
    public function __construct(EloquentAccessRepositoryInterface $eloquent);

    /**
     * Create Access.
     *
     * @param AccessInterface $Access
     *
     * @return mixed
     */
    public function create(AccessInterface $Access);

    /**
     * Update Access.
     *
     * @param AccessInterface $Access
     *
     * @return mixed
     */
    public function update(AccessInterface $Access);

    /**
     * Delete Access.
     *
     * @param AccessInterface $Access
     *
     * @return mixed
     */
    public function delete(AccessInterface $Access);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function accessList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function accessListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function accessPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);
}
