<?php

use App\Domains\Commons\Setting as SettingDomain;

return [
    'providers' => [
        SettingDomain\Contracts\SettingServiceInterface::class => SettingDomain\SettingService::class
    ]
];
