<?php

// ---------------------------- ADMINISTRADOR DE USUARIOS --------------------------------
// Retornar vista de la lista de usuarios
function Admin_Users_Get(){

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // obtener querys desde la url
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;
    $filter_role = isset($_GET['role']) ? $_GET['role'] : 'all';
    $filter_status = isset($_GET['status']) ? $_GET['status'] : 'all';

    // obtener usuarios
    $sql = "SELECT * FROM users";
    $whereClause = "";
    $params = array();

    if ($filter_role != 'all') {
        $whereClause .= " WHERE role_user = :role_user";
        $params[':role_user'] = $filter_role;
    }

    if ($filter_status != 'all') {
        $whereClause .= ($whereClause == "" ? " WHERE " : " AND ");
        $whereClause .= "active_user = :active_user";
        $params[':active_user'] = $filter_status;
    }

    $sql .= $whereClause;
    $sql .= " ORDER BY id_user DESC LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // obtener total de usuarios
    $sqlTotal = "SELECT COUNT(*) as total FROM users";
    $whereClause = "";
    $params = array();

    if ($filter_role != 'all') {
        $whereClause .= " WHERE role_user = :role_user";
        $params[':role_user'] = $filter_role;
    }

    if ($filter_status != 'all') {
        $whereClause .= ($whereClause == "" ? " WHERE " : " AND ");
        $whereClause .= "active_user = :active_user";
        $params[':active_user'] = $filter_status;
    }

    $sqlTotal .= $whereClause;

    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->execute($params);
    $total = $stmtTotal->fetch()['total'];
    $totalPages = ceil($total / $limit);


    $title = 'MINPPAL - Administrador de Usuarios';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/users/list.php';
    include_once 'src/blocks/footer.php';
}

// Retornar vista de crear usuario
function Admin_Users_Create () {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    $title = 'MINPPAL - Crear Usuario';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/users/create.php';
    include_once 'src/blocks/footer.php';
}

// Crear usuario
function Admin_Users_Post () {
    try {
        //code...
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        // si no viaja name, email, password o role se lanza una excepción
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['role'])) {
            throw new Exception('No se recibieron los datos necesarios');
        }

        $name = trim(addslashes($_POST['name']));
        $email = trim(addslashes($_POST['email']));
        $role = trim(addslashes($_POST['role']));
        $password = trim(addslashes($_POST['password']));

        if ($name == '' || $email == '' || $role == '' || $password == '') {
            throw new Exception('Los datos no pueden estar vacíos');
        }

        if (strlen($password) < 6) {
            throw new Exception('La contraseña debe tener al menos 6 caracteres');
        }

        // role solo puede ser admin o reader
        if ($role != 'admin' && $role != 'reader') {
            throw new Exception('El rol no es válido');
        }

        // validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El email no es válido');
        }

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        // validar que el email no exista
        require 'src/database/connection.php';
        $sql = "SELECT * FROM users WHERE email_user = :email_user";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':email_user' => $email));
        $user = $stmt->fetch();

        if ($user) {
            throw new Exception('El email ya está registrado');
        }

        // crear usuario
        $sql = "INSERT INTO users (name_user, email_user, role_user, password_user) VALUES (:name_user, :email_user, :role_user, :password_user)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':name_user' => $name,
            ':email_user' => $email,
            ':role_user' => $role,
            ':password_user' => $hash_password
        ));

        if ($stmt->rowCount() == 0) {
            throw new Exception('No se pudo crear el usuario');
        }

        $response = array(
            'status' => 'success',
            'message' => 'Usuario creado correctamente'
        );

        echo json_encode($response);
    } catch (\Throwable $th) {

        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);
        http_response_code(400);
    }
}

// Retornar vista de editar usuario
function Admin_Users_Edit ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';
    $sql = "SELECT * FROM users WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':id_user' => $id));
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: /admin/users');
        exit();
    }

    $title = 'MINPPAL - Editar Usuario';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/users/edit.php';
    include_once 'src/blocks/footer.php';

}

// Editar usuario
function Admin_Users_Put () {
    try {
        //code...
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        // si no viaja name, email, password, role, status se lanza una excepción
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['role']) || !isset($_POST['id'])) {
            throw new Exception('No se recibieron los datos necesarios');
        }

        $name = trim(addslashes($_POST['name']));
        $email = trim(addslashes($_POST['email']));
        $role = trim(addslashes($_POST['role']));
        $id = trim(addslashes($_POST['id']));
        $status = isset($_POST['status']) ? trim(addslashes($_POST['status'])) : false;
        $password = isset($_POST['password']) ? trim(addslashes($_POST['password'])) : null;

        if ($name == '' || $email == '' || $role == '' || $id == '') {
            throw new Exception('Los datos no pueden estar vacíos');
        }

        // role solo puede ser admin o reader
        if ($role != 'admin' && $role != 'reader') {
            throw new Exception('El rol no es válido');
        }

        // validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El email no es válido');
        }

        // Si se envía password se valida
        if ($password != null && $password != '') {
            if (strlen($password) < 6) {
                throw new Exception('La contraseña debe tener al menos 6 caracteres');
            }
        }

        // validar que el id exista
        require 'src/database/connection.php';
        $sql = "SELECT * FROM users WHERE id_user = :id_user";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':id_user' => $id));
        $user = $stmt->fetch();

        if (!$user) {
            throw new Exception('El usuario no existe');
        }

        if ($email != $user['email_user']) {
            // validar que el email no exista para otro usuario
            $sql = "SELECT * FROM users WHERE email_user = :email_user AND id_user != :id_user";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(':email_user' => $email, ':id_user' => $id));
            $user = $stmt->fetch();

            if ($user) {
                throw new Exception('El email ya está registrado para otro usuario');
            }
        }

        // editar usuario
        $sql = "UPDATE users SET name_user = :name_user, email_user = :email_user, role_user = :role_user, active_user = :status_user";
        $params = array(
            ':name_user' => $name,
            ':email_user' => $email,
            ':role_user' => $role,
            ':status_user' => $status
        );
        
        // si se envía password se agrega al query
        if ($password != null && $password != '') {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password_user = :password_user";
            $params[':password_user'] = $hash_password;
        }

        // se agrega el where
        $sql .= " WHERE id_user = :id_user";
        $params[':id_user'] = $id;

        // se ejecuta el query
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() == 0) {
            throw new Exception('No se pudo editar el usuario');
        }

        $response = array(
            'status' => 'success',
            'message' => 'Usuario editado correctamente'
        );

        echo json_encode($response);
    } catch (\Throwable $th) {
        //throw $th;

        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);
        http_response_code(400);
    }
}

// ----------------------------- FIN ADMINISTRACIÓN DE USUARIOS -----------------------------

// ----------------------------- INICIO ADMINISTRACIÓN DE COMPANÍAS -----------------------------
// Retornar vista de administración de compañías
function Admin_Companies_Get () {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require_once __DIR__ . '/../../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $url_domain = $_ENV['URL_DOMAIN'];

    require 'src/database/connection.php';
    
    // obtener querys desde la url
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    // obtener usuarios
    $sql = "SELECT * FROM companies";
    $whereClause = "";
    $params = array();

    $sql .= $whereClause;
    $sql .= " LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // obtener total de usuarios
    $sqlTotal = "SELECT COUNT(*) as total FROM companies";
    $whereClause = "";
    $params = array();

    $sqlTotal .= $whereClause;

    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->execute($params);
    $total = $stmtTotal->fetch()['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - Administración de Empresas';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/list.php';
    include_once 'src/blocks/footer.php';

}

// Retornar vista de edición de compañía
function Admin_Company_Edit ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // obtener compañía
    $sql = "SELECT * FROM companies WHERE id_company = :id_company";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':id_company' => $id));
    $company = $stmt->fetch();

    if (!$company) {
        header('Location: /admin/companies');
        exit();
    }

    $title = 'MINPPAL - Editar Empresa';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/edit.php';
    include_once 'src/blocks/footer.php';

}

// Editar compañía
function Admin_Companies_Put () {
    try {
        //code...
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para editar una compañía');
        }

        // Revisar que se envíen los datos: name, vision, mision, id
        if (!isset($_POST['name']) || !isset($_POST['vision']) || !isset($_POST['mision']) || !isset($_POST['id'])) {
            throw new Exception('No se enviaron los datos necesarios');
        }

        // Si se envía el logo y name no esta vacio, se revisa que sea una imagen y que no pese más de 2MB
        if (isset($_FILES['logo']) && $_FILES['logo']['name'] != '') {
            $logo = $_FILES['logo'];
            $allowed = array('jpg', 'jpeg', 'png');
            $filename = $logo['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                throw new Exception('El logo debe ser una imagen');
            }

            if ($logo['size'] > 10000000) {
                throw new Exception('El logo no puede pesar más de 10MB');
            }
        }

        $name = trim(addslashes($_POST['name']));
        $vision = trim(addslashes($_POST['vision']));
        $mision = trim(addslashes($_POST['mision']));
        $id = trim(addslashes($_POST['id']));
        $logo = isset($_FILES['logo']) && $_FILES['logo']['name'] != '' ? $_FILES['logo'] : null;

        // Revisar que el nombre, visión y misión no estén vacíos
        if (empty($name) || empty($vision) || empty($mision)) {
            throw new Exception('El nombre, visión y misión no pueden estar vacíos');
        }

        // Revisar que el id sea un número
        if (!is_numeric($id)) {
            throw new Exception('El id debe ser un número');
        }

        // Revisar que el id exista
        require 'src/database/connection.php';
        $sql = "SELECT * FROM companies WHERE id_company = :id_company";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':id_company' => $id));
        $company = $stmt->fetch();
        
        if (!$company) {
            throw new Exception('La compañía no existe');
        }

        // subir logo, la ruta es: /media/companies/logos/{name}.ext
        if ($logo) {
            $filename = $logo['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $logoPath = "media/companies/logos/$name.$ext";

            // Revisar que exista la carpeta
            if (!file_exists('media/companies/logos')) {
                mkdir('media/companies/logos', 0777, true);
            }
            move_uploaded_file($logo['tmp_name'], $logoPath);
        }

        // Actualizar compañía
        $sql = "UPDATE companies SET name_company = :name, vision_company = :vision, mision_company = :mision, logo_company = :logo WHERE id_company = :id_company";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':name' => $name,
            ':vision' => $vision,
            ':mision' => $mision,
            ':logo' => $logo ? $logoPath : $company['logo_company'],
            ':id_company' => $id
        ));

        echo json_encode([
            'status' => 'success',
            'message' => 'Compañía actualizada'
        ]);

    } catch (\Throwable $th) {
        //throw $th;

        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);
        http_response_code(400);
    }
}

// Crear listado de compañías
function Create_First_Companies () {
    try {
        require 'src/database/connection.php';

        // Si ya hay compañías creadas, no se crean
        $sql = "SELECT * FROM companies";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($companies) > 0) {
            throw new Exception('Ya hay compañías creadas');
        }

        // Crear compañías
        // INN
        // CLAP
        // SUNAGRO
        // MERCAL
        // PDVAL
        // FUNDAPROAL
        // EPS JOSEFA CAMEJO
        // CNAE

        $companies = array(
            array(
                'name_company' => 'INN',
                'mision_company' => 'Misión INN',
                'vision_company' => 'Visión INN',
                'logo_company' => 'logo_inn.png',
            ),
            array(
                'name_company' => 'CLAP',
                'mision_company' => 'Misión CLAP',
                'vision_company' => 'Visión CLAP',
                'logo_company' => 'logo_clap.png',
            ),
            array(
                'name_company' => 'SUNAGRO',
                'mision_company' => 'Misión SUNAGRO',
                'vision_company' => 'Visión SUNAGRO',
                'logo_company' => 'logo_sunagro.png',
            ),
            array(
                'name_company' => 'MERCAL',
                'mision_company' => 'Misión MERCAL',
                'vision_company' => 'Visión MERCAL',
                'logo_company' => 'logo_mercal.png',
            ),
            array(
                'name_company' => 'PDVAL',
                'mision_company' => 'Misión PDVAL',
                'vision_company' => 'Visión PDVAL',
                'logo_company' => 'logo_pdval.png',
            ),
            array(
                'name_company' => 'FUNDAPROAL',
                'mision_company' => 'Misión FUNDAPROAL',
                'vision_company' => 'Visión FUNDAPROAL',
                'logo_company' => 'logo_fundaproal.png',
            ),
            array(
                'name_company' => 'EPS JOSEFA CAMEJO',
                'mision_company' => 'Misión EPS JOSEFA CAMEJO',
                'vision_company' => 'Visión EPS JOSEFA CAMEJO',
                'logo_company' => 'logo_eps_josefa_camejo.png',
            ),
            array(
                'name_company' => 'CNAE',
                'mision_company' => 'Misión CNAE',
                'vision_company' => 'Visión CNAE',
                'logo_company' => 'logo_cnae.png',
            ),
        );

        foreach ($companies as $company) {
            $sql = "INSERT INTO companies (name_company, mision_company, vision_company, logo_company) VALUES (:name_company, :mision_company, :vision_company, :logo_company)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($company);
        }

        header('Location: /admin/companies');

    } catch (\Throwable $th) {
        
        header('Location: /admin/companies');
    }
}

// Crear Municipios de Falcón
function Create_Municipios () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para crear los municipios');
        }
        require 'src/database/connection.php';

        // Si ya hay municipios creados, no se crean
        $sql = "SELECT * FROM municipios";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($municipios) > 0) {
            throw new Exception('Ya hay municipios creados');
        }

        // Crear municipios
        $municipios = array(
            array(
                'name_municipio' => 'Acosta',
            ),
            array(
                'name_municipio' => 'Bolívar',
            ),
            array(
                'name_municipio' => 'Buchivacoa',
            ),
            array(
                'name_municipio' => 'Cacique Manaure',
            ),
            array(
                'name_municipio' => 'Carirubana',
            ),
            array(
                'name_municipio' => 'Colina',
            ),
            array(
                'name_municipio' => 'Dabajuro',
            ),
            array(
                'name_municipio' => 'Democracia',
            ),
            array(
                'name_municipio' => 'Falcón',
            ),
            array(
                'name_municipio' => 'Federación',
            ),
            array(
                'name_municipio' => 'Jacura',
            ),
            array(
                'name_municipio' => 'Los Taques',
            ),
            array(
                'name_municipio' => 'Mauroa',
            ),
            array(
                'name_municipio' => 'Miranda',
            ),
            array(
                'name_municipio' => 'Monseñor Iturriza',
            ),
            array(
                'name_municipio' => 'Palmasola',
            ),
            array(
                'name_municipio' => 'Petit',
            ),
            array(
                'name_municipio' => 'Píritu',
            ),
            array(
                'name_municipio' => 'San Francisco',
            ),
            array(
                'name_municipio' => 'Silva',
            ),
            array(
                'name_municipio' => 'Sucre',
            ),
            array(
                'name_municipio' => 'Tocópero',
            ),
            array(
                'name_municipio' => 'Unión',
            ),
            array(
                'name_municipio' => 'Urumaco',
            ),
            array(
                'name_municipio' => 'Zamora',
            ),
        );

        foreach ($municipios as $municipio) {
            $sql = "INSERT INTO municipios (name_municipio) VALUES (:name_municipio)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($municipio);
        }

        header('Location: /admin/companies');

    } catch (\Throwable $th) {    
        header('Location: /admin/companies');
    }

}