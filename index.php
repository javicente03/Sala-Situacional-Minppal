<?php

require 'vendor/autoload.php';

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
require_once 'src/controllers/auth.controllers.php';
require_once 'src/controllers/admin.controllers.php';
require_once 'src/controllers/companys/cnae.controllers.php';
require_once 'src/controllers/companys/clap.controllers.php';
require_once 'src/controllers/companys/inn.controllers.php';
require_once 'src/controllers/companys/fundaproal.controllers.php';
require_once 'src/controllers/companys/mercal.controllers.php';
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

        // Municipios
        $r->addRoute('GET', '/municipalities/create-list', 'Create_Municipios');

        // CNAE
        $r->addRoute('GET', '/cnae', 'CNAE_Viewer');
        $r->addRoute('GET', '/cnae/{id}', 'Get_Cnae_Por_Mes');
        $r->addRoute('GET', '/cnae/assigned/{id}', 'Update_CNAE_Assigned');
        $r->addRoute('POST', '/cnae/assigned', 'PUT_CNAE_Assigned');
        $r->addRoute('GET', '/cnae/load/{id}', 'Load_Data_CNAE');
        $r->addRoute('POST', '/cnae/load', 'POST_Data_CNAE');
        $r->addRoute('GET', '/cnae/month-export/{id}', 'Export_PDF_CNAE_Por_Mes');

        // CLAP
        $r->addRoute('GET', '/clap', 'Clap_Viewer');
        $r->addRoute('GET', '/clap/create', 'Create_Entrega');
        $r->addRoute('POST', '/clap/create', 'POST_Entrega');
        $r->addRoute('GET', '/clap/custom/{id}', 'Clap_Custom');
        $r->addRoute('POST', '/clap/custom', 'POST_Clap_Custom');
        $r->addRoute('GET', '/clap/load/{id}', 'Clap_Load');
        $r->addRoute('POST', '/clap/load', 'Post_Load_Clap');
        $r->addRoute('GET', '/clap/export/{id}', 'Export_Pdf_Clap_Por_Entrega');

        // INN
        $r->addRoute('GET', '/inn', 'INN_Viewer');
        $r->addRoute('GET', '/inn/{id}', 'Get_INN_Por_Mes');
        $r->addRoute('GET', '/inn/assigned/{id}', 'Update_INN_Assigned');
        $r->addRoute('POST', '/inn/assigned', 'PUT_INN_Assigned');
        $r->addRoute('GET', '/inn/load/{id}', 'Load_Data_INN');
        $r->addRoute('POST', '/inn/load', 'POST_Data_INN');
        $r->addRoute('GET', '/inn/month-export/{id}', 'Export_PDF_INN_Por_Mes');

        // FUNDAPROAL
        $r->addRoute('GET', '/fundaproal', 'FUNDAPROAL_Viewer');
        $r->addRoute('GET', '/fundaproal/{id}', 'Get_FUNDAPROAL_Por_Mes');
        $r->addRoute('GET', '/fundaproal/assigned/{id}', 'Update_FUNDAPROAL_Assigned');
        $r->addRoute('POST', '/fundaproal/assigned', 'PUT_FUNDAPROAL_Assigned');
        $r->addRoute('GET', '/fundaproal/load/{id}', 'Load_Data_FUNDAPROAL');
        $r->addRoute('POST', '/fundaproal/load', 'POST_Data_FUNDAPROAL');
        $r->addRoute('GET', '/fundaproal/month-export/{id}', 'Export_PDF_FUNDAPROAL_Por_Mes');

        // MERCAL
        $r->addRoute('GET', '/mercal/create-programs', 'CreateProgramasMercal');
        $r->addRoute('GET', '/mercal', 'Mercal_Viewer');
        $r->addRoute('GET', '/mercal/in', 'Mercal_Recepcion');
        $r->addRoute('POST', '/mercal/in', 'Post_Recepcion');
        $r->addRoute('GET', '/mercal/out', 'Mercal_Despacho');
        $r->addRoute('POST', '/mercal/out', 'Post_Despacho');
        $r->addRoute('GET', '/mercal/program/{id}', 'Movimientos_Programa');
        $r->addRoute('GET', '/mercal/export-pdf', 'Export_Pdf_Mercal_Programas');
        $r->addRoute('GET', '/mercal/export-pdf/{id}', 'Export_Pdf_Mercal_Por_Programa');
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