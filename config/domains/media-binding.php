<?php

use App\Domains\Media as MediaDomain;

return [
    'providers' => [
        MediaDomain\Contracts\MediaServiceInterface::class => MediaDomain\MediaService::class,
    ]
];