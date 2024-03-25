<?php

declare(strict_types=1);

namespace App\Controllers;

use PDOException;
use App\DB\DBConnection;

class TestController
{
    public function testDbConnection()
    {
        try {
            $dbConnection = new DBConnection();
            $conn = $dbConnection->getConnection();
            echo "The connection is successful!";
        } catch (PDOException $e) {
            echo "The connection fails. Error:" . $e->getMessage();
        }
    }
}
