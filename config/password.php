<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Password Validation Rules
    |--------------------------------------------------------------------------
    |
    | These rules will be used when validating passwords throughout the
    | application. You can customize these rules based on your security
    | requirements.
    |
    */

    'defaults' => [
        'min' => 8,
        'letters' => false,
        'mixedCase' => false,
        'numbers' => false,
        'symbols' => false,
        'uncompromised' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Rules by Role
    |--------------------------------------------------------------------------
    |
    | Different password requirements for different user roles
    |
    */

    'roles' => [
        'admin' => [
            'min' => 12,
            'letters' => true,
            'mixedCase' => true,
            'numbers' => true,
            'symbols' => true,
            'uncompromised' => true,
        ],
        'librarian' => [
            'min' => 10,
            'letters' => true,
            'mixedCase' => true,
            'numbers' => true,
            'symbols' => false,
            'uncompromised' => true,
        ],
        'member' => [
            'min' => 8,
            'letters' => true,
            'mixedCase' => false,
            'numbers' => false,
            'symbols' => false,
            'uncompromised' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password History
    |--------------------------------------------------------------------------
    |
    | Prevent users from reusing recent passwords
    |
    */

    'history' => [
        'enabled' => false,
        'remember_count' => 5, // Remember last 5 passwords
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Expiry
    |--------------------------------------------------------------------------
    |
    | Force password changes after a certain period
    |
    */

    'expiry' => [
        'enabled' => false,
        'days' => 90,
        'warning_days' => 7, // Warn user X days before expiry
    ],
];