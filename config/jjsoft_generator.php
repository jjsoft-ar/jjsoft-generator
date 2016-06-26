<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration'         => app_path('Database/Migrations/'),

        'model'             => app_path('Entities/'),

        'datatables'        => app_path('DataTables/'),

        'repository'        => app_path('Repositories/'),

        'routes'            => app_path('Http/routes.php'),

        'api_routes'        => app_path('Http/api_routes.php'),

        'request'           => app_path('Http/Requests/'),

        'api_request'       => app_path('Http/Requests/API/'),

        'controller'        => app_path('Http/Controllers/'),

        'api_controller'    => app_path('Http/Controllers/API/'),

        'test_trait'        => app_path('Tests/traits/'),

        'repository_test'   => app_path('Tests/'),

        'api_test'          => app_path('Tests/'),

        'views'             => app_path('Resources/views/'),

        'schema_files'      => app_path('Resources/model_schemas/'),

        'templates_dir'     => base_path('packages/jjsoft/jjsoft-generator/templates/'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [

        'model'             => 'App\Models',

        'datatables'        => 'App\DataTables',

        'repository'        => 'App\Repositories',

        'controller'        => 'App\Http\Controllers',

        'api_controller'    => 'App\Http\Controllers\API',

        'request'           => 'App\Http\Requests',

        'api_request'       => 'App\Http\Requests\API',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'templates'         => 'gentelella-templates',

    /*
    |--------------------------------------------------------------------------
    | Model extend class
    |--------------------------------------------------------------------------
    |
    */

    'model_extend_class' => 'Eloquent',

    /*
    |--------------------------------------------------------------------------
    | API routes prefix & version
    |--------------------------------------------------------------------------
    |
    */

    'api_prefix'  => 'api',

    'api_version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [

        'softDelete' => false,

        'tables_searchable_default' => false,
    ],

    /*
     |--------------------------------------------------------------------------
     | Prefixes
     |--------------------------------------------------------------------------
     |
     */

    'prefixes' => [
        
        'route' => '',  // using admin will create route('admin.?.index') type routes

        'path' => '',

        'view' => '',  // using backend will create return view('backend.?.index') type the backend views directory

        'public' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Add-Ons
    |--------------------------------------------------------------------------
    |
    */

    'add_on' => [

        'swagger'       => false,

        'tests'         => true,

        'datatables'    => true,

        'menu'          => [

            'enabled'       => false,

            'menu_file'     => 'layouts/menu.blade.php',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timestamp Fields
    |--------------------------------------------------------------------------
    |
    */

    'timestamps' => [

        'enabled'       => false,

        'created_at'    => 'created_at',

        'updated_at'    => 'updated_at',

        'deleted_at'    => 'deleted_at',
    ],

];
