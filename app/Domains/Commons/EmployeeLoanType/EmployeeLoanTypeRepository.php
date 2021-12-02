<?php

namespace App\Domains\Commons\EmployeeLoanType;

use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeRepositoryInterface;
use App\Infrastructures\Commons\EmployeeLoanType\Contracts\EloquentEmployeeLoanTypeRepositoryInterface;
use App\Domains\Commons\EmployeeLoanType\Contracts\EmployeeLoanTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class EmployeeLoanTypeRepository.
 */
class EmployeeLoanTypeRepository extends RepositoryAbstract implements EmployeeLoanTypeRepositoryInterface
{
    /**
     * EmployeeLoanTypeRepository constructor.
     *
     * @param EloquentEmployeeLoanTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeLoanTypeRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        return [
            'name' => $EmployeeLoanType->getName(),
            'slug' => $EmployeeLoanType->getSlug(),
            'description' => $EmployeeLoanType->getDescription(),
            'is_active' => $EmployeeLoanType->getIsActive(),
            'created_by' => $EmployeeLoanType->getCreatedBy(),
            'modified_by' => $EmployeeLoanType->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        $data = $this->setupPayload($EmployeeLoanType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        $data = $this->setupPayload($EmployeeLoanType);
       
        return $this->eloquent()->update($data, $EmployeeLoanType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(EmployeeLoanTypeInterface $EmployeeLoanType)
    {
        return $this->eloquent()->delete($EmployeeLoanType->getKey());
    }
}
