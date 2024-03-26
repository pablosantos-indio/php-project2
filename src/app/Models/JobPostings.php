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

        return $jobPosting = $stmt->fetch();
    }

}
