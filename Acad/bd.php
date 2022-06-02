<?php

$endereco = 'localhost';
$banco = 'acad';
$usuario = 'postgres';
$senha = 'Joaointer23';


$db = null;

try {
    $dsn = "pgsql:host=$endereco;port=5432;dbname=$banco;";
    // make a database connection
    $pdo = new PDO($dsn, $usuario, $senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    
} 
catch (PDOException $e) {
    die($e->getMessage());
}
?>