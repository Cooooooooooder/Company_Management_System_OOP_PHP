<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;

use mysqli;

class Model
{
    protected mysqli $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}