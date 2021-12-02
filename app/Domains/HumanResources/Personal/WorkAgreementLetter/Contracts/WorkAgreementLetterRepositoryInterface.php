<?php

namespace App\Domains\WorkAgreementLetter\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\WorkAgreementLetter\Contracts\EloquentWorkAgreementLetterRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;

/**
 * Interface WorkAgreementLetterRepositoryInterface.
 */
interface WorkAgreementLetterRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAgreementLetterRepositoryInterface constructor.
     *
     * @param EloquentWorkAgreementLetterRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkAgreementLetterRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkAgreementLetter.
     *
     * @param WorkAgreementLetterInterface $WorkAgreementLetter
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(WorkAgreementLetterInterface $WorkAgreementLetter, array $relations = null);

    /**
     * Update WorkAgreementLetter.
     *
     * @param WorkAgreementLetterInterface $WorkAgreementLetter
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(WorkAgreementLetterInterface $WorkAgreementLetter, array $relations = null);

    /**
     * Delete WorkAgreementLetter.
     *
     * @param WorkAgreementLetterInterface $WorkAgreementLetter
     *
     * @return mixed
     */
    public function delete(WorkAgreementLetterInterface $WorkAgreementLetter);

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
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function workAgreementLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workAgreementLetterListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workAgreementLetterPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
