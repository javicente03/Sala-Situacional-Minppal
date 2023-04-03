<?php
    // Establecer conexión con la base de datos usando PDO

    // Obtener datos de conexión de un archivo .env
    require_once __DIR__ . '/../../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    // Datos de conexión
    $host = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password_db = $_ENV['DB_PASSWORD'];
    $database = $_ENV['DB_DATABASE'];

    // Establecer conexión

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password_db);
        // echo "Conexión exitosa";
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }