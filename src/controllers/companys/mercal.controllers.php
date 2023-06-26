
<?php

function CreateProgramasMercal () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para crear los municipios');
        }

        require 'src/database/connection.php';
        
        $sql_programas = "SELECT * FROM mercal_stock_programas";
        $result_programas = $conn->prepare($sql_programas);
        $result_programas->execute();
        $programas = $result_programas->fetchAll(PDO::FETCH_ASSOC);

        if (count($programas) > 0) {
            throw new Exception('Ya hay programas creados');
        }

        $programas = [
            [
                'programa' => 'BASE DE MISIONES',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'base_misiones'
            ],
            [
                'programa' => 'PLAN DE VULNERABILIDAD',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'plan_vulnerabilidad'
            ],
            [
                'programa' => 'FUNDAPROAL',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'fundaproal'
            ],
            [
                'programa' => 'CNAE',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'cnae'
            ],
            [
                'programa' => 'CORPOELEC',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'corpoelec'
            ],
            [
                'programa' => 'PLAN PNB',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'plan_pnb'
            ],
            [
                'programa' => 'PLAN FANB FAMILAR',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'plan_fanb_familiar'
            ],
            [
                'programa' => 'PLAN TANGO SOLDADO',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'plan_tango_soldado'
            ],
            [
                'programa' => 'FUNDAMUSICAL',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'fundamusical'
            ],
            [
                'programa' => 'RECEVA ACTIVA',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'receva_activa'
            ],
            [
                'programa' => 'CDI',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'cdi'
            ],
            [
                'programa' => 'COLABORADORES CUBANOS',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'colaboradores_cubanos'
            ],
            [
                'programa' => 'HOSPITAL IVSS',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'hospital_ivss'
            ],
            [
                'programa' => 'HOSPITAL MPPS',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'hospital_mpps'
            ],
            [
                'programa' => 'HOSPITAL CENTINELA',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'hospital_centinela'
            ],
            [
                'programa' => 'IDENA',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'idena'
            ],
            [
                'programa' => 'INASS',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'inass'
            ],
            [
                'programa' => 'SERN',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'sern'
            ],
            [
                'programa' => 'NEGRA HIPÓLITA',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'negra_hipolita'
            ],
            [
                'programa' => 'DIGE SALUD',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'dige_salud'
            ],
            [
                'programa' => 'MERCADO LABORAL MINPPAL',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'mercado_laboral_minppal'
            ],
            [
                'programa' => 'MERCADO LABORAL INN',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'mercado_laboral_inn'
            ],
            [
                'programa' => 'MERCADO LABORAL CUSPAL',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'mercado_laboral_cuspal'
            ],
            [
                'programa' => 'MERCADO LABORAL MERCAL',
                'stock_proteina' => 0,
                'stock_bolsas' => 0,
                'code_clave' => 'mercado_laboral_mercal'
            ],
        ];

        foreach ($programas as $programa) {
            $sql = "INSERT INTO mercal_stock_programas (programa, stock_proteina, stock_bolsas, code_clave) VALUES (:programa, :stock_proteina, :stock_bolsas, :code_clave)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':programa', $programa['programa']);
            $stmt->bindValue(':stock_proteina', $programa['stock_proteina']);
            $stmt->bindValue(':stock_bolsas', $programa['stock_bolsas']);
            $stmt->bindValue(':code_clave', $programa['code_clave']);
            $stmt->execute();
        }

        echo json_encode(array(
            'success' => true
        ));

    } catch (Exception $e) {
        echo json_encode(array(
            'error' => $e->getMessage()
        ));
    }
}

function Mercal_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;
    
    $sql_programas = "SELECT * FROM mercal_stock_programas ORDER BY id_mercal_stock_programas ASC LIMIT $offset, $limit";
    $stmt_programas = $conn->prepare($sql_programas);
    $stmt_programas->execute();
    $programas = $stmt_programas->fetchAll(PDO::FETCH_ASSOC);

    // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
    $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
    $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');
    
    $sql_movement = "SELECT programa_id, mercal_stock_programas.programa, type, mercal_stock_programas.code_clave, 
                    SUM(cantidad_proteina) AS suma_proteina, SUM(cantidad_bolsas) AS suma_bolsas
                    FROM mercal_recepcion_despacho
                    LEFT JOIN mercal_stock_programas ON mercal_recepcion_despacho.programa_id = mercal_stock_programas.id_mercal_stock_programas
                    WHERE fecha BETWEEN :start AND :end
                    GROUP BY programa_id, type";
    $stmt_movement = $conn->prepare($sql_movement);
    $stmt_movement->bindValue(':start', $start);
    $stmt_movement->bindValue(':end', $end);
    $stmt_movement->execute();
    $movements = $stmt_movement->fetchAll(PDO::FETCH_ASSOC);

    $data_return = array();

    foreach ($programas as $programa) {
        // Busca si en $movements hay un programa_id igual al id_mercal_stock_programas de $programa y si el type es igual a recepcion
        $despachado = array_filter($movements, function($movement) use ($programa) {
            return $movement['programa_id'] == $programa['id_mercal_stock_programas'] && $movement['type'] == 'despacho';
        });
        $recepcionado = array_filter($movements, function($movement) use ($programa) {
            return $movement['programa_id'] == $programa['id_mercal_stock_programas'] && $movement['type'] == 'recepcion';
        });

        $despachado = array_values($despachado);
        $recepcionado = array_values($recepcionado);
        
        $data_return[] = array(
            'id_mercal_stock_programas' => $programa['id_mercal_stock_programas'], // Se agrega para poder editar el stock desde el modal 'Editar Stock
            'programa' => $programa['programa'],
            'code_clave' => $programa['code_clave'],
            'stock_proteina' => $programa['stock_proteina'],
            'stock_bolsas' => $programa['stock_bolsas'],
            'proteina_despachada' => isset($despachado[0]['suma_proteina']) ? $despachado[0]['suma_proteina'] : 0,
            'bolsas_despachadas' => isset($despachado[0]['suma_bolsas']) ? $despachado[0]['suma_bolsas'] : 0,
            'proteina_recepcionada' => isset($recepcionado[0]['suma_proteina']) ? $recepcionado[0]['suma_proteina'] : 0,
            'bolsas_recepcionadas' => isset($recepcionado[0]['suma_bolsas']) ? $recepcionado[0]['suma_bolsas'] : 0,
        );
    }

    // Obtener el total
    $sql_total = "SELECT COUNT(*) AS total FROM mercal_stock_programas";
    $result_total = $conn->prepare($sql_total);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - MERCAL';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal/mercal_viewer.php';
    include_once 'src/blocks/footer.php';
}

// RECEPCION

function Mercal_Recepcion () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $sql = "SELECT * FROM mercal_stock_programas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $title = 'MINPPAL - MERCAL - RECEPCION';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal/mercal_recepcion.php';
    include_once 'src/blocks/footer.php';
}

function Post_Recepcion () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            header('Location: /login');
            exit();
        }

        require 'src/database/connection.php';

        if (!isset($_POST['programa'])) {
            throw new Exception('El programa no es válido');
        }
        $programa_id = $_POST['programa'];
        $cantidad_proteina = addslashes($_POST['proteina']);
        $cantidad_bolsas = addslashes($_POST['clap']);
        $fecha = addslashes($_POST['fecha']);
        $type = 'recepcion';

        if ($cantidad_proteina == '' || $cantidad_proteina == null) {
            $cantidad_proteina = 0;
        }
        if ($cantidad_bolsas == '' || $cantidad_bolsas == null) {
            $cantidad_bolsas = 0;
        }

        if ($cantidad_bolsas == 0 && $cantidad_proteina == 0) {
            throw new Exception('No puede registrar un despacho sin proteína ni bolsas');
        }

        if (!is_numeric($programa_id)) {
            throw new Exception('El programa no es válido');
        }
        if (!is_numeric($cantidad_proteina)) {
            throw new Exception('La cantidad de proteína no es válida');
        }
        if (!is_numeric($cantidad_bolsas)) {
            throw new Exception('La cantidad de bolsas no es válida');
        }

        if ($cantidad_proteina < 0) {
            throw new Exception('La cantidad de proteína no puede ser menor 0');
        }
        if ($cantidad_bolsas < 0) {
            throw new Exception('La cantidad de bolsas no puede ser menor 0');
        }

        // La fecha no puede ser mayor a la fecha actual
        if (strtotime($fecha) > strtotime(date('Y-m-d'))) {
            throw new Exception('La fecha no puede ser mayor a la fecha actual');
        }

        $sql_programa = "SELECT * FROM mercal_stock_programas WHERE id_mercal_stock_programas = :programa_id";
        $stmt_programa = $conn->prepare($sql_programa);
        $stmt_programa->bindValue(':programa_id', $programa_id);
        $stmt_programa->execute();
        $programa = $stmt_programa->fetch(PDO::FETCH_ASSOC);

        if (!$programa) {
            throw new Exception('El programa no existe');
        }

        $sql = "INSERT INTO mercal_recepcion_despacho (programa_id, cantidad_proteina, cantidad_bolsas, fecha, type, user_id) VALUES (:programa_id, :cantidad_proteina, :cantidad_bolsas, :fecha, :type, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':programa_id', $programa_id);
        $stmt->bindValue(':cantidad_proteina', $cantidad_proteina);
        $stmt->bindValue(':cantidad_bolsas', $cantidad_bolsas);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':user_id', $_SESSION['id']);
        $stmt->execute();

        // Modificar el stock
        $sql_stock = "UPDATE mercal_stock_programas SET stock_proteina = stock_proteina + :cantidad_proteina, stock_bolsas = stock_bolsas + :cantidad_bolsas 
                        WHERE id_mercal_stock_programas = :programa_id";
        $stmt_stock = $conn->prepare($sql_stock);
        $stmt_stock->bindValue(':cantidad_proteina', $cantidad_proteina);
        $stmt_stock->bindValue(':cantidad_bolsas', $cantidad_bolsas);
        $stmt_stock->bindValue(':programa_id', $programa_id);
        $stmt_stock->execute();

        echo json_encode(array(
            'status' => 'ok',
            'message' => 'Recepción registrada con éxito'
        ));
    } catch (\Throwable $th) {
        echo json_encode(array(
            'status' => 'error',
            'error' => $th->getMessage()
        ));

        http_response_code(400);
    }
}

// DESPACHO

function Mercal_Despacho () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $sql = "SELECT * FROM mercal_stock_programas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $title = 'MINPPAL - MERCAL - DESPACHO';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal/mercal_despacho.php';
    include_once 'src/blocks/footer.php';
}

function Post_Despacho () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            header('Location: /login');
            exit();
        }

        require 'src/database/connection.php';

        if (!isset($_POST['programa'])) {
            throw new Exception('El programa no es válido');
        }
        $programa_id = $_POST['programa'];
        $cantidad_proteina = addslashes($_POST['proteina']);
        $cantidad_bolsas = addslashes($_POST['clap']);
        $fecha = addslashes($_POST['fecha']);
        $type = 'despacho';

        if ($cantidad_proteina == '' || $cantidad_proteina == null) {
            $cantidad_proteina = 0;
        }
        if ($cantidad_bolsas == '' || $cantidad_bolsas == null) {
            $cantidad_bolsas = 0;
        }

        if ($cantidad_bolsas == 0 && $cantidad_proteina == 0) {
            throw new Exception('No puede registrar un despacho sin proteína ni bolsas');
        }

        if (!is_numeric($programa_id)) {
            throw new Exception('El programa no es válido');
        }
        if (!is_numeric($cantidad_proteina)) {
            throw new Exception('La cantidad de proteína no es válida');
        }
        if (!is_numeric($cantidad_bolsas)) {
            throw new Exception('La cantidad de bolsas no es válida'.$cantidad_bolsas);
        }

        if ($cantidad_proteina < 0) {
            throw new Exception('La cantidad de proteína no puede ser menor 0');
        }
        if ($cantidad_bolsas < 0) {
            throw new Exception('La cantidad de bolsas no puede ser menor 0');
        }

        // La fecha no puede ser mayor a la fecha actual
        if (strtotime($fecha) > strtotime(date('Y-m-d'))) {
            throw new Exception('La fecha no puede ser mayor a la fecha actual');
        }

        $sql_programa = "SELECT * FROM mercal_stock_programas WHERE id_mercal_stock_programas = :programa_id";
        $stmt_programa = $conn->prepare($sql_programa);
        $stmt_programa->bindValue(':programa_id', $programa_id);
        $stmt_programa->execute();
        $programa = $stmt_programa->fetch(PDO::FETCH_ASSOC);

        if (!$programa) {
            throw new Exception('El programa no existe');
        }

        // Validar que la cantidad de proteína no sea mayor al stock
        if ($cantidad_proteina > $programa['stock_proteina']) {
            throw new Exception('La cantidad de proteína a despachar no puede ser mayor al stock');
        }

        // Validar que la cantidad de bolsas no sea mayor al stock
        if ($cantidad_bolsas > $programa['stock_bolsas']) {
            throw new Exception('La cantidad de bolsas a despachar no puede ser mayor al stock');
        }

        $sql = "INSERT INTO mercal_recepcion_despacho (programa_id, cantidad_proteina, cantidad_bolsas, fecha, type, user_id) VALUES (:programa_id, :cantidad_proteina, :cantidad_bolsas, :fecha, :type, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':programa_id', $programa_id);
        $stmt->bindValue(':cantidad_proteina', $cantidad_proteina);
        $stmt->bindValue(':cantidad_bolsas', $cantidad_bolsas);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':user_id', $_SESSION['id']);
        $stmt->execute();

        // Modificar el stock
        $sql_stock = "UPDATE mercal_stock_programas SET stock_proteina = stock_proteina - :cantidad_proteina, stock_bolsas = stock_bolsas - :cantidad_bolsas 
                        WHERE id_mercal_stock_programas = :programa_id";
        $stmt_stock = $conn->prepare($sql_stock);
        $stmt_stock->bindValue(':cantidad_proteina', $cantidad_proteina);
        $stmt_stock->bindValue(':cantidad_bolsas', $cantidad_bolsas);
        $stmt_stock->bindValue(':programa_id', $programa_id);
        $stmt_stock->execute();

        echo json_encode(array(
            'status' => 'ok',
            'message' => 'Despacho registrado con éxito'
        ));
    } catch (\Throwable $th) {
        echo json_encode(array(
            'status' => 'error',
            'error' => $th->getMessage()
        ));

        http_response_code(400);
    }
}


// Vista por programa

function Movimientos_Programa ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $sql = "SELECT * FROM mercal_stock_programas WHERE id_mercal_stock_programas = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $programa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$programa) {
        header('Location: /admin/mercal');
        exit();
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
    $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
    $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');
    $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all';

    $sql = "SELECT * FROM mercal_recepcion_despacho WHERE programa_id = :id ";
    if ($filter_type != 'all') {
        $sql .= "AND type = '$filter_type' ";
    }
    $sql .= "AND fecha BETWEEN :start AND :end ORDER BY fecha DESC LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':start', $start);
    $stmt->bindValue(':end', $end);
    $stmt->execute();
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<script>let movimientos = '.json_encode($movimientos).'</script>';

    $sql_total = "SELECT COUNT(*) AS total FROM mercal_recepcion_despacho WHERE programa_id = :id ";
    if ($filter_type != 'all') {
        $sql_total .= "AND type = '$filter_type' ";
    }
    $sql_total .= "AND fecha BETWEEN :start AND :end";
    $result_total = $conn->prepare($sql_total);
    $result_total->bindValue(':id', $id);
    $result_total->bindValue(':start', $start);
    $result_total->bindValue(':end', $end);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - MERCAL - MOVIMIENTOS';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal/mercal_movimientos.php';
    include_once 'src/blocks/footer.php';
}

// PDF

function Export_Pdf_Mercal_Programas () {
    try {
        require_once 'src/database/connection.php';

        $sql_programas = "SELECT * FROM mercal_stock_programas";
        $stmt_programas = $conn->prepare($sql_programas);
        $stmt_programas->execute();
        $programas = $stmt_programas->fetchAll(PDO::FETCH_ASSOC);

        // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
        $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
        $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');
        
        $sql_movement = "SELECT programa_id, mercal_stock_programas.programa, type, mercal_stock_programas.code_clave, 
                        SUM(cantidad_proteina) AS suma_proteina, SUM(cantidad_bolsas) AS suma_bolsas
                        FROM mercal_recepcion_despacho
                        LEFT JOIN mercal_stock_programas ON mercal_recepcion_despacho.programa_id = mercal_stock_programas.id_mercal_stock_programas
                        WHERE fecha BETWEEN :start AND :end
                        GROUP BY programa_id, type";
        $stmt_movement = $conn->prepare($sql_movement);
        $stmt_movement->bindValue(':start', $start);
        $stmt_movement->bindValue(':end', $end);
        $stmt_movement->execute();
        $movements = $stmt_movement->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($programas as $programa) {
            // Busca si en $movements hay un programa_id igual al id_mercal_stock_programas de $programa y si el type es igual a recepcion
            $despachado = array_filter($movements, function($movement) use ($programa) {
                return $movement['programa_id'] == $programa['id_mercal_stock_programas'] && $movement['type'] == 'despacho';
            });
            $recepcionado = array_filter($movements, function($movement) use ($programa) {
                return $movement['programa_id'] == $programa['id_mercal_stock_programas'] && $movement['type'] == 'recepcion';
            });

            $despachado = array_values($despachado);
            $recepcionado = array_values($recepcionado);
            
            $data_return[] = array(
                'id_mercal_stock_programas' => $programa['id_mercal_stock_programas'], // Se agrega para poder editar el stock desde el modal 'Editar Stock
                'programa' => $programa['programa'],
                'code_clave' => $programa['code_clave'],
                'stock_proteina' => $programa['stock_proteina'],
                'stock_bolsas' => $programa['stock_bolsas'],
                'proteina_despachada' => isset($despachado[0]['suma_proteina']) ? $despachado[0]['suma_proteina'] : 0,
                'bolsas_despachadas' => isset($despachado[0]['suma_bolsas']) ? $despachado[0]['suma_bolsas'] : 0,
                'proteina_recepcionada' => isset($recepcionado[0]['suma_proteina']) ? $recepcionado[0]['suma_proteina'] : 0,
                'bolsas_recepcionadas' => isset($recepcionado[0]['suma_bolsas']) ? $recepcionado[0]['suma_bolsas'] : 0,
            );
        }


        // incluir la librería de TCPDF
        require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';

        class MYPDF extends TCPDF {

            //Page header
            public function Header() {
                // Logo
                // $image_file = K_PATH_IMAGES.'logo_example.jpg';
                $now = date('d/m/Y');
                $image_file = 'C:/xampp/htdocs/minppal_sala/public/images/logo.png';
                $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', 'B', 8);
                // Title
                $this->Cell(0, 15, '  Ministerio del Poder Popular para la Alimentación');
                $this->Cell(0, 15, 'Fecha de creación: ' . $now, 0, false, 'R', 0, '', 0, false, 'T', 'M');
                // Nuevo titulo con una letra un poco mas grande y que este centrado y que ocupe todo el ancho de la pagina
                $this->Ln(10);
                $this->SetFont('helvetica', 'B', 20);
                // Pintar una línea roja de la longitud completa de la celda
                $this->Line(10, 26, 210-10, 26, array('width' => 0.1, 'color' => array(255, 0, 0)));
                // Margin inferior
                $this->SetMargins(10, 30, 10);
            }
        
            // Page footer
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                // Page number
                // Colocar el numero de pagina en la esquina inferior derecha
                $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        }

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MINPPAL');
        $pdf->SetTitle('MERCAL - Programas Sociales');
        $pdf->SetSubject('MERCAL - Programas Sociales');
        $pdf->SetKeywords('MERCAL, Programas, Sociales');
        
        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte Mercal - Programas Sociales', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($start)) . ' - Hasta: ' . date('d/m/Y', strtotime($end)), 0, 1, 'C');
        $pdf->Ln(2);

        $html_tablas_por_programa = '';

        foreach ($data_return as $programa) {
            $html_tablas_por_programa .= '
            <h6 style="text-align: center; color: #001640; font-size: 12px">' . $programa['programa'] . '</h6>
            <table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Stock Proteina</th>
                        <th class="description">Stock Bolsas</th>
                        <th class="description">Proteina Recepcionada</th>
                        <th class="description">Proteina Despachada</th>
                        <th class="description">Bolsas Recepcionadas</th>
                        <th class="description">Bolsas Despachadas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td class="description">' . number_format($programa['stock_proteina'], 2, ',', '.') . ' TON</td>
                        <td class="description">' . number_format($programa['stock_bolsas'], 0, ',', '.') . '</td>
                        <td class="description">' . number_format($programa['proteina_recepcionada'], 2, ',', '.') . ' TON</td>
                        <td class="description">' . number_format($programa['proteina_despachada'], 2, ',', '.') . ' TON</td>
                        <td class="description">' . number_format($programa['bolsas_recepcionadas'], 0, ',', '.') . '</td>
                        <td class="description">' . number_format($programa['bolsas_despachadas'], 0, ',', '.') . '</td>
                    </tr>
                </tbody>
            </table>
            ';
        }

        $pdf->writeHTML($html_tablas_por_programa, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output('reporte_mercal_programas.pdf', 'I');

    } catch (\Throwable $th) {
        
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}

function Export_Pdf_Mercal_Por_Programa ($id) {
    try {
        require_once 'src/database/connection.php';
        
        $sql = "SELECT * FROM mercal_stock_programas WHERE id_mercal_stock_programas = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $programa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$programa) {
            header('Location: /admin/mercal');
            exit();
        }

        // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
        $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
        $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');
        $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all';

        $sql_movimientos = "SELECT * FROM mercal_recepcion_despacho WHERE programa_id = :id ";
        if ($filter_type != 'all') {
            $sql_movimientos .= "AND type = '$filter_type' ";
        }
        $sql_movimientos .= "AND fecha BETWEEN :start AND :end ORDER BY fecha ASC";
        $stmt = $conn->prepare($sql_movimientos);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':start', $start);
        $stmt->bindValue(':end', $end);
        $stmt->execute();
        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // incluir la librería de TCPDF
        require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';

        class MYPDF extends TCPDF {

            //Page header
            public function Header() {
                // Logo
                // $image_file = K_PATH_IMAGES.'logo_example.jpg';
                $now = date('d/m/Y');
                $image_file = 'C:/xampp/htdocs/minppal_sala/public/images/logo.png';
                $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', 'B', 8);
                // Title
                $this->Cell(0, 15, '  Ministerio del Poder Popular para la Alimentación');
                $this->Cell(0, 15, 'Fecha de creación: ' . $now, 0, false, 'R', 0, '', 0, false, 'T', 'M');
                // Nuevo titulo con una letra un poco mas grande y que este centrado y que ocupe todo el ancho de la pagina
                $this->Ln(10);
                $this->SetFont('helvetica', 'B', 20);
                // Pintar una línea roja de la longitud completa de la celda
                $this->Line(10, 26, 210-10, 26, array('width' => 0.1, 'color' => array(255, 0, 0)));
                // Margin inferior
                $this->SetMargins(10, 30, 10);
            }
        
            // Page footer
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                // Page number
                // Colocar el numero de pagina en la esquina inferior derecha
                $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        }

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MINPPAL');
        $pdf->SetTitle('MERCAL - Programas Sociales');
        $pdf->SetSubject('MERCAL - Programas Sociales');
        $pdf->SetKeywords('MERCAL, Programas, Sociales');
        
        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte Mercal - Programas Sociales', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 10, $programa['programa'], 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($start)) . ' - Hasta: ' . date('d/m/Y', strtotime($end)), 0, 1, 'C');
        // $pdf->Ln(-1);
        $pdf->Cell(0, 0, 'Stock actual de proteína: ' . number_format($programa['stock_proteina'], 2, ',', '.') . ' TON', 0, 1, 'C');
        // $pdf->Ln(-2);
        $pdf->Cell(0, 10, 'Stock actual de bolsas: ' . number_format($programa['stock_bolsas'], 0, ',', '.'), 0, 1, 'C');

        $html_tablas_por_programa = '<table border="1" cellpadding="4">
        <thead>
            <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                <th class="description">Tipo</th>
                <th class="description">Cantidad de Proteína</th>
                <th class="description">Cantidad de Bolsas</th>
                <th class="description">Fecha</th>
                <th class="description">Registrado el</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($movimientos as $mov) {
            $html_tablas_por_programa .= '
            
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td class="description">
                    '.($mov["type"] == 'recepcion' ? '<a style="color: #001640;text-decoration: none;"
                    ><b>Recepción</b></a>' : '<a style="color: #750000;text-decoration: none;"
                    ><b>Despacho</b></a>' ).
                    '</td>
                    <td class="description">' . number_format($mov['cantidad_proteina'], 2, ',', '.') . ' TON</td>
                    <td class="description">' . number_format($mov['cantidad_bolsas'], 0, ',', '.') . '</td>
                    <td class="description">' . date('d/m/Y', strtotime($mov['fecha'])) . '</td>
                    <td class="description">' . date('d/m/Y', strtotime($mov['createdAt'])) . '</td>
                </tr>
            ';
        }

        $html_tablas_por_programa .= '</tbody></table>';

        $pdf->writeHTML($html_tablas_por_programa, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output('reporte_mercal_programa_' . $programa['programa'] . '.pdf', 'I');

    } catch (\Throwable $th) {
        //throw $th;
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}