<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(static function (string $class): void {
    $paths = [
        BASE_PATH . '/core/' . $class . '.php',
        BASE_PATH . '/app/Controllers/' . $class . '.php',
        BASE_PATH . '/app/Models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

require_once BASE_PATH . '/helpers/functions.php';
