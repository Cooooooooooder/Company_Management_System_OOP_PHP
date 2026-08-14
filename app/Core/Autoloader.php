<?php

declare(strict_types=1);

namespace App\Core;

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function (string $class): void {

            $prefix = 'App\\';

            if (!str_starts_with($class, $prefix)) {
                return;
            }

            $relativeClass = substr($class, strlen($prefix));

            $file = BASE_PATH . '/app/' .
                str_replace('\\', '/', $relativeClass) .
                '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}