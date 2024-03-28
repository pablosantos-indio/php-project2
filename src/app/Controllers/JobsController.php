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

        // Send the email with the resume attached
        $this->sendEmail($fields['name'], $fields['email'], $fields['resume']);

        $_SESSION['message'] = 'Application sent successfully';

        header('Location: /');
    }

    private function sendEmail(string $CandidateName, string $CandidateEmail, string $CandidateResume): bool
    {
        // Define email information
        $to = 'chalitamichael@gmail.com';
        $from = $CandidateEmail;
        $name = $CandidateName;
        $subject = 'New Job Application';
        $message = "
        <html>
        <head>
            <title>New Job Application</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 16px;
                    line-height: 1.6;
                }
                h1 {
                    font-weight: bold;
                    font-size: 24px;
                    color: #333;
                }
                p {
                    margin-bottom: 10px;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
                a:hover {
                    color: #0056b3;
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <h1>You received an application from PHP Job Board</h1>
            <p><strong>Job Title:</strong> Aurderhar, Adams and Iremolay</p>
            <p><strong>Applicant Name:</strong> $CandidateName</p>
            <p><strong>Applicant Email:</strong> $CandidateEmail</p>";


        // Process the uploaded file
        $resumePath = $this->processUploadedFile();

        $fileName = $_FILES['resume']['name'];

        // Check if the resume file exists
        if (file_exists($resumePath)) {
            // Add a link to download the resume
            $message .= "Applicant Resume: <a href='http://localhost/uploads/{$fileName}'>Download Resume</a>";
        } else {
            $message .= "Applicant Resume: File not found";
        }

        // Define email headers
        $headers = "From: $name <$from>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($to, $subject, $message, $headers);
    }

    private function processUploadedFile(): ?string
    {
        // Check if file is uploaded
        if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $tmpFilePath = $_FILES['resume']['tmp_name']; // Caminho temporário do arquivo
        $fileName = $_FILES['resume']['name']; // Nome original do arquivo

        // Diretório de destino para salvar o arquivo
        $uploadDir = 'uploads/';

        // Caminho completo do arquivo de destino
        $destinationPath = $uploadDir . $fileName;

        // Move o arquivo temporário para o diretório de uploads
        move_uploaded_file($tmpFilePath, $destinationPath);

        return $destinationPath;
    }

}
