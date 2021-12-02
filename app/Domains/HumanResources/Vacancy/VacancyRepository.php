<?php

namespace App\Domains\HumanResources\Vacancy;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyRepositoryInterface;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyInterface;
use App\Infrastructures\HumanResources\Vacancy\Contracts\EloquentVacancyRepositoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class VacancyRepository.
 */
class VacancyRepository extends RepositoryAbstract implements VacancyRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyRepository constructor.
     *
     * @param EloquentVacancyRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyRepositoryInterface $eloquent)
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
    public function setupPayload(VacancyInterface $Vacancy)
    {
        return [
            'company_id' => $Vacancy->getCompanyId(),
            'vacancy_location_id' => $Vacancy->getVacancyLocationId(),
            'vacancy_category_id' => $Vacancy->getVacancyCategoryId(),
            'title' => $Vacancy->getTitle(),
            'slug' => $Vacancy->getSlug(),
            'publish_date' => $Vacancy->getPublishDate(),
            'expired_date' => $Vacancy->getExpiredDate(),
            'min_salary' => $Vacancy->getMinSalary(),
            'max_salary' => $Vacancy->getMaxSalary(),
            'reference_code' => $Vacancy->getReferenceCode(),
            'intro' => $Vacancy->getIntro(),
            'description' => $Vacancy->getDescription(),
            'requirement' => $Vacancy->getRequirement(),
            'needs' => $Vacancy->getNeeds(),
            'work_status' => $Vacancy->getWorkStatus(),
            'work_type' => $Vacancy->getWorkType(),
            'status' => $Vacancy->getStatus(),
            'created_by' => $Vacancy->getCreatedBy(),
            'modified_by' => $Vacancy->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(VacancyInterface $Vacancy, array $relation = null)
    {
        $data = $this->setupPayload($Vacancy);

        return $this->eloquent()->create($data, $relation);
    }

    /**
     * {@inheritdoc}
     */
    public function update(VacancyInterface $Vacancy, array $relation = null)
    {
        $data = $this->setupPayload($Vacancy);
       
        return $this->eloquent()->update($data, $Vacancy->getKey(), $relation);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyInterface $Vacancy, bool $isPermanentDelete = false, array $relation = null)
    {
        return $this->eloquent()->delete($Vacancy->getKey(), $isPermanentDelete, $relation);
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
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return mixed
     */
    public function vacancyList(int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($vacancyLocationId != null) {
            $this->eloquent->findWhereByVacancyLocationId($vacancyLocationId);
        }

        if ($vacancyCategoryId != null) {
            $this->eloquent->findWhereByVacancyCategoryId($vacancyCategoryId);
        }

        if ($rangePublishDate != null &&
            property_exists($rangePublishDate, 'start') &&
            property_exists($rangePublishDate, 'end')) {
            if(!is_null($rangePublishDate->start) && !is_null($rangePublishDate->end)){
                $this->eloquent->findWhereBetweenByRangePublishDate($rangePublishDate->start, $rangePublishDate->end);
            }
        }

        if ($rangeExpiredDate != null &&
            property_exists($rangeExpiredDate, 'start') &&
            property_exists($rangeExpiredDate, 'end')) {
            if(!is_null($rangeExpiredDate->start) && !is_null($rangeExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeExpiredDate($rangeExpiredDate->start, $rangeExpiredDate->end);
            }
        }

        if ($workStatus != null) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if ($workType != null) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if ($status != null) {
            $this->eloquent->findWhereByStatus($status);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param bool $count
     * @return mixed
     */
    public function vacancyListSearch(ListedSearchParameter $parameter, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($vacancyLocationId != null) {
            $this->eloquent->findWhereByVacancyLocationId($vacancyLocationId);
        }

        if ($vacancyCategoryId != null) {
            $this->eloquent->findWhereByVacancyCategoryId($vacancyCategoryId);
        }

        if ($rangePublishDate != null &&
            property_exists($rangePublishDate, 'start') &&
            property_exists($rangePublishDate, 'end')) {
            if(!is_null($rangePublishDate->start) && !is_null($rangePublishDate->end)){
                $this->eloquent->findWhereBetweenByRangePublishDate($rangePublishDate->start, $rangePublishDate->end);
            }
        }

        if ($rangeExpiredDate != null &&
            property_exists($rangeExpiredDate, 'start') &&
            property_exists($rangeExpiredDate, 'end')) {
            if(!is_null($rangeExpiredDate->start) && !is_null($rangeExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeExpiredDate($rangeExpiredDate->start, $rangeExpiredDate->end);
            }
        }

        if ($workStatus != null) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if ($workType != null) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if ($status != null) {
            $this->eloquent->findWhereByStatus($status);
        }

        if (!$count) {
            return $this->eloquent->with(['company', 'vacancyCategory'])->all();
        } else {
            return $this->eloquent()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param bool $count
     * @return mixed
     */
    public function vacancyPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null, $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($vacancyLocationId != null) {
            $this->eloquent->findWhereByVacancyLocationId($vacancyLocationId);
        }

        if ($vacancyCategoryId != null) {
            $this->eloquent->findWhereByVacancyCategoryId($vacancyCategoryId);
        }

        if ($rangePublishDate != null &&
            property_exists($rangePublishDate, 'start') &&
            property_exists($rangePublishDate, 'end')) {
            if(!is_null($rangePublishDate->start) && !is_null($rangePublishDate->end)){
                $this->eloquent->findWhereBetweenByRangePublishDate($rangePublishDate->start, $rangePublishDate->end);
            }
        }

        if ($rangeExpiredDate != null &&
            property_exists($rangeExpiredDate, 'start') &&
            property_exists($rangeExpiredDate, 'end')) {
            if(!is_null($rangeExpiredDate->start) && !is_null($rangeExpiredDate->end)){
                $this->eloquent->findWhereBetweenByRangeExpiredDate($rangeExpiredDate->start, $rangeExpiredDate->end);
            }
        }

        if ($workStatus != null) {
            $this->eloquent->findWhereByWorkStatus($workStatus);
        }

        if ($workType != null) {
            $this->eloquent->findWhereByWorkType($workType);
        }

        if ($status != null) {
            $this->eloquent->findWhereByStatus($status);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company', 'vacancyLocation', 'vacancyCategory'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company', 'vacancyLocation', 'vacancyCategory'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
