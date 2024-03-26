<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\JobPostings;

class HomeController extends Controller
{

    public function index(): void
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Find all JobPostings with pagination
        $paginationData = JobPostings::findAll($page);

        // Check if the requested page exceeds the total number of pages
        if ($page > $paginationData['total_pages']) {
            // Redirect to the last page
            header('Location: /?page=' . $paginationData['total_pages']);
            exit;
        }

        // Render the template with pagination data
        $this->render('home.twig', ['paginationData' => $paginationData]);
    }

}
