<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class DashboardController extends Controller
{

    public function index(): void
    {
        $this->render('dashboard.twig');
    }
}
