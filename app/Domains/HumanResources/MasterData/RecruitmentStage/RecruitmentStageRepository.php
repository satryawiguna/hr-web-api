<?php

namespace App\Domains\HumanResources\MasterData\RecruitmentStage;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\RecruitmentStage\Contracts\EloquentRecruitmentStageRepositoryInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class RecruitmentStageRepository.
 */
class RecruitmentStageRepository extends RepositoryAbstract implements RecruitmentStageRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentStageRepository constructor.
     *
     * @param EloquentRecruitmentStageRepositoryInterface $eloquent
     */
    public function __construct(EloquentRecruitmentStageRepositoryInterface $eloquent)
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
    public function setupPayload(RecruitmentStageInterface $RecruitmentStage)
    {
        return [
            'company_id' => $RecruitmentStage->getCompanyId(),
            'name' => $RecruitmentStage->getName(),
            'slug' => $RecruitmentStage->getSlug(),
            'color' => $RecruitmentStage->getColor(),
            'sort_order' => $RecruitmentStage->getSortOrder(),
            'is_scheduled' => $RecruitmentStage->getIsScheduled(),
            'is_init' => $RecruitmentStage->getIsInit(),
            'is_hired' => $RecruitmentStage->getIsHired(),
            'is_reject' => $RecruitmentStage->getIsReject(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(RecruitmentStageInterface $RecruitmentStage)
    {
        $data = $this->setupPayload($RecruitmentStage);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(RecruitmentStageInterface $RecruitmentStage)
    {
        $data = $this->setupPayload($RecruitmentStage);
       
        return $this->eloquent()->update($data, $RecruitmentStage->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RecruitmentStageInterface $RecruitmentStage)
    {
        return $this->eloquent()->delete($RecruitmentStage->getKey());
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
     * @return mixed
     */
    public function recruitmentStageList(int $companyId = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function recruitmentStageListSearch(ListedSearchParameter $parameter, int $companyId = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!$count) {
            return $this->eloquent->with(['company'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function recruitmentStagePageSearch(PagedSearchParameter $parameter, int $companyId = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
