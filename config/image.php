<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'company_logo' => [
        'category' => 'image',
        'extension' => 'jpg|jpeg|png',
        'maximum_size' => 1048576,
        'minimum_size' => 512000,
        'dimension' => [
            'small' => [
                'width' => 250,
                'height' => 250
            ],
            'medium' => [
                'width' => 375,
                'height' => 375
            ],
            'high' => [
                'width' => 500,
                'height' => 500
            ]
        ]
    ],
    'profile_image' => [
        'category' => 'image',
        'extension' => 'jpg|jpeg|png',
        'maximum_size' => 1048576,
        'minimum_size' => 512000,
        'dimension' => [
            'small' => [
                'width' => 250,
                'height' => 250
            ],
            'medium' => [
                'width' => 375,
                'height' => 375
            ],
            'high' => [
                'width' => 500,
                'height' => 500
            ]
        ]
    ],
    'employee_photo' => [
        'category' => 'image',
        'extension' => 'jpg|jpeg',
        'maximum_size' => 2097152,
        'minimum_size' => 1048576,
        'dimension' => [
            'small' => [
                'width' => 57,
                'height' => 85
            ],
            'medium' => [
                'width' => 85,
                'height' => 113
            ],
            'high' => [
                'width' => 113,
                'height' => 170
            ]
        ]
    ],
    'project_document' => [
        'category' => 'document',
        'extension' => 'pdf|doc|xlx|docx|xlxs',
        'maximum_size' => null,
        'minimum_size' => null,
        'dimension' => null
    ],
    'project_addendum_document' => [
        'category' => 'document',
        'extension' => 'pdf|doc|xlx|docx|xlxs',
        'maximum_size' => null,
        'minimum_size' => null,
        'dimension' => null
    ]
];
