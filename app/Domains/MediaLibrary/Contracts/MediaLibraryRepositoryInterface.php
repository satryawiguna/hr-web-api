<?php

namespace App\Domains\MediaLibrary\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface MediaLibraryRepositoryInterface.
 */
interface MediaLibraryRepositoryInterface
{
    /**
     * MediaLibraryRepositoryInterface constructor.
     *
     * @param EloquentMediaLibraryRepositoryInterface $eloquent
     */
    public function __construct(EloquentMediaLibraryRepositoryInterface $eloquent);

    /**
     * Create MediaLibrary.
     *
     * @param MediaLibraryInterface $MediaLibrary
     *
     * @return mixed
     */
    public function create(MediaLibraryInterface $MediaLibrary);

    /**
     * Update MediaLibrary.
     *
     * @param MediaLibraryInterface $MediaLibrary
     *
     * @return mixed
     */
    public function update(MediaLibraryInterface $MediaLibrary);

    /**
     * Delete MediaLibrary.
     *
     * @param MediaLibraryInterface $MediaLibrary
     *
     * @param array|null $relations
     * @return mixed
     */
    public function delete(MediaLibraryInterface $MediaLibrary, array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $userIds
     * @param string|null $collection
     * @return mixed
     */
    public function mediaLibraryList(array $userIds, string $collection = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param array $userIds
     * @param string|null $collection
     * @param bool $count
     * @return mixed
     */
    public function mediaLibraryListSearch(ListedSearchParameter $parameter, array $userIds, string $collection = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param array $userIds
     * @param string|null $collection
     * @param bool $count
     * @return mixed
     */
    public function mediaLibraryPageSearch(PagedSearchParameter $parameter, array $userIds, string $collection = null, bool $count = false);
}
