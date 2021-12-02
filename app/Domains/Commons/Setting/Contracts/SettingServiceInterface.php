<?php

namespace App\Domains\Commons\Setting\Contracts;
use Illuminate\Support\Collection;

/**
 * Interface SettingServiceInterface.
 */
interface SettingServiceInterface
{
    public function __construct();

    /**
     * @param int $companyId
     * @return mixed
     */
    public function settingInitializeDefault(int $companyId);

    /**
     * @param Collection $companies
     * @return mixed
     */
    public function settingInitializeDefaultAll(Collection $companies);

    /**
     * @param int $companyId
     * @param array $additionalSetting
     * @return mixed
     */
    public function settingIinitializeAdditional(int $companyId, array $additionalSetting);

    /**
     * @param Collection $companies
     * @param array $additionalSetting
     * @return mixed
     */
    public function settingInitializeAdditionalAll(Collection $companies, array $additionalSetting);
}
