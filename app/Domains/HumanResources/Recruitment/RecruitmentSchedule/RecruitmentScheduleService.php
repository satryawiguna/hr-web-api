<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule;

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
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleRepositoryInterface;
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleServiceInterface;
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * RecruitmentScheduleService Class
 * It has all useful methods for business logic.
 */
class RecruitmentScheduleService extends ServiceAbstract implements RecruitmentScheduleServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var RecruitmentScheduleRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our RecruitmentScheduleInterface
     * RecruitmentScheduleService constructor.
     *
     * @param RecruitmentScheduleRepositoryInterface $repository
     */
    public function __construct(RecruitmentScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(RecruitmentScheduleInterface $RecruitmentSchedule): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($RecruitmentSchedule->toArray(), [
            'vacancy_application_id' => 'required',
            'schedule_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($RecruitmentSchedule);

        try {
            $result = $this->repository->create($RecruitmentSchedule);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment schedule was created', 200);
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
    public function update(RecruitmentScheduleInterface $RecruitmentSchedule): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($RecruitmentSchedule->toArray(), [
            'vacancy_application_id' => 'required',
            'schedule_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($RecruitmentSchedule);

        try {
            $this->repository->update($RecruitmentSchedule);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment schedule was updated', 200);
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
    public function delete(RecruitmentScheduleInterface $RecruitmentSchedule): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($RecruitmentSchedule);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment schedule was deleted', 200);
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
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericCollectionResponse
     */
    public function recruitmentScheduleList(int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->recruitmentScheduleList($vacancyApplicationId, $rangeScheduleDate);

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
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericListSearchResponse
     */
    public function recruitmentScheduleListSearch(ListSearchRequest $listSearchRequest, int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->recruitmentScheduleListSearch($parameter, $vacancyApplicationId, $rangeScheduleDate);
            $totalCount = $this->repository->recruitmentScheduleListSearch($parameter, $vacancyApplicationId, $rangeScheduleDate, true);

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
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericPageSearchResponse
     */
    public function recruitmentSchedulePageSearch(PageSearchRequest $pageSearchRequest, int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericPageSearchResponse
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

            $results = $this->repository->recruitmentSchedulePageSearch($parameter, $vacancyApplicationId, $rangeScheduleDate);
            $totalCount = $this->repository->recruitmentSchedulePageSearch($parameter, $vacancyApplicationId, $rangeScheduleDate, true);
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
