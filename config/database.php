<?php

return [

    'default' => 'mysql',
    'migrations' => 'migrations',
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],

        'seguro_auto_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SEGURO_AUTO_HOST'),
            'port' => env('DB_SEGURO_AUTO_PORT'),
            'database' => env('DB_SEGURO_AUTO_DATABASE'),
            'username' => env('DB_SEGURO_AUTO_USERNAME'),
            'password' => env('DB_SEGURO_AUTO_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'quiz_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_QUIZ_HOST'),
            'port' => env('DB_SWEET_QUIZ_PORT'),
            'database' => env('DB_SWEET_QUIZ_DATABASE'),
            'username' => env('DB_SWEET_QUIZ_USERNAME'),
            'password' => env('DB_SWEET_QUIZ_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'carsystem_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_CARSYSTEM_HOST'),
            'port' => env('DB_SWEET_CARSYSTEM_PORT'),
            'database' => env('DB_SWEET_CARSYSTEM_DATABASE'),
            'username' => env('DB_SWEET_CARSYSTEM_USERNAME'),
            'password' => env('DB_SWEET_CARSYSTEM_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'ead_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_EAD_HOST'),
            'port' => env('DB_SWEET_EAD_PORT'),
            'database' => env('DB_SWEET_EAD_DATABASE'),
            'username' => env('DB_SWEET_EAD_USERNAME'),
            'password' => env('DB_SWEET_EAD_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'greenpeace_oceanos_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_GREENPEACE_OCEANOS_HOST'),
            'port' => env('DB_SWEET_GREENPEACE_OCEANOS_PORT'),
            'database' => env('DB_SWEET_GREENPEACE_OCEANOS_DATABASE'),
            'username' => env('DB_SWEET_GREENPEACE_OCEANOS_USERNAME'),
            'password' => env('DB_SWEET_GREENPEACE_OCEANOS_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'alfacon_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_ALFACON_HOST'),
            'port' => env('DB_SWEET_ALFACON_PORT'),
            'database' => env('DB_SWEET_ALFACON_DATABASE'),
            'username' => env('DB_SWEET_ALFACON_USERNAME'),
            'password' => env('DB_SWEET_ALFACON_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'social_class_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_SOCIAL_CLASS_HOST'),
            'port' => env('DB_SWEET_SOCIAL_CLASS_PORT'),
            'database' => env('DB_SWEET_SOCIAL_CLASS_DATABASE'),
            'username' => env('DB_SWEET_SOCIAL_CLASS_USERNAME'),
            'password' => env('DB_SWEET_SOCIAL_CLASS_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'xmovecar_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_XMOVECAR_HOST'),
            'port' => env('DB_SWEET_XMOVECAR_PORT'),
            'database' => env('DB_SWEET_XMOVECAR_DATABASE'),
            'username' => env('DB_SWEET_XMOVECAR_USERNAME'),
            'password' => env('DB_SWEET_XMOVECAR_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'researches_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_RESEARCHES_HOST'),
            'port' => env('DB_SWEET_RESEARCHES_PORT'),
            'database' => env('DB_SWEET_RESEARCHES_DATABASE'),
            'username' => env('DB_SWEET_RESEARCHES_USERNAME'),
            'password' => env('DB_SWEET_RESEARCHES_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'infoproduto_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_SWEET_INFOPRODUTO_HOST'),
            'port' => env('DB_SWEET_INFOPRODUTO_PORT'),
            'database' => env('DB_SWEET_INFOPRODUTO_DATABASE'),
            'username' => env('DB_SWEET_INFOPRODUTO_USERNAME'),
            'password' => env('DB_SWEET_INFOPRODUTO_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],        
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_seguro_auto' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_quiz' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_carsystem' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_ead' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_greenpeace_oceanos' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_alfacon' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_social_class' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_researches' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_xmovecar' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'sqlite_infoproduto' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
    ],
    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '172.17.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],
];
