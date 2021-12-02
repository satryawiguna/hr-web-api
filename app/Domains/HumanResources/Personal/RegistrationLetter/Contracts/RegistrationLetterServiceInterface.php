<?php

namespace App\Domains\RegistrationLetter\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\CreateRegistrationLetterRequest;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\EditRegistrationLetterRequest;
use DateTime;

/**
 * Interface RegistrationLetterServiceInterface.
 */
interface RegistrationLetterServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RegistrationLetterServiceInterface constructor.
     *
     * @param RegistrationLetterRepositoryInterface $repository
     */
    public function __construct(RegistrationLetterRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create RegistrationLetter.
     *
     * @param CreateRegistrationLetterRequest $request
     * @return mixed
     */
    public function create(CreateRegistrationLetterRequest $request): ObjectResponse;

    /**
     * Update RegistrationLetter.
     *
     * @param EditRegistrationLetterRequest $request
     * @return mixed
     */
    public function update(EditRegistrationLetterRequest $request): ObjectResponse;

    /**
     * Delete RegistrationLetter.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function registrationLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function registrationLetterListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function registrationLetterPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
