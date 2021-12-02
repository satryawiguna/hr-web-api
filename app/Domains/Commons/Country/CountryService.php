<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 1/27/20
 * Time: 9:53 PM
 */

namespace App\Domains\Commons\Country;


use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Domains\Commons\Country\Contracts\CountryServiceInterface;
use App\Infrastructures\EloquentAbstract;
use GuzzleHttp;
use ErrorException;
use Illuminate\Support\Collection;

class CountryService extends EloquentAbstract implements CountryServiceInterface
{
    /**
     * @param ListSearchRequest $listSearchRequest
     * @return GenericListSearchResponse
     */
    public function countryListSearch(ListSearchRequest $listSearchRequest, string $alpha_two_code = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $http = new GuzzleHttp\Client();

            $countries = null;

            if(!is_null($parameter->query) && !empty($parameter->query)){
                $countries = $http->get("https://restcountries.eu/rest/v2/name/" . $parameter->query);
            }

            if(!is_null($alpha_two_code) && !empty($alpha_two_code)){
                $countries = $http->get("https://restcountries.eu/rest/v2/alpha?codes=" . $alpha_two_code);
            }

            $results = new Collection(json_decode((string)$countries->getBody()));
            $response->setDtoList($results);
            $response->setTotalCount($results->count());

            $response->addSuccessMessageResponse($response->getMessageCollection(), "Country list search", 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }
}
