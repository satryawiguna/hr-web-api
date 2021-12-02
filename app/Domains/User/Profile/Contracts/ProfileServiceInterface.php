<?php

namespace App\Domains\User\Profile\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;
use App\Domains\User\Profile\Contracts\Request\EditProfileRequest;

/**
 * Interface ProfileServiceInterface.
 */
interface ProfileServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProfileServiceInterface constructor.
     *
     * @param ProfileRepositoryInterface $repository
     */
    public function __construct(ProfileRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Update Profile.
     *
     * @param EditProfileRequest $request
     *
     * @return mixed
     */
    public function update(EditProfileRequest $request);

    /**
     * Delete Profile.
     *
     * @param ProfileInterface $Profile
     *
     * @return mixed
     */
    public function delete(ProfileInterface $Profile);

    //</editor-fold>
}
