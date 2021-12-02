<?php

namespace App\Domains\HumanResources\MasterData\Grade\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface GradeServiceInterface.
 */
interface GradeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GradeServiceInterface constructor.
     *
     * @param GradeRepositoryInterface $repository
     */
    public function __construct(GradeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function create(GradeInterface $Grade);

    /**
     * Update Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function update(GradeInterface $Grade);

    /**
     * Delete Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function delete(GradeInterface $Grade);

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
     * @param int|null $isActive
     * @return mixed
     */
    public function gradeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function gradeListSearch(ListSearchRequest $request, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function gradePageSearch(PageSearchRequest $request, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param GradeInterface $Grade
     * @return mixed
     */
    public function gradeSetActive(GradeInterface $Grade): BasicResponse;

    /**
     * @param GradeInterface $Grade
     * @return ObjectResponse
     */
    public function gradeSlug(GradeInterface $Grade): ObjectResponse;

    //</editor-fold>
}
