<?php

namespace App\Domains\HumanResources\Recruitment;

use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Recruitment\Contracts\VacancyApplicantRepositoryInterface;
use App\Domains\HumanResources\Recruitment\Contracts\VacancyApplicantServiceInterface;
use App\Domains\HumanResources\Recruitment\Contracts\VacancyApplicantInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * RecruitmentService Class
 * It has all useful methods for business logic.
 */
class RecruitmentService extends ServiceAbstract implements VacancyApplicantServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var VacancyApplicantRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our VacancyApplicantInterface
     * RecruitmentService constructor.
     *
     * @param VacancyApplicantRepositoryInterface $repository
     */
    public function __construct(VacancyApplicantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(VacancyApplicantInterface $VacancyApplicant)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($VacancyApplicant->toArray(), [
            'applicant_id'         => 'required',
            'vacancy_id'           => 'required',
            'recruitment_stage_id' => 'required',
            'cover_letter'         => 'required',
            'rating'               => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($VacancyApplicant);

        try {
            $result = $this->repository->create($VacancyApplicant);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'VacancyApplicant was created', 200);
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
