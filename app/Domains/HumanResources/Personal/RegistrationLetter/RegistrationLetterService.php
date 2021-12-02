<?php

namespace App\Domains\RegistrationLetter;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\CreateRegistrationLetterRequest;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\EditRegistrationLetterRequest;
use App\Domains\ServiceAbstract;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterRepositoryInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterServiceInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * RegistrationLetterService Class
 * It has all useful methods for business logic.
 */
class RegistrationLetterService extends ServiceAbstract implements RegistrationLetterServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var RegistrationLetterRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our RegistrationLetterInterface
     * RegistrationLetterService constructor.
     *
     * @param RegistrationLetterRepositoryInterface $repository
     */
    public function __construct(RegistrationLetterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param CreateRegistrationLetterRequest $request
     * @return ObjectResponse
     */
    public function create(CreateRegistrationLetterRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $role = [
            'employee_id'       => 'required',
            'letter_type_id'    => 'required',
            'reference_number'  => 'required',
            'start_date'        => 'required'
        ];

        $validator = Validator::make((array) $request, $role);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $registrationLetter = $this->newInstance([
                'employee_id'       => $request->employee_id,
                'letter_type_id'    => $request->letter_type_id,
                'reference_number'  => $request->reference_number,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'description'       => $request->description
            ]);

            $this->setAuditableInformationFromRequest($registrationLetter, $request);

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

            $registrationLetterResult = $this->repository->create($registrationLetter, $relation);

            $response->setResult($registrationLetterResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Registration letter was created', 200);
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
    public function update(EditRegistrationLetterRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'employee_id' => 'required',
            'letter_type_id' => 'required',
            'reference_number' => 'required',
            'start_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $registrationLetter = $this->repository->find($request->id);

            $registrationLetter->fill([
                'employee_id'       => $request->employee_id,
                'letter_type_id'    => $request->letter_type_id,
                'reference_number'  => $request->reference_number,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'description'       => $request->description
            ]);

            $this->setAuditableInformationFromRequest($registrationLetter);

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

            $this->repository->update($registrationLetter, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Registration letter was updated', 200);
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
            $registrationLetter = $this->repository->find($id);

            $this->repository->delete($registrationLetter);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Registration letter was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Registration letters was deleted', 200);
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
    public function registrationLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->registrationLetterList($companyId, $employeeId, $letterTypeId, $date);

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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function registrationLetterListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->registrationLetterListSearch($parameter, $companyId, $employeeId, $letterTypeId, $date);
            $totalCount = $this->repository->registrationLetterListSearch($parameter, $employeeId, $letterTypeId, $date,true);

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
    public function registrationLetterPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericPageSearchResponse
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

            $results = $this->repository->registrationLetterPageSearch($parameter, $companyId, $employeeId, $letterTypeId, $date);
            $totalCount = $this->repository->registrationLetterPageSearch($parameter, $companyId, $employeeId,  $letterTypeId, $date,true);
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
