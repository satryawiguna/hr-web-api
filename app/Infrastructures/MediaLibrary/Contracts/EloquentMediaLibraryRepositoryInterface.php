<?php

namespace App\Infrastructures\MediaLibrary\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentMediaLibraryRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param array|int $id
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @param string|null $relationType
     * @return mixed
     */
    public function delete($id, bool $isPermanentDelete = false, array $relations = null, string $relationType = null);

    /**
     * @param array $userId
     * @return mixed
     */
    public function findWhereInByUserId(array $userId);

    /**
     * @param string $collection
     * @return mixed
     */
    public function findWhereByCollection(string $collection);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

}
