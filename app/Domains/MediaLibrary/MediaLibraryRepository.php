<?php

namespace App\Domains\MediaLibrary;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class MediaLibraryRepository.
 */
class MediaLibraryRepository extends RepositoryAbstract implements MediaLibraryRepositoryInterface
{
    /**
     * MediaLibraryRepository constructor.
     *
     * @param EloquentMediaLibraryRepositoryInterface $eloquent
     */
    public function __construct(EloquentMediaLibraryRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(MediaLibraryInterface $MediaLibrary)
    {
        return [
            'user_id' => $MediaLibrary->getUserId(),
            'collection' => $MediaLibrary->getCollection(),
            'original_file' => $MediaLibrary->getOriginalFile(),
            'generate_file' => $MediaLibrary->getGenerateFile(),
            'extension' => $MediaLibrary->getExtension(),
            'type' => $MediaLibrary->getType(),
            'mime_type' => $MediaLibrary->getMimeType(),
            'disk' => $MediaLibrary->getDisk(),
            'path' => $MediaLibrary->getPath(),
            'width' => $MediaLibrary->getWidth(),
            'height' => $MediaLibrary->getHeight(),
            'size' => $MediaLibrary->getSize(),
            'created_by' => $MediaLibrary->getCreatedBy(),
            'modified_by' => $MediaLibrary->getModifiedBy(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(MediaLibraryInterface $MediaLibrary)
    {
        $data = $this->setupPayload($MediaLibrary);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(MediaLibraryInterface $MediaLibrary)
    {
        $data = $this->setupPayload($MediaLibrary);
       
        return $this->eloquent()->update($data, $MediaLibrary->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MediaLibraryInterface $MediaLibrary, array $relations = null)
    {
        return $this->eloquent()->delete($MediaLibrary->getKey(), true);
    }

    /**
     * @param array $userIds
     * @param string|null $collection
     * @return mixed
     */
    public function mediaLibraryList(array $userIds, string $collection = null)
    {
        $this->eloquent->findWhereInByUserId($userIds);

        if (!is_null($collection)) {
            $this->eloquent->findWhereByCollection($collection);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param array $userIds
     * @param string|null $collection
     * @param bool $count
     * @return mixed
     */
    public function mediaLibraryListSearch(ListedSearchParameter $parameter, array $userIds, string $collection = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        $this->eloquent->findWhereInByUserId($userIds);

        if (!is_null($collection)) {
            $this->eloquent->findWhereByCollection($collection);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param array $userIds
     * @param string|null $collection
     * @param bool $count
     * @return mixed
     */
    public function mediaLibraryPageSearch(PagedSearchParameter $parameter, array $userIds, string $collection = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        $this->eloquent->findWhereInByUserId($userIds);

        if (!is_null($collection)) {
            $this->eloquent->findWhereByCollection($collection);
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
}
