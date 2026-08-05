<?php


class Router
{
    private array $routes = [];

    public function get(string $uri, callable $callback): void
    {
        $this->routes['GET'][$uri] = $callback;
    }

    public function post(string $uri, callable $callback): void
    {
        $this->routes['POST'][$uri] = $callback;
    }

    public function dispatch(string $method, string $uri): void
{
    $uri = parse_url($uri, PHP_URL_PATH);

    $basePath = '/Company%20Management%20System%20(OOP%20PHP)';

    if (str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath));
    }

    if ($uri === '') {
        $uri = '/';
    }

    if (isset($this->routes[$method][$uri])) {
        call_user_func($this->routes[$method][$uri]);
        return;
    }

    http_response_code(404);

    echo "<h1>404 | Page Not Found</h1>";
}
}
