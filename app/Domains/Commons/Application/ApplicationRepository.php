<?php

namespace App\Domains\Commons\Application;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Application\Contracts\ApplicationRepositoryInterface;
use App\Infrastructures\Commons\Application\Contracts\EloquentApplicationRepositoryInterface;
use App\Domains\Commons\Application\Contracts\ApplicationInterface;
use App\Domains\RepositoryAbstract;
use Closure;

/**
 * Class ApplicationRepository.
 */
class ApplicationRepository extends RepositoryAbstract implements ApplicationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicationRepository constructor.
     *
     * @param EloquentApplicationRepositoryInterface $eloquent
     */
    public function __construct(EloquentApplicationRepositoryInterface $eloquent)
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
    public function setupPayload(ApplicationInterface $Application)
    {
        return [
            'name' => $Application->getName(),
            'slug' => $Application->getSlug(),
            'description' => $Application->getDescription(),
            'is_active' => (!is_null($Application->getIsActive())) ? $Application->getIsActive() : 0,
            'created_by' => $Application->getCreatedBy(),
            'modified_by' => $Application->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ApplicationInterface $Application)
    {
        $data = $this->setupPayload($Application);

        return $this->eloquent->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ApplicationInterface $Application)
    {
        $data = $this->setupPayload($Application);

        return $this->eloquent->update($data, $Application->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ApplicationInterface $Application)
    {
        return $this->eloquent->delete($Application->getKey());
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
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->eloquent->findWithoutFail($id);
    }

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function applicationList(int $isActive = null)
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
    public function applicationListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
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
    public function applicationPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }

    //</editor-fold>
}
