<?php

namespace App\Domains\User\Profile;

use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;
use App\Domains\ServiceAbstract;
use App\Domains\User\Profile\Contracts\ProfileRepositoryInterface;
use App\Domains\User\Profile\Contracts\ProfileServiceInterface;
use App\Domains\User\Profile\Contracts\ProfileInterface;
use App\Domains\User\Profile\Contracts\Request\EditProfileRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * ProfileService Class
 * It has all useful methods for business logic.
 */
class ProfileService extends ServiceAbstract implements ProfileServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var ProfileRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our ProfileInterface
     * ProfileService constructor.
     *
     * @param ProfileRepositoryInterface $repository
     */
    public function __construct(ProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(ProfileInterface $Profile)
    {
        $response = new ObjectResponse();

        $Profile->user_id = Auth::user()->id;

        $validator = Validator::make($Profile->toArray(), [
            'full_name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $count = $this->repository->findWhere(['user_id' => $Profile->user_id])->count();

        if ($count) {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Profile already exists', 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Profile);

        try {
            $mediaLibraries = [];

            if ($Profile->media_libraries) {
                foreach ($Profile->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }
            unset($Profile->media_libraries);

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'sync'
                ]
            ];

            $result = $this->repository->create($Profile, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Profile was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EditProfileRequest $request)
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'full_name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $profile = $this->repository->find($request->id);

            $profile->fill([
                "full_name" => $request->full_name,
                "nick_name" => $request->nick_name,
                "country" => $request->country,
                "state_or_province" => $request->state_or_province,
                "city" => $request->city,
                "address" => $request->address,
                "postcode" => $request->postcode,
                "phone" => $request->phone,
                "mobile" => $request->mobile,
                "email" => $request->email
            ]);

            $this->setAuditableInformationFromRequest($profile);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'sync'
                ]
            ];

            $result = $this->repository->update($profile, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Profile was updated', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProfileInterface $Profile)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Profile);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Profile was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }
}
