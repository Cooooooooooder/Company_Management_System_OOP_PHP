<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home', [
            'title' => 'Home'
        ]);
    }

    public function about(): void
    {
        $this->view('about', [
            'title' => 'About'
        ]);
    }

    public function contact(): void
    {
        $this->view('contact', [
            'title' => 'Contact'
        ]);
    }
}