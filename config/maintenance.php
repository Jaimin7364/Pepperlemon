<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Status
    |--------------------------------------------------------------------------
    | Set to true to activate Maintenance Mode.
    | Set to false to deactivate and make the site live again.
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Maintenance Display Details
    |--------------------------------------------------------------------------
    */
    'title' => 'Under Maintenance',
    'message' => 'Pepperlemon is currently undergoing scheduled maintenance & improvements. We will be back online shortly!',
    'estimated_time' => 'A few minutes',

    /*
    |--------------------------------------------------------------------------
    | Secret Bypass Key
    |--------------------------------------------------------------------------
    | You can still access the website during maintenance mode by visiting:
    | yoursite.com?bypass=pepperlemon2026
    */
    'bypass_secret' => 'pepperlemon2026',

    /*
    |--------------------------------------------------------------------------
    | Allowed IP Addresses (Optional)
    |--------------------------------------------------------------------------
    */
    'allowed_ips' => [
        // '127.0.0.1',
    ],
];
