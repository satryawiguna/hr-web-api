<?php

namespace App\Http\Controllers\API\v1\HumanResources\Reqruitment;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Recruitment\Contracts\VacancyApplicantServiceInterface;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecruitmentController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_vacancyApplicantServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * RecruitmentController constructor.
     * @param VacancyApplicantServiceInterface $vacancyApplicantServiceInterface
     */
    public function __construct(VacancyApplicantServiceInterface $vacancyApplicantServiceInterface)
    {
        $this->_vacancyApplicantServiceInterface = $vacancyApplicantServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Post(
     *     path="/recruitment/apply",
     *     operationId="postVacancyApplicantCreate",
     *     summary="Create vacancy applicant",
     *     tags={"Recruitment"},
     *     description="Create vacancy applicant",
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
     *                      @OA\Schema(ref="#/components/schemas/CreateVacancyApplicantEloquent")
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
    public function postVacancyApplicantCreate(Request $request)
    {
        $vacancyApplicant = $this->_vacancyApplicantServiceInterface->newInstance();

        $vacancyApplicant->applicant_id = $request->input('applicant_id');
        $vacancyApplicant->vacancy_id = $request->input('vacancy_id');
        $vacancyApplicant->recruitment_stage_id = $request->input('recruitment_stage_id');
        $vacancyApplicant->cover_letter = $request->input('cover_letter');
        $vacancyApplicant->rating = $request->input('rating');

        $this->setRequestAuthor($vacancyApplicant);

        $response = $this->_vacancyApplicantServiceInterface->create($vacancyApplicant);
        $vacancyApplicantCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyApplicantCreated);
    }

    //</editor-fold>

    //<editor-fold desc="#private (method)">

    //</editor-fold>
}
