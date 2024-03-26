<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\JobPostings;

class JobsController extends Controller
{

    public function index($id): void
    {
        //Find specific JobPostings
        $jobPostings = JobPostings::find($id);

        $this->render('jobs.twig', ['jobPostings' => $jobPostings]);
    }

    public function apply(): void
    {
        // validate the fields
        $fields = JobPostings::validate($_POST);

        // if fields is false, redirect back to the previous page with an error parameter
        if (!$fields) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $this->sendEmail($fields['name'], $fields['email'], $fields['resume']);

        header('Location: /');
    }

    private function sendEmail(string $CandidateName, string $CandidateEmail, string $CandidateResume): bool
    {
        // Define email information
        $to = 'chalitamichael@gmail.com';
        $from = $CandidateEmail;
        $name = $CandidateName;
        $subject = 'New Job Application';
        $message = "You received an application from PHP Job Board";
        $message .= "Job Title: Aurderhar, Adams and Iremolay\n";
        $message .= "Applicant Name: $CandidateName\n";
        $message .= "Applicant Email: $CandidateEmail\n";

        // Path to the resume file
        $resumePath = '/path/to/resume.pdf';

        // Check if the resume file exists
        if (file_exists($resumePath)) {
            // Add a link to download the resume
            $message .= "Applicant Resume: <a href='http://example.com/path/to/resume.pdf'>Download Resume</a>";
        } else {
            $message .= "Applicant Resume: File not found";
        }

        // Define email headers
        $headers = "From: $name <$from>\r\n";

        return mail($to, $subject, $message, $headers);
    }
}
