<?php

namespace App\Domains\Commons\Application\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Application\Contracts\EloquentApplicationRepositoryInterface;
use Closure;

/**
 * Interface ApplicationRepositoryInterface.
 */
interface ApplicationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicationRepositoryInterface constructor.
     *
     * @param EloquentApplicationRepositoryInterface $eloquent
     */
    public function __construct(EloquentApplicationRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function create(ApplicationInterface $Application);

    /**
     * Update Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function update(ApplicationInterface $Application);

    /**
     * Delete Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function delete(ApplicationInterface $Application);

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
    public function applicationList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function applicationListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function applicationPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
