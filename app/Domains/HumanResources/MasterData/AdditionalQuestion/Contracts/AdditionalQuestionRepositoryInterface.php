<?php

namespace App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\AdditionalQuestion\Contracts\EloquentAdditionalQuestionRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface AdditionalQuestionRepositoryInterface.
 */
interface AdditionalQuestionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * AdditionalQuestionRepositoryInterface constructor.
     *
     * @param EloquentAdditionalQuestionRepositoryInterface $eloquent
     */
    public function __construct(EloquentAdditionalQuestionRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function create(AdditionalQuestionInterface $AdditionalQuestion);

    /**
     * Update AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function update(AdditionalQuestionInterface $AdditionalQuestion);

    /**
     * Delete AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function delete(AdditionalQuestionInterface $AdditionalQuestion);

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
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @return mixed
     */
    public function additionalQuestionList(int $companyId = null, int $isRequired = null, string $status = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param bool $count
     * @return mixed
     */
    public function additionalQuestionListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isRequired = null, string $status = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param bool $count
     * @return mixed
     */
    public function additionalQuestionPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isRequired = null, string $status = null, bool $count = false);

    //</editor-fold>
}
