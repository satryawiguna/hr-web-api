<?php

namespace App\Domains\HumanResources\MasterData\RecruitmentStage;

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
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageRepositoryInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageServiceInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * RecruitmentStageService Class
 * It has all useful methods for business logic.
 */
class RecruitmentStageService extends ServiceAbstract implements RecruitmentStageServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var RecruitmentStageRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our RecruitmentStageInterface
     * RecruitmentStageService constructor.
     *
     * @param RecruitmentStageRepositoryInterface $repository
     */
    public function __construct(RecruitmentStageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(RecruitmentStageInterface $RecruitmentStage): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($RecruitmentStage->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:recruitment_stages',
            'color' => 'required',
            'sort_order' => 'required',
            'is_scheduled' => 'required',
            'is_init' => 'required',
            'is_hired' => 'required',
            'is_reject' => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($RecruitmentStage);

        try {
            $result = $this->repository->create($RecruitmentStage);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment stage was created', 200);
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
    public function update(RecruitmentStageInterface $RecruitmentStage): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($RecruitmentStage->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:recruitment_stages,slug,'.$RecruitmentStage->id,
            'color' => 'required',
            'sort_order' => 'required',
            'is_scheduled' => 'required',
            'is_init' => 'required',
            'is_hired' => 'required',
            'is_reject' => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($RecruitmentStage);

        try {
            $result = $this->repository->update($RecruitmentStage);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment stage was updated', 200);
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
    public function delete(RecruitmentStageInterface $RecruitmentStage)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($RecruitmentStage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment stage was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Recruitment stages was deleted', 200);
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
     * @return GenericCollectionResponse
     */
    public function recruitmentStageList(int $companyId = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->recruitmentStageList($companyId);

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
     * @return GenericListSearchResponse
     */
    public function recruitmentStageListSearch(ListSearchRequest $listSearchRequest, int $companyId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->recruitmentStageListSearch($parameter, $companyId);
            $totalCount = $this->repository->recruitmentStageListSearch($parameter, $companyId, true);

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
     * @return GenericPageSearchResponse
     */
    public function recruitmentStagePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null): GenericPageSearchResponse
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

            $results = $this->repository->recruitmentStagePageSearch($parameter, $companyId);
            $totalCount = $this->repository->recruitmentStagePageSearch($parameter, $companyId, true);
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

    /**
     * @param RecruitmentStageInterface $RecruitmentStage
     * @return ObjectResponse
     */
    public function recruitmentStageSlug(RecruitmentStageInterface $RecruitmentStage): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $result = (object)[
                'slug' => SlugService::createSlug($RecruitmentStage, 'slug', $RecruitmentStage->getName(), ['company_id' => $RecruitmentStage->getCompanyId()])
            ];

            $response->setResult($result);

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
