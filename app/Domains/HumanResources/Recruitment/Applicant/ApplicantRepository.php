<?php

namespace App\Domains\HumanResources\Recruitment\Applicant;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\Applicant\Contracts\EloquentApplicantRepositoryInterface;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ApplicantRepository.
 */
class ApplicantRepository extends RepositoryAbstract implements ApplicantRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicantRepository constructor.
     *
     * @param EloquentApplicantRepositoryInterface $eloquent
     */
    public function __construct(EloquentApplicantRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(ApplicantInterface $Applicant)
    {
        return [
            'profile_id' => $Applicant->getProfileId(),
            'gender_id' => $Applicant->getGenderId(),
            'religion_id' => $Applicant->getReligionId(),
            'marital_status_id' => $Applicant->getMaritalStatusId(),
            'passport_number' => $Applicant->getPassportNumber(),
            'passport_expired_date' => $Applicant->getPassportExpiredDate(),
            'identity_number' => $Applicant->getIdentityNumber(),
            'identity_expired_date' => $Applicant->getIdentityExpiredDate(),
            'identity_address' => $Applicant->getIdentityAddress(),
            'visa_number' => $Applicant->getVisaNumber(),
            'visa_expired_date' => $Applicant->getVisaExpiredDate(),
            'birth_date' => $Applicant->getBirthDate(),
            'birth_place' => $Applicant->getBirthPlace(),
            'age' => $Applicant->getAge(),
            'weight' => $Applicant->getWeight(),
            'height' => $Applicant->getHeight(),
            'linkedin' => $Applicant->getLinkedin(),
            'facebook' => $Applicant->getFacebook(),
            'instagram' => $Applicant->getInstagram(),
            'skype' => $Applicant->getSkype(),
            'website' => $Applicant->getWebsite(),
            'created_by' => $Applicant->getCreatedBy(),
            'modified_by' => $Applicant->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ApplicantInterface $Applicant)
    {
        $data = $this->setupPayload($Applicant);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ApplicantInterface $Applicant)
    {
        $data = $this->setupPayload($Applicant);

        return $this->eloquent()->update($data, $Applicant->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ApplicantInterface $Applicant)
    {
        return $this->eloquent()->delete($Applicant->getKey());
    }

    /**
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return mixed
     */
    public function applicantList(int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null)
    {
        if ($profileId != null) {
            $this->eloquent->findWhereByProfileId($profileId);
        }

        if ($genderId != null) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if ($religionId != null) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if ($maritalStatusId != null) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if ($rangeBirthDate != null &&
            property_exists($rangeBirthDate, 'start') &&
            property_exists($rangeBirthDate, 'end')) {
            if(!is_null($rangeBirthDate->start) && !is_null($rangeBirthDate->end)){
                $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
            }
        }

        if ($rangePassportExpiredDate != null &&
            property_exists($rangePassportExpiredDate, 'start') &&
            property_exists($rangePassportExpiredDate, 'end')) {
            if(!is_null($rangePassportExpiredDate->start) && !is_null($rangePassportExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangePassportExpiredDate($rangePassportExpiredDate->start, $rangePassportExpiredDate->end);
            }
        }

        if ($rangeVisaExpiredDate != null &&
            property_exists($rangeVisaExpiredDate, 'start') &&
            property_exists($rangeVisaExpiredDate, 'end')) {
            if(!is_null($rangeVisaExpiredDate->start) && !is_null($rangeVisaExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeVisaExpiredDate($rangeVisaExpiredDate->start, $rangeVisaExpiredDate->end);
            }
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @param bool $count
     * @return mixed
     */
    public function applicantListSearch(ListedSearchParameter $parameter, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null, $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($profileId != null) {
            $this->eloquent->findWhereByProfileId($profileId);
        }

        if ($genderId != null) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if ($religionId != null) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if ($maritalStatusId != null) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if ($rangeBirthDate != null &&
            property_exists($rangeBirthDate, 'start') &&
            property_exists($rangeBirthDate, 'end')) {
            if(!is_null($rangeBirthDate->start) && !is_null($rangeBirthDate->end)){
                $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
            }
        }

        if ($rangePassportExpiredDate != null &&
            property_exists($rangePassportExpiredDate, 'start') &&
            property_exists($rangePassportExpiredDate, 'end')) {
            if(!is_null($rangePassportExpiredDate->start) && !is_null($rangePassportExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangePassportExpiredDate($rangePassportExpiredDate->start, $rangePassportExpiredDate->end);
            }
        }

        if ($rangeVisaExpiredDate != null &&
            property_exists($rangeVisaExpiredDate, 'start') &&
            property_exists($rangeVisaExpiredDate, 'end')) {
            if(!is_null($rangeVisaExpiredDate->start) && !is_null($rangeVisaExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeVisaExpiredDate($rangeVisaExpiredDate->start, $rangeVisaExpiredDate->end);
            }
        }

        if (!$count) {
            return $this->eloquent->with(['profile', 'gender', 'religion', 'maritalStatus'])->all();
        } else {
            return $this->eloquent->with(['profile', 'gender', 'religion', 'maritalStatus'])->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @param bool $count
     * @return mixed
     */
    public function applicantPageSearch(PagedSearchParameter $parameter, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null, $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if($searchQuery != null) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($profileId != null) {
            $this->eloquent->findWhereByProfileId($profileId);
        }

        if ($genderId != null) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if ($religionId != null) {
            $this->eloquent->findWhereByReligionId($religionId);
        }

        if ($maritalStatusId != null) {
            $this->eloquent->findWhereByMaritalStatusId($maritalStatusId);
        }

        if ($rangeBirthDate != null &&
            property_exists($rangeBirthDate, 'start') &&
            property_exists($rangeBirthDate, 'end')) {
            if(!is_null($rangeBirthDate->start) && !is_null($rangeBirthDate->end)){
                $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
            }
        }

        if ($rangePassportExpiredDate != null &&
            property_exists($rangePassportExpiredDate, 'start') &&
            property_exists($rangePassportExpiredDate, 'end')) {
            if(!is_null($rangePassportExpiredDate->start) && !is_null($rangePassportExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangePassportExpiredDate($rangePassportExpiredDate->start, $rangePassportExpiredDate->end);
            }
        }

        if ($rangeVisaExpiredDate != null &&
            property_exists($rangeVisaExpiredDate, 'start') &&
            property_exists($rangeVisaExpiredDate, 'end')) {
            if(!is_null($rangeVisaExpiredDate->start) && !is_null($rangeVisaExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeVisaExpiredDate($rangeVisaExpiredDate->start, $rangeVisaExpiredDate->end);
            }
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['profile', 'gender', 'religion', 'maritalStatus'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['profile', 'gender', 'religion', 'maritalStatus'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
