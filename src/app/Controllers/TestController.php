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
            echo "Conexão bem-sucedida!";
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }
}
