<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filteradmin'   => \App\Filters\FilterAdmin::class,
        'filteruser'    => \App\Filters\FilterUser::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            'filteradmin' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Store', 'Store/*',
                    'Belanja', 'Belanja/*',
                ]
            ],
            'filteruser' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Store', 'Store/*',
                    'Belanja', 'Belanja/*',
                ]
            ]
        ],
        'after' => [
            'toolbar',
            'filteradmin' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Produk', 'Produk/*',
                    'Kategori', 'Kategori/*',
                    'Satuan', 'Satuan/*',
                    'Warna', 'Warna/*',
                    'User', 'User/*',
                    'Rekening', 'Rekening/*',
                    'BarangMasuk', 'BarangMasuk/*',
                    'BarangKeluar', 'BarangKeluar/*',
                    'Board', 'Board/*',
                    'Setting', 'Setting/*',
                    'Pesanan', 'Pesanan/*',
                    'Laporan', 'Laporan/*',
                ]
            ],
            'filteruser' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Pengguna', 'Pengguna/*',
                    'Store', 'Store/*',
                    'Belanja', 'Belanja/*',
                ]
            ]
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
