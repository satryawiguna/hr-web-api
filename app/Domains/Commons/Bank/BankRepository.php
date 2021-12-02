<?php

namespace App\Domains\Commons\Bank;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Bank\Contracts\BankRepositoryInterface;
use App\Infrastructures\Commons\Bank\Contracts\EloquentBankRepositoryInterface;
use App\Domains\Commons\Bank\Contracts\BankInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class BankRepository.
 */
class BankRepository extends RepositoryAbstract implements BankRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BankRepository constructor.
     *
     * @param EloquentBankRepositoryInterface $eloquent
     */
    public function __construct(EloquentBankRepositoryInterface $eloquent)
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
    public function setupPayload(BankInterface $Bank)
    {
        return [
            'name' => $Bank->getName(),
            'slug' => $Bank->getSlug(),
            'description' => $Bank->getDescription(),
            'is_active' => (!is_null($Bank->getIsActive())) ? $Bank->getIsActive() : 0,
            'created_by' => $Bank->getCreatedBy(),
            'modified_by' => $Bank->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(BankInterface $Bank)
    {
        $data = $this->setupPayload($Bank);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(BankInterface $Bank)
    {
        $data = $this->setupPayload($Bank);

        return $this->eloquent()->update($data, $Bank->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BankInterface $Bank)
    {
        return $this->eloquent()->delete($Bank->getKey());
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
     * @param int $isActive
     * @return mixed
     */
    public function bankList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function bankListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function bankPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

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
