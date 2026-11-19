<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Pintu masuk aplikasi di Vercel.
 * Filesystem Vercel hanya-baca kecuali /tmp, jadi semua lokasi tulis
 * Laravel (storage, cache) dipindahkan ke /tmp.
 */
$tmp = '/tmp';

$folders = [
    $tmp . '/storage/app/public',
    $tmp . '/storage/framework/cache/data',
    $tmp . '/storage/framework/sessions',
    $tmp . '/storage/framework/views',
    $tmp . '/storage/logs',
    $tmp . '/bootstrap/cache',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

$settings = [
    'LARAVEL_STORAGE_PATH' => $tmp . '/storage',
    'APP_CONFIG_CACHE'     => $tmp . '/bootstrap/cache/config.php',
    'APP_EVENTS_CACHE'     => $tmp . '/bootstrap/cache/events.php',
    'APP_PACKAGES_CACHE'   => $tmp . '/bootstrap/cache/packages.php',
    'APP_ROUTES_CACHE'     => $tmp . '/bootstrap/cache/routes.php',
    'APP_SERVICES_CACHE'   => $tmp . '/bootstrap/cache/services.php',
];

foreach ($settings as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

define('LARAVEL_START', microtime(true));

// Daftarkan autoloader Composer
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel dan tangani permintaan
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());