<?php

declare(strict_types=1);

namespace App\Controllers;

use PDOException;
use App\DB\DBConnection;
use DateTime;

class DataController extends Controller
{
    public function fetchApiData()
    {
        $apiUrl = 'http://p2api.ryanmclaren.ca/api/job-postings';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            echo "Failed to fetch data from API";
            return;
        }

        $data = json_decode($result, true)['data'];

        try {
            $dbConnection = (new DBConnection())->getConnection();

            // Clear the table before inserting new data
            $dbConnection->exec("DELETE FROM JobPostings");

            $stmt = $dbConnection->prepare("INSERT INTO JobPostings (CreatedAt, Title, Description, Location, StartDate, ContactEmail) VALUES (?, ?, ?, ?, ?, ?)");

            foreach ($data as $item) {

                // Convert the date to the correct format
                $createdAt = (new DateTime($item['created_at']))->format('Y-m-d H:i:s');

                // Prepare and bind parameters to avoid SQL injection
                $stmt->execute([
                    $createdAt,
                    $item['title'],
                    $item['description'],
                    $item['location'],
                    $item['start_date'],
                    $item['contact_email']
                ]);
            }

            // Redirect or inform the user of success
            echo "Data fetched and inserted successfully!";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}
