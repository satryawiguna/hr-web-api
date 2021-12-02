<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\VacancyApplicant\Contracts\EloquentVacancyApplicantRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface VacancyApplicantRepositoryInterface.
 */
interface VacancyApplicantRepositoryInterface
{
    //<editor-fold desc="#constructor">
    
    /**
     * VacancyApplicantRepositoryInterface constructor.
     *
     * @param EloquentVacancyApplicantRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyApplicantRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function create(VacancyApplicantInterface $VacancyApplicant);

    /**
     * Update VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function update(VacancyApplicantInterface $VacancyApplicant);

    /**
     * Delete VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function delete(VacancyApplicantInterface $VacancyApplicant);

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
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return mixed
     */
    public function vacancyApplicantList(int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param bool $count
     * @return mixed
     */
    public function vacancyApplicantListSearch(ListedSearchParameter $parameter, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param bool $count
     * @return mixed
     */
    public function vacancyApplicantPageSearch(PagedSearchParameter $parameter, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null, bool $count = false);

    //</editor-fold>
}