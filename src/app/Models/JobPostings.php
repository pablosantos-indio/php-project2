<?php

namespace App\Models;

use PDO;
use App\DB\DBConnection;

class JobPostings extends Model
{

    private int $id;
    private $createdAt;
    private $title;
    private $description;
    private $location;
    private $startDate;
    private $contactEmail;

    public function __construct(string $createdAt = null, string $title = null, string $description = null, string $location = null, string $startDate = null, string $contactEmail = null)
    {
        parent::__construct();

        $this->createdAt = $createdAt;
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->startDate = $startDate;
        $this->contactEmail = $contactEmail;
    }

    // Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    // Setters

    public function setId(int $id): JobPostings
    {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt(string $createdAt): JobPostings
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setTitle(string $title): JobPostings
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): JobPostings
    {
        $this->description = $description;
        return $this;
    }

    public function setLocation(string $Location): JobPostings
    {
        $this->location = $Location;
        return $this;
    }

    public function setStartDate(string $startDate): JobPostings
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function setContactEmail(string $contactEmail): JobPostings
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    public function getShortDescription(): string
    {
        $description = $this->getDescription();

        // Check if the description is longer than 150 characters
        if (strlen($description) > 150) {
            // Truncate the description to 150 characters and append "..."
            $shortDescription = substr($description, 0, 150) . '...';
        } else {
            // If the description is 150 characters or less, return the full description
            $shortDescription = $description;
        }

        return $shortDescription;
    }

    public static function validate(array $data): array|bool
    {
        // Initialize error messages and fields array
        $errors = [
            'name' => '',
            'email' => '',
            'resume' => '',
        ];
        $fields = $errors;

        // Trim whitespace from submitted name and email
        $fields['name'] = trim($data['name']);
        $fields['email'] = trim($data['email']);

        // Validate name field
        if (empty($fields['name'])) {
            $errors['name'] = 'Name is required';
        }

        // Validate email field
        if (empty($fields['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (strlen($fields['email']) > 255) {
            $errors['email'] = 'Email must be 255 characters or less';
        }

        // Validate resume file
        if (empty($_FILES['resume']['tmp_name'])) {
            $errors['resume'] = 'Resume file is required';
        } elseif ($_FILES['resume']['size'] > 4 * 1024 * 1024) { // Check file size (4 MB limit)
            $errors['resume'] = 'Resume file size exceeds the limit of 4 MB';
        } elseif (!in_array($_FILES['resume']['type'], ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) { // Check file type
            $errors['resume'] = 'Invalid file type. Allowed formats: PDF, DOC, DOCX';
        }

        // If there are any errors, store them in session and return false
        if (implode('', $errors) !== '') {
            $_SESSION['errors'] = $errors;
            $_SESSION['fields'] = $fields;
            return false;
        }

        // Validation successful, return the validated fields
        return $fields;
    }


    public static function find(int $id): JobPostings|bool
    {
        //Connect to database
        $connection = (new DBConnection())->getConnection();

        //Select specific JobPostings data by Id
        $sql = 'SELECT * FROM JobPostings WHERE Id = :id';
        $stmt = $connection->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, JobPostings::class);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        return $jobPostings = $stmt->fetch();
    }

    public static function findAll(int $page = 1, int $limit = 5): array
    {
        // Connect to the database
        $db = (new DBConnection())->getConnection();

        // Calculate the offset based on the current page and limit per page
        $offset = ($page - 1) * $limit;

        // Count the total number of records
        $totalStmt = $db->query('SELECT COUNT(*) FROM JobPostings');
        $total = $totalStmt->fetchColumn();

        if($total == 0){
            return [
                'jobPostings' => [],
                'current_page' => 0,
                'next_disabled' => true,
                'total_pages' => 0,
                'previous_disabled' => true
            ];
        }

        // Calculate the total number of pages
        $totalPages = ceil($total / $limit);

        // Check if it's the first page
        $previousDisabled = ($page == 1);

        // Check if it's the last page
        $nextDisabled = ($page >= $totalPages);

        // Select data from JobPostings table with pagination
        $stmt = $db->prepare('SELECT * FROM JobPostings LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch data as instances of JobPostings
        $jobPostings = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return [
            'jobPostings' => $jobPostings,
            'current_page' => $page,
            'next_disabled' => $nextDisabled,
            'total_pages' => $totalPages,
            'previous_disabled' => $previousDisabled
        ];
    }

}
