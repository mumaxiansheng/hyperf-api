<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    /**
     * 测试库
     */
    'test' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'read' => [
            'host' => ['127.0.0.1'],
        ],
        'write' => [
            'host' => ['127.0.0.1'],
        ],
        'sticky' => true,
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_TEST_DATABASE', ''),
        'username' => env('DB_TEST_USERNAME', ''),
        'password' => env('DB_TEST_PASSWORD', ''),
        'charset' => env('DB_TEST_CHARSET', 'utf8'),
        'collation' => env('DB_TEST_COLLATION', 'utf8_unicode_ci'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float)env('DB_MAX_IDLE_TIME', 60),
        ],
    ],
    /**
     * 基础库
     */
    'base' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'read' => [
            'host' => ['127.0.0.1'],
        ],
        'write' => [
            'host' => ['127.0.0.1'],
        ],
        'sticky' => true,
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_BASE_DATABASE', ''),
        'username' => env('DB_BASE_USERNAME', ''),
        'password' => env('DB_BASE_PASSWORD', ''),
        'charset' => env('DB_BASE_CHARSET', 'utf8'),
        'collation' => env('DB_BASE_COLLATION', 'utf8_unicode_ci'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float)env('DB_MAX_IDLE_TIME', 60),
        ],
    ],
    /**
     * 用户库
     */
    'user' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'read' => [
            'host' => ['127.0.0.1'],
        ],
        'write' => [
            'host' => ['127.0.0.1'],
        ],
        'sticky' => true,
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_USER_DATABASE', ''),
        'username' => env('DB_USER_USERNAME', ''),
        'password' => env('DB_USER_PASSWORD', ''),
        'charset' => env('DB_USER_CHARSET', 'utf8'),
        'collation' => env('DB_USER_COLLATION', 'utf8_unicode_ci'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float)env('DB_MAX_IDLE_TIME', 60),
        ],
    ],
];
