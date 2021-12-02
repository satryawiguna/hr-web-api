<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Settings Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default settings store that gets used while
    | using this settings library.
    |
    | Supported: "json", "database"
    |
    */
    'store' => 'database',

    /*
    |--------------------------------------------------------------------------
    | JSON Store
    |--------------------------------------------------------------------------
    |
    | If the store is set to "json", settings are stored in the defined
    | file path in JSON format. Use full path to file.
    |
    */
    'path' => storage_path() . '/settings.json',

    /*
    |--------------------------------------------------------------------------
    | Database Store
    |--------------------------------------------------------------------------
    |
    | The settings are stored in the defined file path in JSON format.
    | Use full path to JSON file.
    |
    */
    // If set to null, the default connection will be used.
    'connection' => null,
    // Name of the table used.
    'table' => 'settings',
    // If you want to use custom column names in database store you could
    // set them in this configuration
    'companyIdColumn' => 'company_id',
    'keyColumn' => 'key',
    'valueColumn' => 'value',

    'default' => [
        'COMPANY_NAME' => '',
        'EMAIL' => '',

        'CHECK_IN_MODE' => 'default', //by default & by area
        'BY_DEFAULT_CHECK_IN' => '08:00:00', //by 24 hours
        'BY_DEFAULT_CHECK_IN_TOLERANCE_BEFORE' => '00:00:00', //by 24 hours
        'BY_DEFAULT_CHECK_IN_TOLERANCE_AFTER' => '00:10:00', //by 24 hours
        'BY_AREA_CHECK_IN' => '',
        'BY_AREA_CHECK_IN_TOLERANCE_BEFORE' => '',
        'BY_AREA_CHECK_IN_TOLERANCE_AFTER' => '',

        'CHECK_OUT_MODE' => 'default', //by default & by area
        'BY_DEFAULT_CHECK_OUT' => '17:00:00', //by 24 hours
        'BY_DEFAULT_CHECK_OUT_TOLERANCE_BEFORE' => '00:10:00', //by 24 hours
        'BY_DEFAULT_CHECK_OUT_TOLERANCE_AFTER' => '00:00:00', //by 24 hours
        'BY_AREA_CHECK_OUT' => '',
        'BY_AREA_CHECK_OUT_TOLERANCE_BEFORE' => '',
        'BY_AREA_CHECK_OUT_TOLERANCE_AFTER' => '',

        'OVERTIME_MODE' => 'default', //by default & by area
        'BY_DEFAULT_OVERTIME' => '18:00:00', //by 24 hours
        'BY_DEFAULT_OVERTIME_TOLERANCE_BEFORE' => '00:00:00', //by 24 hours
        'BY_DEFAULT_OVERTIME_TOLERANCE_AFTER' => '00:00:00', //by 24 hours
        'BY_AREA_OVERTIME' => '',
        'BY_AREA_OVERTIME_TOLERANCE_BEFORE' => '',
        'BY_AREA_OVERTIME_TOLERANCE_AFTER' => '',
    ]
];
