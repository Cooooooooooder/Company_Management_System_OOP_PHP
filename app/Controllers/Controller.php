<?php

declare(strict_types=1);

namespace App\Controllers;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        require BASE_PATH . '/views/layouts/header.php';

        require BASE_PATH . '/views/layouts/navbar.php';

        require BASE_PATH . '/views/' . $view . '.php';

        require BASE_PATH . '/views/layouts/footer.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit();
    }
}