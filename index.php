<?php

require 'vendor/autoload.php';

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
require_once 'src/controllers/auth.controllers.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'Home');
    $r->addRoute('GET', '/enter', 'Sesion');

    // rutas para el controlador de autenticación
    $r->addGroup('/auth', function (RouteCollector $r) {
        $r->addRoute('GET', '/login', 'Home');
        $r->addRoute('POST', '/login', 'LoginPost');
    });

    
    $r->addGroup('/protected', function (RouteCollector $r) {
        $r->addRoute('GET', '/users', function () {
            echo "Listado de usuarios";
        }, ['middleware1']);
        $r->addRoute('GET', '/users/{id:\d+}', 'GetUser');
        $r->addRoute('POST', '/users', 'CreateUser');
        $r->addRoute('PUT', '/users/{id:\d+}', 'UpdateUser');
        $r->addRoute('DELETE', '/users/{id:\d+}', 'DeleteUser');
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