<?php

namespace App\Domains\HumanResources\Vacancy;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Vacancy\Contracts\Request\CreateVacancyRequest;
use App\Domains\HumanResources\Vacancy\Contracts\Request\EditVacancyRequest;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyInterface;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyRepositoryInterface;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyServiceInterface;
use App\Domains\ServiceAbstract;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * VacancyService Class
 * It has all useful methods for business logic.
 */
class VacancyService extends ServiceAbstract implements VacancyServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var VacancyRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our VacancyInterface
     * VacancyService constructor.
     *
     * @param VacancyRepositoryInterface $repository
     */
    public function __construct(VacancyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CreateVacancyRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_id'          => 'required',
            'vacancy_location_id' => 'required',
            'vacancy_category_id' => 'required',
            'title'               => 'required|unique:vacancies',
            'slug'                => 'required|unique:vacancies',
            'publish_date'        => 'required',
            'expired_date'        => 'required',
            'min_salary'          => 'required',
            'max_salary'          => 'required',
            'reference_code'      => 'required',
            'intro'               => 'required',
            'description'         => 'required',
            'requirement'         => 'required',
            'needs'               => 'required|numeric|digits_between:1,3',
            'work_status'         => 'required',
            'work_type'           => 'required',
            'status'              => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {

            $vacancy = $this->newInstance([
                'company_id'          => $request->company_id,
                'vacancy_location_id' => $request->vacancy_location_id,
                'vacancy_category_id' => $request->vacancy_category_id,
                'title'               => $request->title,
                'slug'                => $request->slug,
                'publish_date'        => $request->publish_date,
                'expired_date'        => $request->expired_date,
                'min_salary'          => $request->min_salary,
                'max_salary'          => $request->max_salary,
                'reference_code'      => $request->reference_code,
                'intro'               => $request->intro,
                'description'         => $request->description,
                'requirement'         => $request->requirement,
                'needs'               => $request->needs,
                'work_status'         => $request->work_status,
                'work_type'           => $request->work_type,
                'status'              => $request->status,
            ]);

            $this->setAuditableInformationFromRequest($vacancy, $request);

            $relation = [];

            if (isset($request->degree) && !empty($request->degree)) {
                $relation['degree'] = [
                    "data" => $request->degree,
                    'method' => 'attach'
                ];
            }

            if (isset($request->skill) && !empty($request->skill)) {
                $relation['skill'] = [
                    "data" => $request->skill,
                    'method' => 'attach'
                ];
            }

            if (isset($request->additional_question) && !empty($request->additional_question)) {
                $relation['additionalQuestion'] = [
                    "data" => $request->additional_question,
                    'method' => 'attach'
                ];
            }

            $result = $this->repository->create($vacancy, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy was created', 200);
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
    public function update(EditVacancyRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_id'          => 'required',
            'vacancy_location_id' => 'required',
            'vacancy_category_id' => 'required',
            'title'               => 'required',
            'slug'                => 'required',
            'publish_date'        => 'required',
            'expired_date'        => 'required',
            'min_salary'          => 'required',
            'max_salary'          => 'required',
            'reference_code'      => 'required',
            'intro'               => 'required',
            'description'         => 'required',
            'requirement'         => 'required',
            'needs'               => 'required|numeric|digits_between:1,3',
            'work_status'         => 'required',
            'work_type'           => 'required',
            'status'              => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {

            $vacancy = $this->repository->find($request->id);

            $vacancy->fill([
                'company_id'          => $request->company_id,
                'vacancy_location_id' => $request->vacancy_location_id,
                'vacancy_category_id' => $request->vacancy_category_id,
                'title'               => $request->title,
                'slug'                => $request->slug,
                'publish_date'        => $request->publish_date,
                'expired_date'        => $request->expired_date,
                'min_salary'          => $request->min_salary,
                'max_salary'          => $request->max_salary,
                'reference_code'      => $request->reference_code,
                'intro'               => $request->intro,
                'description'         => $request->description,
                'requirement'         => $request->requirement,
                'needs'               => $request->needs,
                'work_status'         => $request->work_status,
                'work_type'           => $request->work_type,
                'status'              => $request->status,
            ]);

            $this->setAuditableInformationFromRequest($vacancy, $request);

            $relation = [];

            if (isset($request->degree) && !empty($request->degree)) {
                $relation['degree'] = [
                    "data" => $request->degree,
                    'method' => 'sync'
                ];
            }

            if (isset($request->skill) && !empty($request->skill)) {
                $relation['skill'] = [
                    "data" => $request->skill,
                    'method' => 'sync'
                ];
            }

            if (isset($request->additional_question) && !empty($request->additional_question)) {
                $relation['additionalQuestion'] = [
                    "data" => $request->additional_question,
                    'method' => 'sync'
                ];
            }

            $result = $this->repository->update($vacancy, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy was updated', 200);
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
    public function delete(VacancyInterface $Vacancy)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Vacancy);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy was deleted', 200);
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
     * @param array $ids
     * @return BasicResponse|mixed
     */
    public function deleteBulk(array $ids)
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy was deleted', 200);
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
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return GenericCollectionResponse|mixed
     */
    public function vacancyList(int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->vacancyList($companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);

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
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return GenericListSearchResponse
     */
    public function vacancyListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->vacancyListSearch($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);
            $totalCount = $this->repository->vacancyListSearch($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status, true);

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
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return GenericPageSearchResponse|mixed
     */
    public function vacancyPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericPageSearchResponse
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

            $results = $this->repository->vacancyPageSearch($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);
            $totalCount = $this->repository->vacancyPageSearch($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status, true);

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
            dd($ex);
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetPublish(VacancyInterface $Vacancy): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Vacancy->toArray(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Vacancy);

        try {
            $result = $this->repository->update($Vacancy);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(),'Vacancy was published', 200);
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
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetDraft(VacancyInterface $Vacancy): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Vacancy->toArray(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Vacancy);

        try {
            $result = $this->repository->update($Vacancy);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(),'Vacancy was drafted', 200);
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
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetPending(VacancyInterface $Vacancy): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Vacancy->toArray(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Vacancy);

        try {
            $result = $this->repository->update($Vacancy);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(),'Vacancy was pending', 200);
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
