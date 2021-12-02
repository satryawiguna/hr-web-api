<?php

namespace App\Domains\HumanResources\MasterData\Competence;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Competence\Contracts\EloquentCompetenceRepositoryInterface;
use App\Domains\HumanResources\MasterData\Competence\Contracts\CompetenceInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class CompetenceRepository.
 */
class CompetenceRepository extends RepositoryAbstract implements CompetenceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompetenceRepository constructor.
     *
     * @param EloquentCompetenceRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompetenceRepositoryInterface $eloquent)
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
    public function setupPayload(CompetenceInterface $Competence)
    {
        return [
            'company_id' => $Competence->getCompanyId(),
            'code' => $Competence->getCode(),
            'name' => $Competence->getName(),
            'slug' => $Competence->getSlug(),
            'description' => $Competence->getDescription(),
            'is_active' => (!is_null($Competence->getIsActive())) ? $Competence->getIsActive() : 0,
            'created_by' => $Competence->getCreatedBy(),
            'modified_by' => $Competence->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(CompetenceInterface $Competence)
    {
        $data = $this->setupPayload($Competence);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(CompetenceInterface $Competence)
    {
        $data = $this->setupPayload($Competence);
       
        return $this->eloquent()->update($data, $Competence->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CompetenceInterface $Competence)
    {
        return $this->eloquent()->delete($Competence->getKey());
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
     * @param int|null $isActive
     * @return mixed
     */
    public function competenceList(int $companyId = null, int $isActive = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function competenceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
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
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function competencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

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
