<?php
// Conexión a la base de datos
$host = 'localhost';
$db   = 'supermercado';
$user = 'root';    // cambia según tu XAMPP/Laragon
$pass = '';         // cambia según tu XAMPP/Laragon
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opciones);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
