<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    public static function baseUrl(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

        $baseUrl = str_replace(
            '/public/index.php',
            '', $scriptName
        );

        return rtrim($baseUrl, '/');
    }
}

