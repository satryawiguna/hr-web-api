<?php

namespace App\Domains\Commons\Company;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\IntegerResponse;
use App\Domains\Commons\Company\Contracts\Request\CreateCompanyRequest;
use App\Domains\Commons\Company\Contracts\Request\EditCompanyRequest;
use App\Domains\ServiceAbstract;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\Commons\Company\Contracts\CompanyServiceInterface;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Application;

/**
 * CompanyService Class
 * It has all useful methods for business logic.
 */
class CompanyService extends ServiceAbstract implements CompanyServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var CompanyRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our CompanyInterface
     * CompanyService constructor.
     *
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CreateCompanyRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_category_id' => 'required',
            'employee_number_scale_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            //'logo' => 'mimes:' . \config('filesystems.image.extension') . '|max:' . \config('filesystems.image.size')
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $company = $this->newInstance([
                'company_category_id' => $request->company_category_id,
                'employee_number_scale_id' => $request->employee_number_scale_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'email' => $request->email,
                'url' => $request->url,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'description' => $request->description,
                'is_active' => $request->is_active
            ]);

            $this->setAuditableInformationFromRequest($company, $request);

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

            $result = $this->repository->create($company, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Company was created', 200);
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
    public function update(EditCompanyRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_category_id' => 'required',
            'employee_number_scale_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            //'logo' => 'mimes:' . \config('filesystems.image.extension') . '|max:' . \config('filesystems.image.size'),
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $company = $this->repository->find($request->id);

            $company->fill([
                'company_category_id' => $request->company_category_id,
                'employee_number_scale_id' => $request->employee_number_scale_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'email' => $request->email,
                'url' => $request->url,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'description' => $request->description,
                'is_active' => $request->is_active
            ]);

            $this->setAuditableInformationFromRequest($company, $request);

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

            $result = $this->repository->update($company, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Company was updated', 200);
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
    public function delete(CompanyInterface $Company): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->delete($Company, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Company was deleted', 200);
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
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->deleteBulk($ids, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Companies was deleted', 200);
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
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return GenericCollectionResponse
     */
    public function companyList(int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->companyList($companyCategoryId, $employeeNumberScaleId, $isActive);

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
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return GenericListSearchResponse
     */
    public function companyListSearch(ListSearchRequest $listSearchRequest, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->companyListSearch($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive);
            $totalCount = $this->repository->companyListSearch($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive, true);

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
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return GenericPageSearchResponse|mixed
     */
    public function companyPageSearch(PageSearchRequest $pageSearchRequest, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->companyPageSearch($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive);
            $totalCount = $this->repository->companyPageSearch($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive, true);

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
     * @param CompanyInterface $Company
     * @return BasicResponse
     */
    public function companySetActive(CompanyInterface $Company): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($Company->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Company);

        try {
            $result = $this->repository->update($Company);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Company was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Company was deactivated', 200);
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
     * @param CompanyInterface $Company
     * @return ObjectResponse
     */
    public function companySlug(CompanyInterface $Company): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = (object)[
                'slug' => SlugService::createSlug($Company, 'slug', $Company->getName())
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
