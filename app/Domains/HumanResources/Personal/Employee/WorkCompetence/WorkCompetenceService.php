<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts\WorkCompetenceInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * WorkCompetenceService Class
 * It has all useful methods for business logic.
 */
class WorkCompetenceService extends ServiceAbstract implements WorkCompetenceServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var WorkCompetenceRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our WorkCompetenceInterface
     * WorkCompetenceService constructor.
     *
     * @param WorkCompetenceRepositoryInterface $repository
     */
    public function __construct(WorkCompetenceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(WorkCompetenceInterface $WorkCompetence)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($WorkCompetence->toArray(), [
            'employee_id' => 'required',
            'competence_id' => 'required',
            'reference_number' => 'required',
            'issue_date' => 'required',
            'validity' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkCompetence);

        try {
            $result = $this->repository->create($WorkCompetence);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was created', 200);
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
     * @param Collection $WorkCompetences
     * @return BasicResponse|mixed
     */
    public function insert(Collection $WorkCompetences)
    {
        $response = new BasicResponse();

        $WorkCompetences->map(function ($row) use ($response) {
            $validator = Validator::make($row->toArray(), [
                'employee_id' => 'required',
                'competence_id' => 'required',
                'reference_number' => 'required',
                'issue_date' => 'required',
                'validity' => 'required'
            ]);

            if ($validator->fails()) {
                $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                return $response;
            }

            $this->setAuditableInformationFromRequest($row);
        });

        try {
            $this->repository->insert($WorkCompetences);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was created', 200);
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
    public function update(WorkCompetenceInterface $WorkCompetence, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($WorkCompetence->toArray(), [
            'employee_id' => 'required',
            'competence_id' => 'required',
            'reference_number' => 'required',
            'issue_date' => 'required',
            'validity' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkCompetence);

        try {
            if (!$params) {
                $this->repository->update($WorkCompetence);
            } else {
                $this->repository->updateOrCreate($WorkCompetence, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was updated', 200);
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
    public function delete(WorkCompetenceInterface $WorkCompetence)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($WorkCompetence);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was deleted', 200);
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
     * @return BasicResponse
     */
    public function deleteBulk(array $ids)
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was deleted', 200);
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
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericCollectionResponse
     */
    public function workCompetenceList(int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workCompetenceList($companyId, $employeeId, $competenceId, $rangeIssueDate);

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
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericListSearchResponse
     */
    public function workCompetenceListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->workCompetenceListSearch($parameter, $companyId, $employeeId, $competenceId, $rangeIssueDate);
            $totalCount = $this->repository->otherEquipmentListSearch($parameter, $companyId, $employeeId, true);

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
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericPageSearchResponse
     */
    public function workCompetencePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericPageSearchResponse
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

            $results = $this->repository->workCompetencePageSearch($parameter, $companyId, $employeeId, $competenceId, $rangeIssueDate);
            $totalCount = $this->repository->workCompetencePageSearch($parameter, $companyId, $employeeId, $competenceId, $rangeIssueDate, true);
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
