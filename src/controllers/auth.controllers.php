<?php

// Este es el archivo controlador de la aplicación
// Definimos funciones que se encargan de realizar las acciones y retornar la vista correspondiente

// declaramos la funcion Home que se encarga de retornar la vista de la pagina principal

function Home() {
    // incluimos la vista de la pagina principal
    include_once 'src/views/index2.php';
}

function Sesion() {
    // incluimos la vista de la pagina principal
    include_once 'src/views/enter.php';
}

// declaramos la funcion Login que se encarga recibir los datos del formulario de login y validarlos

function LoginPost() {
    // validamos que el usuario haya enviado los datos del formulario
    // if (isset($_POST['username']) && isset($_POST['password'])) {
    //     // recibimos los datos del formulario
    //     $username = $_POST['username'];
    //     $password = $_POST['password'];
    //     // validamos que los datos no esten vacios
    //     if (!empty($username) && !empty($password)) {
    //         // validamos que el usuario y la contraseña sean correctos
    //         if ($username == 'admin' && $password == 'admin') {
    //             // si el usuario y la contraseña son correctos, redireccionamos a la pagina principal
    //             // llamar a la funcion GenerateTokenJWT y pasar la informacion del usuario
                
    //             header('Location: /enter');
    //         } else {
    //             // si el usuario y la contraseña son incorrectos, redireccionamos a la pagina de login
    //             header('Location: /auth/login');
    //         }
    //     } else {
    //         // si los datos estan vacios, redireccionamos a la pagina de login
    //         header('Location: /auth/login');
    //     }
    // } else {
    //     // si el usuario no ha enviado los datos del formulario, redireccionamos a la pagina de login
    //     header('Location: /auth/login');
    // }

    echo "hola";
}