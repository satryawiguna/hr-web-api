<?php

namespace App\Domains\HumanResources\Recruitment\Applicant;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantRepositoryInterface;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantServiceInterface;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * ApplicantService Class
 * It has all useful methods for business logic.
 */
class ApplicantService extends ServiceAbstract implements ApplicantServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var ApplicantRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our ApplicantInterface
     * ApplicantService constructor.
     *
     * @param ApplicantRepositoryInterface $repository
     */
    public function __construct(ApplicantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(ApplicantInterface $Applicant)
    {
        $response = new ObjectResponse();

        $Applicant->profile_id = Auth::user()->profile->id;

        $validator = Validator::make($Applicant->toArray(), [
            'profile_id' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'marital_status_id' => 'required',
            'identity_number' => 'required',
            'identity_expired_date' => 'required',
            'identity_address' => 'required',
            // 'passport_number' => 'required_if:country,id',
            // 'passport_expired_date' => 'required_if:country,id',
            // 'visa_number' => 'required_if:country,id',
            // 'visa_expired_date' => 'required_if:country,id',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $count = $this->repository->findWhere(['profile_id' => $Applicant->profile_id])->count();

        if ($count) {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Applicant already exists', 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Applicant);

        try {
            $result = $this->repository->create($Applicant);

            if ($Applicant->photo) {
                $file = md5($result->id) . '.' . $Applicant->photo->extension();
                $result->logo = $Applicant->photo->storeAs('applicant/photo', $file, 'local');

                $this->repository->update($result);
            }

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Applicant was created', 200);
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
    public function update(ApplicantInterface $Applicant)
    {
        $response = new BasicResponse();

        if (!$Applicant->photo) {
            unset($Applicant->photo);
        }

        $validator = Validator::make($Applicant->toArray(), [
            'profile_id' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'marital_status_id' => 'required',
            'identity_number' => 'required',
            'identity_expired_date' => 'required',
            'identity_address' => 'required',
            // 'passport_number' => 'required_if:country,id',
            // 'passport_expired_date' => 'required_if:country,id',
            // 'visa_number' => 'required_if:country,id',
            // 'visa_expired_date' => 'required_if:country,id',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Applicant);

        try {
            if ($Applicant->photo && file_exists(Storage::url($Applicant->getOriginal('photo')))) {
                Storage::delete($Applicant->getOriginal('photo'));
            }

            if ($Applicant->photo) {
                $file = md5($Applicant->id) . '.' . $Applicant->photo->extension();
                $Applicant->photo = $Applicant->photo->storeAs('applicant/photo', $file, 'local');
            }

            $this->repository->update($Applicant);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Applicant was updated', 200);
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
    public function delete(ApplicantInterface $Applicant)
    {
        $response = new BasicResponse();

        try {
            if ($Applicant->photo && file_exists(Storage::url($Applicant->getOriginal('photo')))) {
                Storage::delete($Applicant->getOriginal('photo'));
            }

            $this->repository->delete($Applicant);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Applicant was deleted', 200);
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
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return GenericCollectionResponse
     */
    public function applicantList(int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->applicantList($profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);

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
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return GenericListSearchResponse
     */
    public function applicantListSearch(ListSearchRequest $listSearchRequest, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->applicantListSearch($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);
            $totalCount = $this->repository->applicantListSearch($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate, true);

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
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return GenericPageSearchResponse|mixed
     */
    public function applicantPageSearch(PageSearchRequest $pageSearchRequest, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericPageSearchResponse
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

            $results = $this->repository->applicantPageSearch($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);
            $totalCount = $this->repository->applicantPageSearch($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate, true);

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
