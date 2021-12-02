<?php

namespace App\Domains\HumanResources\MasterData\AdditionalQuestion;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\AdditionalQuestion\Contracts\EloquentAdditionalQuestionRepositoryInterface;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class AdditionalQuestionRepository.
 */
class AdditionalQuestionRepository extends RepositoryAbstract implements AdditionalQuestionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * AdditionalQuestionRepository constructor.
     *
     * @param EloquentAdditionalQuestionRepositoryInterface $eloquent
     */
    public function __construct(EloquentAdditionalQuestionRepositoryInterface $eloquent)
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
    public function setupPayload(AdditionalQuestionInterface $AdditionalQuestion)
    {
        return [
            'company_id' => $AdditionalQuestion->getCompanyId(),
            'question' => $AdditionalQuestion->getQuestion(),
            'is_required' => (!is_null($AdditionalQuestion->getIsRequired())) ? $AdditionalQuestion->getIsRequired() : 0,
            'status' => $AdditionalQuestion->getStatus()
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(AdditionalQuestionInterface $AdditionalQuestion)
    {
        $data = $this->setupPayload($AdditionalQuestion);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(AdditionalQuestionInterface $AdditionalQuestion)
    {
        $data = $this->setupPayload($AdditionalQuestion);
       
        return $this->eloquent()->update($data, $AdditionalQuestion->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AdditionalQuestionInterface $AdditionalQuestion)
    {
        return $this->eloquent()->delete($AdditionalQuestion->getKey());
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
     * @param int|null $isRequired
     * @param string|null $status
     * @return mixed
     */
    public function additionalQuestionList(int $companyId = null, int $isRequired = null, string $status = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isRequired)) {
            $this->eloquent->findWhereByIsRequired($isRequired);
        }

        if (!is_null($status)) {
            $this->eloquent->findWhereByStatus($status);
        }


        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param bool $count
     * @return mixed
     */
    public function additionalQuestionListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isRequired = null, string $status = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isRequired)) {
            $this->eloquent->findWhereByIsRequired($isRequired);
        }

        if (!is_null($status)) {
            $this->eloquent->findWhereByStatus($status);
        }

        if (!$count) {
            return $this->eloquent->with(['company'])->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param bool $count
     * @return mixed
     */
    public function additionalQuestionPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isRequired = null, string $status = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isRequired)) {
            $this->eloquent->findWhereByIsRequired($isRequired);
        }

        if (!is_null($status)) {
            $this->eloquent->findWhereByStatus($status);
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
