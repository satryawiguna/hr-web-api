<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface WorkExperienceServiceInterface.
 */
interface WorkExperienceServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkExperienceServiceInterface constructor.
     *
     * @param WorkExperienceRepositoryInterface $repository
     */
    public function __construct(WorkExperienceRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @return mixed
     */
    public function create(WorkExperienceInterface $WorkExperience);

    /**
     * @param Collection $WorkExperiences
     * @return mixed
     */
    public function insert(Collection $WorkExperiences);

    /**
     * Update WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @param array $params
     * @return mixed
     */
    public function update(WorkExperienceInterface $WorkExperience, array $params = []);

    /**
     * Delete WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @return mixed
     */
    public function delete(WorkExperienceInterface $WorkExperience);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function workExperienceList(int $companyId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function workExperienceListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function workExperiencePageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
