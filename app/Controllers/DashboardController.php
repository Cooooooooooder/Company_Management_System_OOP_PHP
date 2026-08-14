<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\DashboardModel;

class DashboardController extends Controller
{
    private DashboardModel $dashboardModel;


    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }


    public function index(): void
    {
        $statistics = $this->dashboardModel->statistics();

        $this->view('dashboard/index', [
            'statistics' => $statistics
        ]);
    }
}