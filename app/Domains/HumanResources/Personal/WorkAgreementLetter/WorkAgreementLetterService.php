<?php

namespace App\Domains\WorkAgreementLetter;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\CreateWorkAgreementLetterRequest;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\EditWorkAgreementLetterRequest;
use App\Domains\ServiceAbstract;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterRepositoryInterface;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterServiceInterface;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * WorkAgreementLetterService Class
 * It has all useful methods for business logic.
 */
class WorkAgreementLetterService extends ServiceAbstract implements WorkAgreementLetterServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var WorkAgreementLetterRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our WorkAgreementLetterInterface
     * WorkAgreementLetterService constructor.
     *
     * @param WorkAgreementLetterRepositoryInterface $repository
     */
    public function __construct(WorkAgreementLetterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CreateWorkAgreementLetterRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rule = [
            'employee_id' => 'required',
            'letter_type_id' => 'required',
            'reference_number' => 'required',
            'start_date' => 'required'
        ];

        $validator = Validator::make((array) $request, $rule);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $WorkAgreementLetter = $this->newInstance([
                'employee_id'     => $request->employee_id,
                'letter_type_id'  => $request->letter_type_id,
                'reference_number'=> $request->reference_number,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date
            ]);

            $this->setAuditableInformationFromRequest($WorkAgreementLetter, $request);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'attach'
                ]
            ];

            $workAgreementLetterResult = $this->repository->create($WorkAgreementLetter, $relation);

            $response->setResult($workAgreementLetterResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work agreement letter was created', 200);
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
    public function update(EditWorkAgreementLetterRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rule = [
            'employee_id' => 'required',
            'letter_type_id' => 'required',
            'reference_number' => 'required',
            'start_date' => 'required'
        ];

        $validator = Validator::make((array) $request, $rule);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $workAgreementLetter = $this->repository->find($request->id);

            $workAgreementLetter->fill([
                'employee_id'     => $request->employee_id,
                'letter_type_id'  => $request->letter_type_id,
                'reference_number'=> $request->reference_number,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date
            ]);

            $this->setAuditableInformationFromRequest($workAgreementLetter);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'sync'
                ]
            ];

            $workAgreementLetterResult = $this->repository->update($workAgreementLetter, $relation);

            $response->setResult($workAgreementLetterResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work agreement letter was updated', 200);
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
    public function delete(int $id): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $workAgreementLetter = $this->repository->find($id);

            $this->repository->delete($workAgreementLetter);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work agreement letter was deleted', 200);
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
    public function deleteBulk(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work agreement letters was deleted', 200);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function workAgreementLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workAgreementLetterList($companyId, $employeeId, $letterTypeId, $date);

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
     * @param int $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function workAgreementLetterListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->workAgreementLetterListSearch($parameter, $companyId, $employeeId, $letterTypeId, $date);
            $totalCount = $this->repository->workAgreementLetterListSearch($parameter, $companyId, $employeeId, $letterTypeId, $date,true);

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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function workAgreementLetterPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericPageSearchResponse
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

            $results = $this->repository->workAgreementLetterPageSearch($parameter, $companyId, $employeeId, $letterTypeId, $date);
            $totalCount = $this->repository->workAgreementLetterPageSearch($parameter, $companyId, $employeeId,  $letterTypeId, $date,true);
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
