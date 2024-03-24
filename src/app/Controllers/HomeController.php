<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class HomeController extends Controller
{

    public function index(): void
    {
        $this->render('home.twig');
    }
}
