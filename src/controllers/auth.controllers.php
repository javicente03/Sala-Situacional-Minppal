<?php

// Este es el archivo controlador de la aplicación
// Definimos funciones que se encargan de realizar las acciones y retornar la vista correspondiente

// declaramos la funcion Home que se encarga de retornar la vista de la pagina principal

function Home() {
    // incluimos la vista de la pagina principal
    $path_now = $_SERVER['REQUEST_URI'];

    if ($path_now == '/login' && isset($_SESSION['user'])) {
        header('Location: /');
    }
    $title = "MINPPAL - Sala Situacional";
    // obtener el path actual
    include_once 'src/blocks/headerLanding.php';
    include_once 'src/views/index.php';
}

// declaramos la funcion Login que se encarga recibir los datos del formulario de login y validarlos

function LoginPost() {
    // validamos que el usuario haya enviado los datos del formulario
    try {

        if (isset($_SESSION['user'])) {
            throw new Exception('Ya hay una sesión iniciada');
        }

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            throw new Exception('No se recibieron los datos del formulario');
        }

        // obtenemos los datos del formulario
        $email = trim(addslashes($_POST['email']));
        $password = trim(addslashes($_POST['password']));

        if (empty($email) || empty($password)) {
            throw new Exception('Los datos del formulario no pueden estar vacios');
        }

        require 'src/database/connection.php';

        // Buscamos el usuario en la base de datos
        $sql = "SELECT * FROM users WHERE email_user = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception('El usuario no existe');
        }

        if ($user['active_user'] == 0) {
            throw new Exception('El usuario no esta activo');
        }

        // Verificamos la contraseña
        if (!password_verify($password, $user['password_user'])) {
            throw new Exception('La contraseña es incorrecta');
        }

        // Almacenar datos del usuario en la sesión
        $_SESSION['user'] = $user['name_user'];
        $_SESSION['email'] = $user['email_user'];
        $_SESSION['id'] = $user['id_user'];
        $_SESSION['role'] = $user['role_user'];

        $response = [
            'message' => 'Bienvenido ' . $user['name_user'],
            'user' => $user
        ];

        // mandar el codigo de respuesta 200
        echo json_encode($response);
        
    } catch (\Throwable $th) {
        // mandar el error al cliente con codigo 400 pero enviar el mensaje de error
        echo json_encode([
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}

function Sesion() {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header('Location: /admin/users');
        } else {
            echo 'Bienvenido Usuario';

            session_destroy();
        }
    } else {
        // redireccionar a la pagina de login
        header('Location: /login');
    }
}

function Logout() {
    session_destroy();
    header('Location: /login');
}