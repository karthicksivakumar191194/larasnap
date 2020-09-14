<?php

/**
 * The 'default avatar' should we uploaded to the proper path.
 *
 */

return [
    /*
    |--------------------------------------------------------------------------
    | LaraSnap Admin Installation config
    |--------------------------------------------------------------------------
    |
    | Here you can specify how the 'php artisan larasnap:admin-install' command should work. | Don't modify these options when running |first time.
    |
    */
    'admin_install' => [
        'publish_migrations_seeds' 	            => true, 
        'publish_auth_login_controller' 	    => true, 
        'publish_auth_registeration_controller' => true, 
        'publish_config' 	 => true,
        'publish_views' 	 => true,
        'publish_assets'     => true, 
        'add_routes'         => true,
    ],
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    |
    | Here you can specify general configs.
    |
    */
    'general' => [
        'dashboard_route_name' => 'dashboard', //mandatory - update the dashboard route name correctly.
    ],
    'menu' => [
        'default_icon' => 'fa-list', //font-awesome icon
        'default_sidebar_menu' => 'admin', //name of the menu created on the menu management
    ],
	'user_model_namespace' => 'App\Models\User', //if you use laravel below 8 modify it to 'App\User'
    /*
    |--------------------------------------------------------------------------
    | UI Generic Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify UI settings.
    |
    */
    'admin_sidebar' => [
        'background' => 'linear-gradient(to right, #000529 0%,#002055 0%,#005db5 67%,#0074d9 100%)',
    ],
    'breadcrumb' => true,
    'theme2' => false, //secondary theme for dashboard
    /*
    |--------------------------------------------------------------------------
    | Upload config
    |--------------------------------------------------------------------------
    |
    | Here you can specify upload configs.
    |
    */
    'uploads' => [
        'user' => [
            'path' => 'public/upload/user/profile',
            'default_avatar' => 'default.jpg' //default user avatar if no profile picture is uploaded
        ],
        'site_settings' => [
            'path' => 'public/upload/site_settings',
        ]
    ],    /*
    |--------------------------------------------------------------------------
    | Site Setting config
    |--------------------------------------------------------------------------
    |
    */
    'settings' => [
        'date_format' => [
            'd/m/Y',
            'd.m.Y',
            'd-m-Y',
            'M d, Y',
            'dS M, Y',
            'l M d, Y',
            'l dS M, Y',
        ],
        'date_time_format' => [
            'd/m/Y  h:i A',
            'd.m.Y  h:i A',
            'd-m-Y  h:i A',
            'M d, Y  h:i A',
            'dS M, Y  h:i A',
            'l M d, Y h:i A',
            'l dS M, Y h:i A',
        ],
        'time_format' => [
            'h:i:s A',
            'h:i A',
            'H:i:s',
            'H:i',
        ]
    ],
    /* Add the list of setting 'name' */
    'site_settings' => [
        'site_name',
        'site_logo',
        'admin_email',
        'date_format',
        'date_time_format',
        'time_format',
        'entries_per_page',
        'default_user_role'
    ],
    //add the setting 'name' which are related to attachements(image, video,...)
    'site_settings_attachemnt' => [
        'site_logo',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module List Page config
    |--------------------------------------------------------------------------
    |
    | Here you can specify module list page - sort by, filter, search configs.
    |
    */
    'module_list' => [
        'user' => [
            'sort_by' => [
                [
                    'label' => 'Latest First',
                    'value' => 'latestfirst'
                ],
                [
                    'label' => 'Oldest First',
                    'value' => 'oldestfirst'
                ]
            ],
            'filter' => [
                'role'   => true,
            ],
            'status' => [
                [
                    'label' => 'All Users',
                    'value' => 'all'
                ],
                [
                    'label' => 'Active Users',
                    'value' => '1'
                ],
                [
                    'label' => 'InActive Users',
                    'value' => '0'
                ]
            ],
            'bulk_actions' => [
                [
                    'label' => 'Bulk Delete',
                    'value' => 'delete'
                ]
            ],
            'search' => true,
            'maximum_role_selection' => 0, //set 0 if user can have multiple roles.
            'zip_code_size' => 5,
        ],
        'role' => [
            'search' => true,
            'maximum_permission_selection' => 0, //set 0 if user can have multiple roles.
            'maximum_screen_selection' => 0, //set 0 if user can have multiple roles.
        ],
        'permission' => [
            'search' => true,
        ],
        'screen' => [
            'search' => true,
            'maximum_role_selection' => 0, //set 0 if screen can have multiple roles.
        ],
        'module' => [
            'search' => true,
        ],
        'menu' => [
            'search' => true,
        ],
        'category_parent' => [
            'search' => true,
        ],
        'category' => [
            'search' => true,
        ],
    ],
	/*
    |--------------------------------------------------------------------------
    | Admin Dashboard config
    |--------------------------------------------------------------------------
    |
    */
    'superadmin_role' => '', //'Name'of the SuperAdmin Role. Users added to this role can be edited/assign_role/deleted only by the other users in the same role.
    'restrict' => [
        'role' => [], 
        'menu' => [], 
    ], //Restricted datas can't be edited/deleted from backend.
];