<?php

namespace App\Domains\User\Profile;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\User\Profile\Contracts\ProfileRepositoryInterface;
use App\Infrastructures\User\Profile\Contracts\EloquentProfileRepositoryInterface;
use App\Domains\User\Profile\Contracts\ProfileInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ProfileRepository.
 */
class ProfileRepository extends RepositoryAbstract implements ProfileRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProfileRepository constructor.
     *
     * @param EloquentProfileRepositoryInterface $eloquent
     */
    public function __construct(EloquentProfileRepositoryInterface $eloquent)
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
    public function setupPayload(ProfileInterface $Profile)
    {
        $data = [
            'user_id' => $Profile->getUserId(),
            'full_name' => $Profile->getFullName(),
            'nick_name' => $Profile->getNickName(),
            'country' => $Profile->getCountry(),
            'state_or_province' => $Profile->getStateOrProvince(),
            'city' => $Profile->getCity(),
            'address' => $Profile->getAddress(),
            'postcode' => $Profile->getPostcode(),
            'phone' => $Profile->getPhone(),
            'mobile' => $Profile->getMobile(),
            'email' => $Profile->getEmail(),
            'created_by' => $Profile->getCreatedBy(),
            'modified_by' => $Profile->getModifiedBy(),
            
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProfileInterface $Profile, array $relations = null)
    {
        $data = $this->setupPayload($Profile);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ProfileInterface $Profile, array $relations = null)
    {
        $data = $this->setupPayload($Profile);
       
        return $this->eloquent()->update($data, $Profile->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProfileInterface $Profile, bool $isPermanentDelete = false, array $relations = null)
    {
        return $this->eloquent()->delete($Profile->getKey(), $isPermanentDelete, $relations);
    }

    //</editor-fold>
}
