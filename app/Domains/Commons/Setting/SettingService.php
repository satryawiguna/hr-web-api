<?php

namespace App\Domains\Commons\Setting;

use App\Core\Services\Response\ArrayResponse;
use App\Core\Services\Response\BasicResponse;
use App\Domains\ServiceAbstract;
use App\Domains\Commons\Setting\Contracts\SettingServiceInterface;
use App\Helpers\Common;
use ErrorException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * SettingService Class
 * It has all useful methods for business logic.
 */
class SettingService extends ServiceAbstract implements SettingServiceInterface
{
    public function __construct()
    {
    }

    /**
     * @param int $companyId
     * @return ArrayResponse|mixed
     */
    public function settingInitializeDefault(int $companyId)
    {
        $response = new BasicResponse();

        try {
            setting()->setConstraint(function($query, $insert) use($companyId) {
                if ($insert) return;

                $query->where([
                    'company_id'=> $companyId
                ]);
            });

            $setting = setting()->all();

            if (empty($setting)) {
                setting()->setExtraColumns([
                    'company_id' => $companyId
                ]);

                if (version_compare(Application::VERSION, '5.0', '>=')) {
                    setting(Config::get('settings.default'))
                        ->save();
                } else {
                    setting(Config::get('anlutro/l4-settings::default'))
                        ->save();
                }

                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Setting was created', 200);
            } else {
                $response->addWarningMessageResponse($response->getMessageCollection(), 'Setting already exists', 200);
            }
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param Collection $companies
     * @return BasicResponse|mixed
     */
    public function settingInitializeDefaultAll(Collection $companies)
    {
        $response = new BasicResponse();

        try {
            foreach ($companies as $company) {
                $companyId = $company->id;

                setting()->setConstraint(function($query, $insert) use($companyId) {
                    if ($insert) return;

                    $query->where([
                        'company_id'=> $companyId
                    ]);
                });

                $setting = setting()->all();

                if (empty($setting)) {
                    setting()->setExtraColumns([
                        'company_id' => $companyId
                    ]);

                    if (version_compare(Application::VERSION, '5.0', '>=')) {
                        setting(Config::get('settings.default'))
                            ->save();
                    } else {
                        setting(Config::get('anlutro/l4-settings::default'))
                            ->save();
                    }

                    $response->addSuccessMessageResponse($response->getMessageCollection(), 'Setting was created', 200);
                } else {
                    $response->addWarningMessageResponse($response->getMessageCollection(), 'Setting already exists', 200);
                }
            }
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @param int $companyId
     * @param array $additionalSetting
     * @return BasicResponse|mixed
     */
    public function settingIinitializeAdditional(int $companyId, array $additionalSetting)
    {
        $response = new BasicResponse();

        try {
            setting()->setConstraint(function($query, $insert) use($companyId) {
                if ($insert) return;

                $query->where([
                    'company_id'=> $companyId
                ]);
            });

            $setting = setting()->all();

            $additionalSetting = new Collection(Common::removeExistingKeyOfSetting($setting, $additionalSetting));

            if ($additionalSetting->count() > 0) {
                setting()->setExtraColumns([
                    'company_id' => $companyId
                ]);

                setting($additionalSetting)
                    ->save();
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional setting was added', 200);

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @param Collection $companies
     * @param array $additionalSetting
     * @return BasicResponse|mixed
     */
    public function settingInitializeAdditionalAll(Collection $companies, array $additionalSetting)
    {
        $response = new BasicResponse();

        try {
            foreach ($companies as $company) {
                $companyId = $company->id;

                setting()->setConstraint(function($query, $insert) use($companyId) {
                    if ($insert) return;

                    $query->where([
                        'company_id'=> $companyId
                    ]);
                });

                $setting = setting()->all();

                $additionalSetting = new Collection(Common::removeExistingKeyOfSetting($setting, $additionalSetting));

                if ($additionalSetting->count() > 0) {
                    setting()->setExtraColumns([
                        'company_id' => $company->id
                    ]);

                    setting($additionalSetting)
                        ->save();
                }

                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional setting was added', 200);
            }
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }
}
