<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicant\Contracts\EloquentVacancyApplicantRepositoryInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class VacancyApplicantRepository.
 */
class VacancyApplicantRepository extends RepositoryAbstract implements VacancyApplicantRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyApplicantRepository constructor.
     *
     * @param EloquentVacancyApplicantRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyApplicantRepositoryInterface $eloquent)
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
    public function setupPayload(VacancyApplicantInterface $VacancyApplicant)
    {
        return [
            'applicant_id' => $VacancyApplicant->getApplicantId(),
            'vacancy_id' => $VacancyApplicant->getVacancyId(),
            'recruitment_stage_id' => $VacancyApplicant->getRecruitmentStageId(),
            'cover_letter' => $VacancyApplicant->getCoverLetter(),
            'rating' => $VacancyApplicant->getRating(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(VacancyApplicantInterface $VacancyApplicant)
    {
        $data = $this->setupPayload($VacancyApplicant);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(VacancyApplicantInterface $VacancyApplicant)
    {
        $data = $this->setupPayload($VacancyApplicant);
       
        return $this->eloquent()->update($data, $VacancyApplicant->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyApplicantInterface $VacancyApplicant)
    {
        return $this->eloquent()->delete($VacancyApplicant->getKey());
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids)
    {
        return $this->eloquent()->delete($ids);
    }

    /**
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return mixed
     */
    public function vacancyApplicantList(int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null)
    {
        if (!is_null($applicantId)) {
            $this->eloquent->findWhereByApplicantId($applicantId);
        }

        if (!is_null($vacancyId)) {
            $this->eloquent->findWhereByVacancyId($vacancyId);
        }

        if (!is_null($recruitmentStageId)) {
            $this->eloquent->findWhereByRecruitmentStageId($recruitmentStageId);
        }

        if (!is_null($rating)) {
            $this->eloquent->findWhereByRating($rating);
        }


        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param bool $count
     * @return mixed
     */
    public function vacancyApplicantListSearch(ListedSearchParameter $parameter, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($applicantId)) {
            $this->eloquent->findWhereByApplicantId($applicantId);
        }

        if (!is_null($vacancyId)) {
            $this->eloquent->findWhereByVacancyId($vacancyId);
        }

        if (!is_null($recruitmentStageId)) {
            $this->eloquent->findWhereByRecruitmentStageId($recruitmentStageId);
        }

        if (!is_null($rating)) {
            $this->eloquent->findWhereByRating($rating);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param bool $count
     * @return mixed
     */
    public function vacancyApplicantPageSearch(PagedSearchParameter $parameter, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($applicantId)) {
            $this->eloquent->findWhereByApplicantId($applicantId);
        }

        if (!is_null($vacancyId)) {
            $this->eloquent->findWhereByVacancyId($vacancyId);
        }

        if (!is_null($recruitmentStageId)) {
            $this->eloquent->findWhereByRecruitmentStageId($recruitmentStageId);
        }

        if (!is_null($rating)) {
            $this->eloquent->findWhereByRating($rating);
        }

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
