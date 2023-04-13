<?php

require 'vendor/autoload.php';

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
require_once 'src/controllers/auth.controllers.php';
require_once 'src/controllers/admin.controllers.php';
session_start();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'Home');
    $r->addRoute('GET', '/login', 'Home');
    $r->addRoute('GET', '/session', 'Sesion');

    // rutas para el controlador de autenticación
    $r->addGroup('/auth', function (RouteCollector $r) {
        $r->addRoute('POST', '/login', 'LoginPost');
        $r->addRoute('GET', '/logout', 'Logout');
    });

    $r->addGroup('/admin', function (RouteCollector $r) {
        // Usuarios
        $r->addRoute('GET', '/users', 'Admin_Users_Get');
        $r->addRoute('GET', '/users/create', 'Admin_Users_Create');
        $r->addRoute('POST', '/users/create', 'Admin_Users_Post');
        $r->addRoute('GET', '/users/edit/{id}', 'Admin_Users_Edit');
        $r->addRoute('POST', '/users/edit', 'Admin_Users_Put');

        // Compañías
        $r->addRoute('GET', '/companies/create-list', 'Create_First_Companies');
        $r->addRoute('GET', '/companies', 'Admin_Companies_Get');
        $r->addRoute('GET', '/companies/edit/{id}', 'Admin_Company_Edit');
        $r->addRoute('POST', '/companies/edit', 'Admin_Companies_Put');
    });

    $r->addRoute('GET', '/generarHash', function() {
        $password = '123456';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo $hash;
    });

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::FOUND:
        // Ejecutar la función controlador correspondiente
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func_array($handler, $vars);
        break;
    case Dispatcher::NOT_FOUND:
        // Mostrar una página personalizada de 404
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // Lógica para manejar la ruta encontrada pero con un método HTTP no permitido
        break;
}