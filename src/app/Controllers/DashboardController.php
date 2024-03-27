<?php

declare(strict_types=1);

namespace App\Controllers;

class DashboardController extends Controller
{

    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $this->render('admin.twig');
    }
}
