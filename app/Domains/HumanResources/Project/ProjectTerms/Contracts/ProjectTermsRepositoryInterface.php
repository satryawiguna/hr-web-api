<?php

namespace App\Domains\HumanResources\Project\ProjectTerms\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Project\ProjectTerms\Contracts\EloquentProjectTermsRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ProjectTermsRepositoryInterface.
 */
interface ProjectTermsRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectTermsRepositoryInterface constructor.
     *
     * @param EloquentProjectTermsRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectTermsRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ProjectTerms.
     *
     * @param ProjectTermsInterface $ProjectTerms
     *
     * @return mixed
     */
    public function create(ProjectTermsInterface $ProjectTerms);

    /**
     * Update ProjectTerms.
     *
     * @param ProjectTermsInterface $ProjectTerms
     *
     * @return mixed
     */
    public function update(ProjectTermsInterface $ProjectTerms);

    /**
     * Delete ProjectTerms.
     *
     * @param ProjectTermsInterface $ProjectTerms
     *
     * @return mixed
     */
    public function delete(ProjectTermsInterface $ProjectTerms);

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
     * @param int|null $projectId
     * @param null $rangeValue
     * @return mixed
     */
    public function projectTermsList(int $projectId = null, $rangeValue = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $projectId
     * @param null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectTermsListSearch(ListedSearchParameter $parameter, int $projectId = null, $rangeValue = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $projectId
     * @param null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectTermsPageSearch(PagedSearchParameter $parameter, int $projectId = null, $rangeValue = null, bool $count = false);

    //</editor-fold>
}
