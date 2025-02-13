<?php

return [

    'models' => [

        /*
         * Model used to retrieve permissions.
         * Must implement `Spatie\Permission\Contracts\Permission`.
         */
        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * Model used to retrieve roles.
         * Must implement `Spatie\Permission\Contracts\Role`.
         */
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [

        /*
         * Table to store roles.
         */
        'roles' => 'roles',

        /*
         * Table to store permissions.
         */
        'permissions' => 'permissions',

        /*
         * Table to store the relationship between models and permissions.
         */
        'model_has_permissions' => 'model_has_permissions',

        /*
         * Table to store the relationship between models and roles.
         */
        'model_has_roles' => 'model_has_roles',

        /*
         * Table to store the relationship between roles and permissions.
         */
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if your primary key uses a different name.
         */
        'model_morph_key' => 'model_id',
    ],

    /*
     * Set this to `true` to register the permission checking method in Laravel's Gate.
     */
    'register_permission_check_method' => true,

    /*
     * Enables team support.
     * If enabled, you must add `team_id` column to `roles`, `model_has_roles`, and `model_has_permissions` tables.
     */
    'teams' => false,

    /*
     * Class responsible for resolving team IDs for permission checks.
     */
    'team_resolver' => \Spatie\Permission\DefaultTeamResolver::class,

    /*
     * Passport Client Credentials Grant support.
     */
    'use_passport_client_credentials' => false,

    /*
     * Show the required permission in exception messages.
     */
    'display_permission_in_exception' => false,

    /*
     * Show the required role in exception messages.
     */
    'display_role_in_exception' => false,

    /*
     * Enable wildcard permissions (e.g., `user.*`).
     */
    'enable_wildcard_permission' => false,

    /* 
     * Available authentication guards for permissions and roles.
     */
    'guards' => [
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],

    /*
     * Default authentication guard for permissions and roles.
     */
    'default_guard' => 'sanctum', // 🔹 Added this

    /* 
     * Cache settings to improve performance.
     */
    'cache' => [

        /*
         * Cache duration (default: 24 hours).
         */
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * Cache key name.
         */
        'key' => 'spatie.permission.cache',

        /*
         * Cache driver (default: 'default' from cache.php).
         */
        'store' => 'default',
    ],
];
