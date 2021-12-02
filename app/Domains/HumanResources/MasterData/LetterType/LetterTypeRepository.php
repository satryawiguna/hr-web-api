<?php

namespace App\Domains\HumanResources\MasterData\LetterType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\LetterType\Contracts\EloquentLetterTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class LetterTypeRepository.
 */
class LetterTypeRepository extends RepositoryAbstract implements LetterTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * LetterTypeRepository constructor.
     *
     * @param EloquentLetterTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentLetterTypeRepositoryInterface $eloquent)
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
    public function setupPayload(LetterTypeInterface $LetterType)
    {
        return [
            'company_id' => $LetterType->getCompanyId(),
            'code' => $LetterType->getCode(),
            'name' => $LetterType->getName(),
            'slug' => $LetterType->getSlug(),
            'description' => $LetterType->getDescription(),
            'is_active' => (!is_null($LetterType->getIsActive())) ? $LetterType->getIsActive() : 0,
            'created_by' => $LetterType->getCreatedBy(),
            'modified_by' => $LetterType->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(LetterTypeInterface $LetterType)
    {
        $data = $this->setupPayload($LetterType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(LetterTypeInterface $LetterType)
    {
        $data = $this->setupPayload($LetterType);

        return $this->eloquent()->update($data, $LetterType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(LetterTypeInterface $LetterType)
    {
        return $this->eloquent()->delete($LetterType->getKey());
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
    public function letterTypeList(int $companyId = null, int $isActive = null)
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
    public function letterTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
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
    public function letterTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
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
