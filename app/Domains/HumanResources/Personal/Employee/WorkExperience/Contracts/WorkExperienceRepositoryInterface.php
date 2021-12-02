<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\WorkExperience\Contracts\EloquentWorkExperienceRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface WorkExperienceRepositoryInterface.
 */
interface WorkExperienceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkExperienceRepositoryInterface constructor.
     *
     * @param EloquentWorkExperienceRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkExperienceRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @return mixed
     */
    public function create(WorkExperienceInterface $WorkExperience);

    /**
     * @param Collection $WorkExperiences
     * @return mixed
     */
    public function insert(Collection $WorkExperiences);

    /**
     * Update WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @return mixed
     */
    public function update(WorkExperienceInterface $WorkExperience);

    /**
     * @param WorkExperienceInterface $WorkExperience
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(WorkExperienceInterface $WorkExperience, array $params);

    /**
     * Delete WorkExperience.
     *
     * @param WorkExperienceInterface $WorkExperience
     *
     * @return mixed
     */
    public function delete(WorkExperienceInterface $WorkExperience);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function workExperienceList(int $companyId = null, int $employeeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workExperienceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workExperiencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
