<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Domains\Commons\Country\Contracts\CountryServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class CountryController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_countryServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * CountryController constructor.
     * @param CountryServiceInterface $countryServiceInterface
     */
    public function __construct(CountryServiceInterface $countryServiceInterface)
    {
        $this->_countryServiceInterface = $countryServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    public function postCountryListSearch(Request $request)
    {
        $alpha_two_code = $request->has('alpha_two_code') ? $request->alpha_two_code : null;

        return $this->getListSearchJson($request, $alpha_two_code,
            [$this->_countryServiceInterface, 'countryListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'name' => $entity->name,
                        'alpha_two_code' => $entity->alpha2Code,
                        'alpha_three_code' => $entity->alpha3Code
                    ]);
                }

                return $rowJsonData;
            });
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param Request $request
     * @param string|null $alpha_two_code
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, string $alpha_two_code = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $alpha_two_code);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    //</editor-fold>
}
