<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'global'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        // MySQLのトランザクションレベルを、デッドロック対策としてREPEATABLE READからREAD COMMITTEDに変更。
        // （MySQL以外のDBのデフォルトに相当。ギャップロックが発生しなくなる代わりに、存在しないレコードはロックされなくなるので注意。）

        'global' => [
            'driver' => env('DB_GLOBAL_DRIVER', 'mysql'),
            'host' => env('DB_GLOBAL_HOST', '127.0.0.1'),
            'port' => env('DB_GLOBAL_PORT', '3306'),
            'database' => env('DB_GLOBAL_DATABASE', 'game_global_db'),
            'username' => env('DB_GLOBAL_USERNAME', 'game_usr'),
            'password' => env('DB_GLOBAL_PASSWORD', 'game001'),
            'unix_socket' => env('DB_GLOBAL_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_bin',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'timezone' => '+00:00',
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::MYSQL_ATTR_INIT_COMMAND => 'set session transaction isolation level read committed',
            ]) : [],
        ],

        'master' => [
            'driver' => env('DB_MASTER_DRIVER', 'mysql'),
            'host' => env('DB_MASTER_HOST', '127.0.0.1'),
            'port' => env('DB_MASTER_PORT', '3306'),
            'database' => env('DB_MASTER_DATABASE', 'game_master_db'),
            'username' => env('DB_MASTER_USERNAME', 'game_usr'),
            'password' => env('DB_MASTER_PASSWORD', 'game001'),
            'unix_socket' => env('DB_MASTER_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_bin',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'timezone' => '+00:00',
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::MYSQL_ATTR_INIT_COMMAND => 'set session transaction isolation level read committed',
            ]) : [],
        ],

        'admin' => [
            'driver' => env('DB_ADMIN_DRIVER', 'mysql'),
            'host' => env('DB_ADMIN_HOST', '127.0.0.1'),
            'port' => env('DB_ADMIN_PORT', '3306'),
            'database' => env('DB_ADMIN_DATABASE', 'game_admin_db'),
            'username' => env('DB_ADMIN_USERNAME', 'game_usr'),
            'password' => env('DB_ADMIN_PASSWORD', 'game001'),
            'unix_socket' => env('DB_ADMIN_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_bin',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'timezone' => '+00:00',
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::MYSQL_ATTR_INIT_COMMAND => 'set session transaction isolation level read committed',
            ]) : [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            // 'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'host' => env('REDIS_DEFAULT_HOST', '127.0.0.1'),
            'password' => env('REDIS_DEFAULT_PASSWORD', null),
            'port' => env('REDIS_DEFAULT_PORT', 6379),
            'database' => env('REDIS_DEFAULT_DB', 1),
        ],

        'cache' => [
            'host' => env('REDIS_CACHE_HOST', '127.0.0.1'),
            'password' => env('REDIS_CACHE_PASSWORD', null),
            'port' => env('REDIS_CACHE_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 2),
        ],

        'session' => [
            'host' => env('REDIS_SESSION_HOST', '127.0.0.1'),
            'password' => env('REDIS_SESSION_PASSWORD', null),
            'port' => env('REDIS_SESSION_PORT', 6379),
            'database' => env('REDIS_SESSION_DB', 3),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 履歴系データ保持期間
    |--------------------------------------------------------------------------
    |
    | 履歴系データの保持期間。履歴系データは月単位のパーティションを切る想定なので、
    | 期間が過ぎたものは順次パーティションをDROPする。
    | （消さない場合は以下に定義しない。）
    |
    */

    'expire_logs_months' => [
        [
            'model' => \App\Models\Globals\UserGift::class,
            'expire' => env('EXPIRE_LOGS_MONTHS_USER_GIFT', 12),
        ],
        [
            'model' => \App\Models\Globals\Questlog::class,
            'expire' => env('EXPIRE_LOGS_MONTHS_QUESTLOG', 6),
        ],
        [
            'model' => \App\Models\Globals\Gachalog::class,
            'expire' => env('EXPIRE_LOGS_MONTHS_GACHALOG', 12),
        ],
        [
            'model' => \App\Models\Globals\GachalogDrop::class,
            'expire' => env('EXPIRE_LOGS_MONTHS_GACHALOG', 12),
        ],
    ],

];
