<?php


use App\Core\Request;

function url(string $path = ''): string
{
    $baseUrl = Request::baseUrl();

    return $baseUrl . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));

    exit();
}

function flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): ?string
{
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $message = $_SESSION['flash'][$key];

    unset($_SESSION['flash'][$key]);

    return $message;
}

function success(string $message): void
{
    flash('success', $message);
}

function error(string $message): void
{
    flash('error', $message);
}

function isAuthenticated(): bool
{
    return isset($_SESSION['user_id']);
}


function requireAuth(): void
{
    if (!isAuthenticated()) {

        error('Please login first.');

        redirect('login');
    }
}

function guestOnly(): void
{
    if (isAuthenticated()) {

        redirect('dashboard');
    }
}

