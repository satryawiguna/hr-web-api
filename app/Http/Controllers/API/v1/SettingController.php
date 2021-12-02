<?php

namespace App\Http\Controllers\API\v1;

use App\Domains\Commons\Company\Contracts\CompanyServiceInterface;
use App\Domains\Commons\Setting\Contracts\SettingServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    use BaseController;

    //<editor-fold desc="#field">

    private $_companyServiceInterface;
    private $_settingServiceInterface;

    //</editor-fold>

    /**
     * SettingController constructor.
     * @param CompanyServiceInterface $companyServiceInterface
     * @param SettingServiceInterface $settingServiceInterface
     */
    public function __construct(CompanyServiceInterface $companyServiceInterface,
                                SettingServiceInterface $settingServiceInterface)
    {
        $this->_companyServiceInterface = $companyServiceInterface;
        $this->_settingServiceInterface = $settingServiceInterface;
    }

    /**
     * @OA\Post(
     *     path="/setting/initialize",
     *     operationId="postInitializeDefaultSetting",
     *     summary="Initialize setting",
     *     tags={"Setting"},
     *     description="Return array of setting created",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company ID of setting",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "company_id"
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
     * Return array of setting created
     *
     * @param Request $request
     * @return mixed
     */
    public function postSettingInitializeDefault(Request $request)
    {
        $companyId = $request->input('company_id');

        $response = $this->_settingServiceInterface->settingInitializeDefault($companyId);

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/setting/initialize/all",
     *     operationId="postInitializeDefaultSettingAll",
     *     summary="Initialize all setting",
     *     tags={"Setting"},
     *     description="Return array of setting created",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded"
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
     * Return array of setting created
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSettingInitializeDefaultAll()
    {
        $result = $this->_companyServiceInterface->companyList();

        $response = $this->_settingServiceInterface->settingInitializeDefaultAll($result->_dtoCollection);

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/setting/initialize/additional",
     *     operationId="postInitializeAdditionalSetting",
     *     summary="Initialize additional setting",
     *     tags={"Setting"},
     *     description="Return array of setting created",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company ID of setting",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="additional_setting",
     *                      description="Filter additional_setting of setting by additional_setting parameter",
     *                      type="object",
     *                      example={
     *                          "key_1": "value_1",
     *                          "key_2": "value_2"
     *                      }
     *                  ),
     *                  required={
     *                      "company_id",
     *                      "additional_setting"
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
     * Return array of setting created
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSettingInitializeAdditional(Request $request)
    {
        $companyId = $request->input('company_id');
        $additionalSetting = json_decode($request->input('additional_setting'), true);

        $response = $this->_settingServiceInterface->settingIinitializeAdditional($companyId, $additionalSetting);

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSettingInitializeAdditionalAll(Request $request)
    {
        $additionalSetting = json_decode($request->input('additional_setting'), true);

        $result = $this->_companyServiceInterface->companyList();

        $response = $this->_settingServiceInterface->settingInitializeAdditionalAll($result->_dtoCollection, $additionalSetting);

        return $this->getBasicSuccessJson($response);
    }
}
