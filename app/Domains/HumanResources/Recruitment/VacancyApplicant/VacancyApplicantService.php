<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantRepositoryInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantServiceInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantInterface;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * VacancyApplicantService Class
 * It has all useful methods for business logic.
 */
class VacancyApplicantService extends ServiceAbstract implements VacancyApplicantServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var VacancyApplicantRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our VacancyApplicantInterface
     * VacancyApplicantService constructor.
     *
     * @param VacancyApplicantRepositoryInterface $repository
     */
    public function __construct(VacancyApplicantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(VacancyApplicantInterface $VacancyApplicant): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($VacancyApplicant->toArray(), [
            'applicant_id'          => 'required',
            'vacancy_id'            => 'required',
            'recruitment_stage_id'  => 'required',
            'cover_letter'          => 'required',
            'rating'                => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->create($VacancyApplicant);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy applicant was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function updateStatus(VacancyApplicantInterface $VacancyApplicant): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($VacancyApplicant->toArray(), [
            'recruitment_stage_id'  => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->update($VacancyApplicant);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy applicant was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function jobOnBoard(VacancyApplicantInterface $VacancyApplicant): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy applicant was accepted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function note(VacancyApplicantInterface $VacancyApplicant): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy applicant was rejected', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return GenericCollectionResponse
     */
    public function vacancyApplicantList(int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->vacancyApplicantList($applicantId, $vacancyId, $recruitmentStageId, $rating);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return GenericListSearchResponse
     */
    public function vacancyApplicantListSearch(ListSearchRequest $listSearchRequest, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->vacancyApplicantListSearch($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating);
            $totalCount = $this->repository->vacancyApplicantListSearch($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return GenericPageSearchResponse
     */
    public function vacancyApplicantPageSearch(PageSearchRequest $pageSearchRequest, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->vacancyApplicantPageSearch($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating);
            $totalCount = $this->repository->vacancyApplicantPageSearch($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating, true);
            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    //</editor-fold>

}
