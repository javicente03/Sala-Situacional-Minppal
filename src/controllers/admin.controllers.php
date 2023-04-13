<?php

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