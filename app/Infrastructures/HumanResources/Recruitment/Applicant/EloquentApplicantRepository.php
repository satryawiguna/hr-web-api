<?php
namespace App\Infrastructures\HumanResources\Recruitment\Applicant;

use App\Infrastructures\HumanResources\Recruitment\Applicant\Contracts\EloquentApplicantRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * EloquentApplicantRepository Class.
 */
class EloquentApplicantRepository extends EloquentRepositoryAbstract implements EloquentApplicantRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $profileId
     * @return $this|mixed
     */
    public function findWhereByProfileId(int $profileId)
    {
        $this->model = $this->model->where('profile_id', $profileId);

        return $this;
    }

    /**
     * @param int $genderId
     * @return $this|mixed
     */
    public function findWhereByGenderId(int $genderId)
    {
        $this->model = $this->model->where('gender_id', $genderId);

        return $this;
    }

    /**
     * @param int $religionId
     * @return $this|mixed
     */
    public function findWhereByReligionId(int $religionId)
    {
        $this->model = $this->model->where('religion_id', $religionId);

        return $this;
    }

    /**
     * @param int $maritalStatusId
     * @return $this|mixed
     */
    public function findWhereByMaritalStatusId(int $maritalStatusId)
    {
        $this->model = $this->model->where('marital_status_id', $maritalStatusId);

        return $this;
    }

    /**
     * @param string $country
     * @return $this|mixed
     */
    public function findWhereByCountry(string $country)
    {
        $this->model = $this->model->where('country', $country);

        return $this;
    }

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, DateTime $endBirthDate)
    {
        $this->model = $this->model->whereBetween('birth_date', [
            $startBirthDate->format(Config::get('datetime.format.default')),
            $endBirthDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startPassportExpiredDate
     * @param DateTime $endPassportExpiredDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangePassportExpiredDate(DateTime $startPassportExpiredDate, DateTime $endPassportExpiredDate)
    {
        $this->model = $this->model->whereBetween('passport_expired_date', [
            $startPassportExpiredDate->format(Config::get('datetime.format.default')),
            $endPassportExpiredDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param DateTime $startVisaExpiredDate
     * @param DateTime $endVisaExpiredDate
     * @return $this|mixed
     */
    public function findWhereBetweenByRangeVisaExpiredDate(DateTime $startVisaExpiredDate, DateTime $endVisaExpiredDate)
    {
        $this->model = $this->model->whereBetween('visa_expired_date', [
            $startVisaExpiredDate->format(Config::get('datetime.format.default')),
            $endVisaExpiredDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $this->model = $this->model->where('identity_number', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('identity_address', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('passport_number', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('visa_number', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('birth_place', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}
