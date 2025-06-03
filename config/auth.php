<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Here you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

    /*
    |--------------------------------------------------------------------------
    | Library Management System Specific Settings
    |--------------------------------------------------------------------------
    |
    | Custom authentication settings for the library management system
    |
    */

    'library' => [
        /*
        |--------------------------------------------------------------------------
        | Session Settings
        |--------------------------------------------------------------------------
        */
        'session_lifetime' => 120, // minutes
        'session_expire_on_close' => false,
        
        /*
        |--------------------------------------------------------------------------
        | Role-based Access Control
        |--------------------------------------------------------------------------
        */
        'roles' => [
            'admin' => [
                'display_name' => 'Administrator',
                'permissions' => ['*'], // All permissions
                'description' => 'Full system access and user management'
            ],
            'librarian' => [
                'display_name' => 'Librarian',
                'permissions' => [
                    'books.manage',
                    'authors.manage', 
                    'categories.manage',
                    'users.manage',
                    'borrowings.manage',
                    'reservations.manage',
                    'reports.view'
                ],
                'description' => 'Manage books, users, and library operations'
            ],
            'member' => [
                'display_name' => 'Member',
                'permissions' => [
                    'books.view',
                    'authors.view',
                    'categories.view',
                    'profile.manage',
                    'borrowings.view_own',
                    'reservations.manage_own'
                ],
                'description' => 'Browse and borrow books'
            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | User Status Settings
        |--------------------------------------------------------------------------
        */
        'statuses' => [
            'active' => [
                'display_name' => 'Active',
                'can_login' => true,
                'can_borrow' => true,
                'description' => 'Account is active and in good standing'
            ],
            'inactive' => [
                'display_name' => 'Inactive', 
                'can_login' => false,
                'can_borrow' => false,
                'description' => 'Account is temporarily disabled'
            ],
            'suspended' => [
                'display_name' => 'Suspended',
                'can_login' => false,
                'can_borrow' => false,
                'description' => 'Account suspended due to violations'
            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Membership Settings
        |--------------------------------------------------------------------------
        */
        'membership' => [
            'id_prefix' => 'LIB',
            'default_expiry_period' => 365, // days
            'renewal_notice_days' => 30,
            'max_borrowing_limit' => 5,
            'max_fine_threshold' => 50.00,
            'fine_rate_per_day' => 1.00
        ],

        /*
        |--------------------------------------------------------------------------
        | Security Settings
        |--------------------------------------------------------------------------
        */
        'security' => [
            'max_login_attempts' => 5,
            'lockout_duration' => 15, // minutes
            'password_min_length' => 8,
            'password_requires_uppercase' => false,
            'password_requires_lowercase' => false,
            'password_requires_numbers' => false,
            'password_requires_symbols' => false,
            'force_password_change_days' => null, // null = never
        ],

        /*
        |--------------------------------------------------------------------------
        | Registration Settings
        |--------------------------------------------------------------------------
        */
        'registration' => [
            'enabled' => true,
            'default_role' => 'member',
            'default_status' => 'active',
            'email_verification_required' => false,
            'admin_approval_required' => false,
            'allowed_domains' => [], // empty = all domains allowed
            'minimum_age' => 13,
        ],

        /*
        |--------------------------------------------------------------------------
        | Account Recovery Settings
        |--------------------------------------------------------------------------
        */
        'recovery' => [
            'password_reset_enabled' => true,
            'password_reset_token_lifetime' => 60, // minutes
            'account_recovery_methods' => ['email'],
        ]
    ]
];