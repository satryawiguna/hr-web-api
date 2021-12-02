<?php

namespace App\Http\Controllers\API\v1\Area;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Area\Country\Contracts\CountryServiceInterface;
use App\Http\Controllers\BaseController;
use Exception;
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

    /**
     * @OA\Get(
     *     path="/countries",
     *     operationId="getCountryList",
     *     summary="Get list of country",
     *     tags={"Country"},
     *     description="Get list of country",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="country_name",
     *          in="query",
     *          description="Country name parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="Indonesia"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="two_letter_code",
     *          in="query",
     *          description="Two letter code parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="ID"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryList(Request $request)
    {
        $countryName = $request->get('country_name');
        $twoLetterCode = $request->get('two_letter_code');

        return $this->getListJson($countryName, $twoLetterCode,
            [$this->_countryServiceInterface, 'countryList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'country_name' => $entity->country_name,
                        'two_letter_code' => $entity->two_letter_code,
                        'phone_code' => $entity->phone_code
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/country/list-search",
     *     operationId="postCountryListSearch",
     *     summary="Get list of country with query search",
     *     tags={"Country"},
     *     description="Get list of country with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter cover letter)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="country_name", ref="#/components/schemas/CountryEloquent/properties/country_name"),
     *                  @OA\Property(property="two_letter_code", ref="#/components/schemas/CountryEloquent/properties/two_letter_code")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCountryListSearch(Request $request)
    {
        $countryName = $request->get('country_name');
        $twoLetterCode = $request->get('two_letter_code');

        return $this->getListSearchJson($request, $countryName, $twoLetterCode,
            [$this->_countryServiceInterface, 'countryListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'country_name' => $entity->country_name,
                        'two_letter_code' => $entity->two_letter_code,
                        'phone_code' => $entity->phone_code
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/country/page-search",
     *     operationId="postCountryPageSearch",
     *     summary="Get list of country with query and page parameter search",
     *     tags={"Country"},
     *     description="Get list of country with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter note)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="country_name", ref="#/components/schemas/CountryEloquent/properties/country_name"),
     *                          @OA\Property(property="two_letter_code", ref="#/components/schemas/CountryEloquent/properties/two_letter_code"),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postCountryPageSearch(Request $request)
    {
        $countryName = $request->get('country_name');
        $twoLetterCode = $request->get('two_letter_code');

        return $this->getPagedSearchJson($request,$countryName, $twoLetterCode,
            [$this->_countryServiceInterface, 'countryPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'country_name' => $entity->country_name,
                        'two_letter_code' => $entity->two_letter_code,
                        'phone_code' => $entity->phone_code
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/country",
     *     operationId="postCountryCreate",
     *     summary="Create country",
     *     tags={"Country"},
     *     description="Create country",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateCountryEloquent")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postCountryCreate(Request $request)
    {
        $country = $this->_countryServiceInterface->newInstance();

        $country->country_name = $request->input('country_name');
        $country->two_letter_code = $request->input('two_letter_code');
        $country->phone_code = $request->input('phone_code');

        $response = $this->_countryServiceInterface->create($country);
        $countryCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $countryCreated);
    }

    /**
     * @OA\Put(
     *     path="/country",
     *     operationId="putCountryUpdate",
     *     summary="Update country",
     *     tags={"Country"},
     *     description="Update country",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateCountryEloquent")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putCountryUpdate(Request $request)
    {
        $country = $this->_countryServiceInterface->find($request->input('id'));

        $result = $country->getObject();

        $result->country_name = $request->input('country_name');
        $result->two_letter_code = $request->input('two_letter_code');
        $result->phone_code = $request->input('phone_code');

        $response = $this->_countryServiceInterface->update($result);
        $countryUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $countryUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/country/{id}",
     *     operationId="deleteCountry",
     *     summary="Delete country",
     *     tags={"Country"},
     *     description="Delete country",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of country",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCountry(int $id)
    {
        $country = $this->_countryServiceInterface->find($id);

        $result = $country->getObject();

        $response = $this->_countryServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(string $countryName = null, string $twoLetterCode = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($countryName, $twoLetterCode);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, string $countryName = null, string $twoLetterCode = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $countryName, $twoLetterCode);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, string $countryName = null, string $twoLetterCode = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $countryName, $twoLetterCode);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }

    //</editor-fold>
}
