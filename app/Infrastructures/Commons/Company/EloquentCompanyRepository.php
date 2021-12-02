<?php

namespace App\Infrastructures\Commons\Company;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Infrastructures\Commons\Company\Contracts\EloquentCompanyRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use Illuminate\Support\Facades\DB;

/**
 * EloquentCompanyRepository Class.
 */
class EloquentCompanyRepository extends EloquentRepositoryAbstract implements EloquentCompanyRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $fields
     * @return $this|mixed
     */
    public function select(string $fields)
    {
        $this->model = $this->model->select($fields);

        return $this;
    }

    /**
     * @param string $table
     * @param string $foreignKeyField
     * @param string $conditional
     * @param string $keyField
     * @param string|null $type
     * @return $this|mixed
     */
    public function join(string $table, string $foreignKeyField, string $conditional, string $keyField, string $type = null)
    {
        $this->model = $this->model->join($table, $foreignKeyField, $conditional, $keyField, $type);

        return $this;
    }

    /**
     * @param int $companyCategoryId
     * @return $this|mixed
     */
    public function findWhereByCompanyCategoryId(int $companyCategoryId)
    {
        $this->model = $this->model->where('companies.company_category_id', $companyCategoryId);

        return $this;
    }

    /**
     * @param int $employeeNumberScaleId
     * @return $this|mixed
     */
    public function findWhereByEmployeeNumberScaleId(int $employeeNumberScaleId)
    {
        $this->model = $this->model->where('companies.employee_number_scale_id', $employeeNumberScaleId);

        return $this;
    }

    /**
     * @param int $isActive
     * @return $this|mixed
     */
    public function findWhereByIsActive(int $isActive)
    {
        $this->model = $this->model->where('companies.is_active', $isActive);

        return $this;
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param string|null $collection
     * @return $this|mixed
     */
    public function withListSearchMediaLibraries(ListedSearchParameter $parameter, string $collection = null)
    {
        $this->model = $this->model->with(['mediaLibrariesByMorphMany' => function($query) use($parameter, $collection) {
            $searchQuery = $parameter->query;

            if ($searchQuery) {
                $searchParameter = [
                    'original_file' => '%' . $searchQuery . '%'
                ];

                $query->whereRaw('(original_file LIKE ?)', $searchParameter);
            }

            if (!is_null($collection)) {
                $query->where('collection', $collection);
            }

            return $query;
        }]);

        return $this;
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param string|null $collection
     * @return $this|mixed
     */
    public function withPageSearchMediaLibraries(PagedSearchParameter $parameter, string $collection = null)
    {
        $this->model = $this->model->with(['mediaLibrariesByMorphMany' => function($query) use($parameter, $collection) {
            $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

            if ($searchQuery) {
                $searchParameter = [
                    'original_file' => '%' . $searchQuery . '%'
                ];

                $query->whereRaw('(original_file LIKE ?)', $searchParameter);
            }

            if (!is_null($collection)) {
                $query->where('collection', $collection);
            }

            if ($parameter->draw) {
                $query->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->limit($parameter->length, $parameter->start);
            } else {
                $query->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->limit($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }

            return $query;
        }]);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'email' => '%' . $searchQuery . '%',
            'url' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('('. DB::getTablePrefix() .'companies.name LIKE ?
            OR '. DB::getTablePrefix() .'companies.email LIKE ?
            OR '. DB::getTablePrefix() .'companies.url LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
