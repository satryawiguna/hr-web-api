<?php
namespace App\Infrastructures\MediaLibrary;

use App\Domains\User\UserEloquent;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use Illuminate\Support\Facades\DB;

/**
 * EloquentMediaLibraryRepository Class.
 */
class EloquentMediaLibraryRepository extends EloquentRepositoryAbstract implements EloquentMediaLibraryRepositoryInterface
{
    /**
     * @param array|int $id
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @param string|null $relationType
     * @return int|mixed
     */
    public function delete($id, bool $isPermanentDelete = false, array $relations = null, string $relationType = null)
    {
        $this->resetModel();

        if ($isPermanentDelete) {
            $ids = is_array($id) ? $id : [$id];

            //Detach files
            $this->modelInstance()->morphCompanies()->detach($ids);
            $this->modelInstance()->morphEmployees()->detach($ids);
            $this->modelInstance()->morphProfiles()->detach($ids);
            $this->modelInstance()->morphProjects()->detach($ids);
            $this->modelInstance()->morphProjectAddendums()->detach($ids);

            return $this->modelInstance()->whereIn('id', $ids)->delete();
        }

        $deleted = $this->modelInstance()->destroy($id);

        return $deleted;
    }

    /**
     * @param array $userId
     * @return $this
     */
    public function findWhereInByUserId(array $userId)
    {
        $this->model = $this->model->whereIn('user_id', $userId);

        return $this;
    }

    /**
     * @param string $collection
     * @return $this|mixed
     */
    public function findWhereByCollection(string $collection)
    {
        $this->model = $this->model->where('collection', $collection);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'original_file' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(original_file LIKE ?)', $searchParameter);

        return $this;
    }
}
