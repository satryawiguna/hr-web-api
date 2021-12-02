<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkExperience;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\WorkExperience\Contracts\EloquentWorkExperienceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class WorkExperienceRepository.
 */
class WorkExperienceRepository extends RepositoryAbstract implements WorkExperienceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkExperienceRepository constructor.
     *
     * @param EloquentWorkExperienceRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkExperienceRepositoryInterface $eloquent)
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
    public function setupPayload(WorkExperienceInterface $WorkExperience)
    {
        return [
            'employee_id' => $WorkExperience->getEmployeeId(),
            'company' => $WorkExperience->getCompany(),
            'business_type' => $WorkExperience->getBusinessType(),
            'position' => $WorkExperience->getPosition(),
            'start_date' => (!is_null($WorkExperience->getStartDate())) ? $WorkExperience->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($WorkExperience->getEndDate())) ? $WorkExperience->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'created_by' => $WorkExperience->getCreatedBy(),
            'modified_by' => $WorkExperience->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkExperienceInterface $WorkExperience)
    {
        $data = $this->setupPayload($WorkExperience);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $WorkExperiences
     * @return mixed
     */
    public function insert(Collection $WorkExperiences)
    {
        return $this->eloquent()->insert($WorkExperiences->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkExperienceInterface $WorkExperience)
    {
        $data = $this->setupPayload($WorkExperience);
       
        return $this->eloquent()->update($data, $WorkExperience->getKey());
    }

    /**
     * @param WorkExperienceInterface $WorkExperience
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(WorkExperienceInterface $WorkExperience, array $params)
    {
        $data = $this->setupPayload($WorkExperience);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WorkExperienceInterface $WorkExperience)
    {
        return $this->eloquent()->delete($WorkExperience->getKey());
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function workExperienceList(int $companyId = null, int $employeeId = null, DateTime $date = null)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workExperienceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }])->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workExperiencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
