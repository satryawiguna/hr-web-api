<?php

namespace App\Domains\RegistrationLetter\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\RegistrationLetter\Contracts\EloquentRegistrationLetterRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;

/**
 * Interface RegistrationLetterRepositoryInterface.
 */
interface RegistrationLetterRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RegistrationLetterRepositoryInterface constructor.
     *
     * @param EloquentRegistrationLetterRepositoryInterface $eloquent
     */
    public function __construct(EloquentRegistrationLetterRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create RegistrationLetter.
     *
     * @param RegistrationLetterInterface $RegistrationLetter
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(RegistrationLetterInterface $RegistrationLetter, array $relations = null);

    /**
     * Update RegistrationLetter.
     *
     * @param RegistrationLetterInterface $RegistrationLetter
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(RegistrationLetterInterface $RegistrationLetter, array $relations = null);

    /**
     * Delete RegistrationLetter.
     *
     * @param RegistrationLetterInterface $RegistrationLetter
     *
     * @return mixed
     */
    public function delete(RegistrationLetterInterface $RegistrationLetter);

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
    public function registrationLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function registrationLetterListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function registrationLetterPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
