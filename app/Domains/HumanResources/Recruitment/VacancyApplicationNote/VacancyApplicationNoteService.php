<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote;

use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteRepositoryInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteServiceInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteInterface;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\ObjectResponse;
use Illuminate\Support\Facades\Validator;

/**
 * VacancyApplicationNoteService Class
 * It has all useful methods for business logic.
 */
class VacancyApplicationNoteService extends ServiceAbstract implements VacancyApplicationNoteServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var VacancyApplicationNoteRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our VacancyApplicationNoteInterface
     * VacancyApplicationNoteService constructor.
     *
     * @param VacancyApplicationNoteRepositoryInterface $repository
     */
    public function __construct(VacancyApplicationNoteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(VacancyApplicationNoteInterface $VacancyApplicationNote): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($VacancyApplicationNote->toArray(), [
            'vacancy_application_id'    => 'required',
            'note'                      => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->create($VacancyApplicationNote);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Vacancy applicant note was created', 200);
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
    public function update(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        return $this->repository->update($VacancyApplicationNote);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyApplicationNoteInterface $VacancyApplicationNote)
    {
        return $this->repository->delete($VacancyApplicationNote);
    }

    //</editor-fold>
}
