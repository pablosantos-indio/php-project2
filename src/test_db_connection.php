<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use App\DB\DBConnection;

try {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
