<?php

namespace App\Domains\Area\Country;

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
use App\Domains\Area\Country\Contracts\CountryRepositoryInterface;
use App\Domains\Area\Country\Contracts\CountryServiceInterface;
use App\Domains\Area\Country\Contracts\CountryInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * CountryService Class
 * It has all useful methods for business logic.
 */
class CountryService extends ServiceAbstract implements CountryServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var CountryRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our CountryInterface
     * CountryService constructor.
     *
     * @param CountryRepositoryInterface $repository
     */
    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CountryInterface $Country): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Country->toArray(), [
            'country_name'    => 'required',
            'two_letter_code' => 'required',
            'phone_code'      => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->create($Country);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Country was created', 200);
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
    public function update(CountryInterface $Country): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Country->toArray(), [
            'country_name'    => 'required',
            'two_letter_code' => 'required',
            'phone_code'      => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->update($Country);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Country was updated', 200);
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
    public function delete(CountryInterface $Country): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Country);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Country was deleted', 200);
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
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericCollectionResponse
     */
    public function countryList(string $countryName = null, string $twoLetterCode = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->countryList($countryName, $twoLetterCode);

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
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericListSearchResponse
     */
    public function countryListSearch(ListSearchRequest $listSearchRequest, string $countryName = null, string $twoLetterCode = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->countryListSearch($parameter, $countryName, $twoLetterCode);
            $totalCount = $this->repository->countryListSearch($parameter, $countryName, $twoLetterCode, true);

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
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericPageSearchResponse
     */
    public function countryPageSearch(PageSearchRequest $pageSearchRequest, string $countryName = null, string $twoLetterCode = null): GenericPageSearchResponse
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

            $results = $this->repository->countryPageSearch($parameter, $countryName, $twoLetterCode);
            $totalCount = $this->repository->countryPageSearch($parameter, $countryName, $twoLetterCode, true);
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
