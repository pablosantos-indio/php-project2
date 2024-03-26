<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DB\DBConnection;
use App\Models\JobPostings;
use PDO;

class HomeController extends Controller
{

    public function index(): void
    {
        //Connect to database
        $db = (new DBConnection())->getConnection();
        $jobPostings = [];

        //Select all data from tabel JobPostings
        $stmt = $db->query('SELECT * FROM JobPostings');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, JobPostings::class);

        $jobPostings = $stmt->fetchAll();

        // require VIEWS_PATH . 'home.php';
        $this->render('home.twig', ['jobPostings' => $jobPostings]);
    }
}
