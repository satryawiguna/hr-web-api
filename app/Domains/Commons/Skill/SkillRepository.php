<?php

namespace App\Domains\Commons\Skill;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\Skill\Contracts\SkillRepositoryInterface;
use App\Infrastructures\Commons\Skill\Contracts\EloquentSkillRepositoryInterface;
use App\Domains\Commons\Skill\Contracts\SkillInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class SkillRepository.
 */
class SkillRepository extends RepositoryAbstract implements SkillRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SkillRepository constructor.
     *
     * @param EloquentSkillRepositoryInterface $eloquent
     */
    public function __construct(EloquentSkillRepositoryInterface $eloquent)
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
    public function setupPayload(SkillInterface $Skill)
    {
        return [
            'name' => $Skill->getName(),
            'slug' => $Skill->getSlug(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(SkillInterface $Skill)
    {
        $data = $this->setupPayload($Skill);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(SkillInterface $Skill)
    {
        $data = $this->setupPayload($Skill);
       
        return $this->eloquent()->update($data, $Skill->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(SkillInterface $Skill)
    {
        return $this->eloquent()->delete($Skill->getKey());
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
         * @return mixed
         */
        public function skillList()
        {
            return $this->eloquent->all();
        }
    
        /**
         * @param ListedSearchParameter $parameter
         * @param bool|null $count
         * @return mixed
         */
        public function skillListSearch(ListedSearchParameter $parameter, bool $count = null)
        {
            $searchQuery = $parameter->query;
    
            if ($searchQuery) {
                $this->eloquent->findWhereBySearchQuery($searchQuery);
            }
    
            if (!$count) {
                return $this->eloquent->all();
            } else {
                return $this->eloquent->all()->count();
            }
        }
    
        /**
         * @param PagedSearchParameter $parameter
         * @param bool $count
         * @return mixed
         */
        public function skillPageSearch(PagedSearchParameter $parameter, bool $count = false)
        {
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
