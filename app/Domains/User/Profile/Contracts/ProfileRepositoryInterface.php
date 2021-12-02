<?php

namespace App\Domains\User\Profile\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\User\Profile\Contracts\EloquentProfileRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ProfileRepositoryInterface.
 */
interface ProfileRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProfileRepositoryInterface constructor.
     *
     * @param EloquentProfileRepositoryInterface $eloquent
     */
    public function __construct(EloquentProfileRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Profile.
     *
     * @param ProfileInterface $Profile
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(ProfileInterface $Profile, array $relations = null);

    /**
     * Update Profile.
     *
     * @param ProfileInterface $Profile
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(ProfileInterface $Profile, array $relations = null);

    /**
     * Delete Profile.
     *
     * @param ProfileInterface $Profile
     *
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete(ProfileInterface $Profile, bool $isPermanentDelete = false, array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);


    //</editor-fold>
}
