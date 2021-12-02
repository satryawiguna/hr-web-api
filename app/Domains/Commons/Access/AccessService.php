<?php

namespace App\Domains\Commons\Access;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Access\Contracts\Request\CreateAccessRequest;
use App\Domains\Commons\Access\Contracts\Request\EditAccessActiveRequest;
use App\Domains\Commons\Access\Contracts\Request\EditAccessRequest;
use App\Domains\ServiceAbstract;
use App\Domains\Commons\Access\Contracts\AccessRepositoryInterface;
use App\Domains\Commons\Access\Contracts\AccessServiceInterface;
use App\Domains\Commons\Access\Contracts\AccessInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * AccessService Class
 * It has all useful methods for business logic.
 */
class AccessService extends ServiceAbstract implements AccessServiceInterface
{
    /**
     * @var AccessRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our AccessInterface
     * AccessService constructor.
     *
     * @param AccessRepositoryInterface $repository
     */
    public function __construct(AccessRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(CreateAccessRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'name'      => 'required',
            'slug'      => 'required',
            'is_active' => 'nullable',
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $access = $this->repository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "is_active" => $request->is_active,
            ]);

            $this->setAuditableInformationFromRequest($access, $request);

            $result = $this->repository->create($access);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(),'Access was created', 200);
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
    public function update(EditAccessRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'name'      => 'required',
            'slug'      => 'required',
            'is_active' => 'nullable',
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $access = $this->repository->find($request->id);

        $access->fill([
            "name" => $request->name,
            "slug" => $request->slug,
            "description" => $request->description,
            "is_active" => $request->is_active,
        ]);

        $this->setAuditableInformationFromRequest($access, $request);

        try {
            $result = $this->repository->update($access);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Access was updated', 200);
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
            $access = $this->repository->find($id);

            $this->repository->delete($access);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Access was deleted', 200);
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
    public function deleteBulk(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Applications was deleted', 200);
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
     * @param EditAccessActiveRequest $request
     * @return BasicResponse
     */
    public function accessSetActive(EditAccessActiveRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        $rules = [
            'is_active' => 'required'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $access = $this->repository->find($request->id);

            $access->setAttribute('is_active', $request->is_active);

            $this->setAuditableInformationFromRequest($access);

            $result = $this->repository->update($access);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(),'Access was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(),'Access was deactivated', 200);
            }
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
     * @param string $name
     * @return ObjectResponse
     */
    public function accessSlug(string $name): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $access = $this->repository->newInstance();

            $result = (object) [
                'slug' => SlugService::createSlug($access, 'slug', $name)
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

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function accessList(int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->accessList($isActive);

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
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function accessListSearch(ListSearchRequest $listSearchRequest, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->accessListSearch($parameter, $isActive);
            $totalCount = $this->repository->accessListSearch($parameter, $isActive, true);

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
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function accessPageSearch(PageSearchRequest $pageSearchRequest, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->accessPageSearch($parameter, $isActive);
            $totalCount = $this->repository->accessPageSearch($parameter, $isActive, true);
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
}
