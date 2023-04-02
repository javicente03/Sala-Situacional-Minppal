<?php
    // Establecer conexión con la base de datos usando PDO

    // Obtener datos de conexión de un archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    // Datos de conexión
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'minppal_sala_situacional_db';

    // Establecer conexión

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        // echo "Conexión exitosa";
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }