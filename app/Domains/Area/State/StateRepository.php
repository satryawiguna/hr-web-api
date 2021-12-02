<?php

namespace App\Domains\Area\State;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Area\State\Contracts\StateRepositoryInterface;
use App\Infrastructures\Area\State\Contracts\EloquentStateRepositoryInterface;
use App\Domains\Area\State\Contracts\StateInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class StateRepository.
 */
class StateRepository extends RepositoryAbstract implements StateRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * StateRepository constructor.
     *
     * @param EloquentStateRepositoryInterface $eloquent
     */
    public function __construct(EloquentStateRepositoryInterface $eloquent)
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
    public function setupPayload(StateInterface $State)
    {
        return [
            'country_id' => $State->getCountryId(),
            'state_name' => $State->getStateName()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(StateInterface $State)
    {
        $data = $this->setupPayload($State);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(StateInterface $State)
    {
        $data = $this->setupPayload($State);

        return $this->eloquent()->update($data, $State->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(StateInterface $State)
    {
        return $this->eloquent()->delete($State->getKey());
    }

    /**
     * @param int|null $countryId
     * @return mixed
     */
    public function stateList(int $countryId = null)
    {
        if (!is_null($countryId)) {
            $this->eloquent->findWereByCountryId($countryId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $countryId
     * @param bool|null $count
     * @return mixed
     */
    public function stateListSearch(ListedSearchParameter $parameter, int $countryId = null, bool $count = null)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($countryId)) {
            $this->eloquent->findWereByCountryId($countryId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $countryId
     * @param bool $count
     * @return mixed
     */
    public function statePageSearch(PagedSearchParameter $parameter, int $countryId = null, bool $count = false)
    {
        if (!is_null($countryId)) {
            $this->eloquent->findWereByCountryId($countryId);
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
