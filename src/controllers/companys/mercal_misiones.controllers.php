<?php

function Create_Parroquias () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para crear los municipios');
        }

        require 'src/database/connection.php';

        $sql_parroquias = "SELECT * FROM parroquias";
        $result_parroquias = $conn->prepare($sql_parroquias);
        $result_parroquias->execute();
        $parroquias = $result_parroquias->fetchAll(PDO::FETCH_ASSOC);

        if (count($parroquias) > 0) {
            throw new Exception('Ya hay parroquias creados');
        }

        $sql_municipios = "SELECT * FROM municipios";
        $result_municipios = $conn->prepare($sql_municipios);
        $result_municipios->execute();
        $municipios = $result_municipios->fetchAll(PDO::FETCH_ASSOC);

        if (count($municipios) == 0) {
            throw new Exception('No hay municipios creados');
        }

        $parroquiasCreate = [
            [
                'municipio' => 'Falcón',
                'parroquia' => 'Moruy',
            ],
            [
                'municipio' => 'Falcón',
                'parroquia' => 'El Vinculo',
            ],
            [
                'municipio' => 'Silva',
                'parroquia' => 'Tucacas',
            ],
            [
                'municipio' => 'Federación',
                'parroquia' => 'Agua Larga',
            ],
            [
                'municipio' => 'Miranda',
                'parroquia' => 'San Antonio',
            ],
            [
                'municipio' => 'Píritu',
                'parroquia' => 'Píritu',
            ],
            [
                'municipio' => 'Colina',
                'parroquia' => 'La Vela',
            ],
            [
                'municipio' => 'Mauroa',
                'parroquia' => 'Casigua',
            ],
            [
                'municipio' => 'Carirubana',
                'parroquia' => 'Carirubana',
            ],
            [
                'municipio' => 'Los Taques',
                'parroquia' => 'Judibana',
            ],
            [
                'municipio' => 'San Francisco',
                'parroquia' => 'Mirimire',
            ],
            [
                'municipio' => 'Jacura',
                'parroquia' => 'Jacura',
            ],
            [
                'municipio' => 'Jacura',
                'parroquia' => 'Agua Linda',
            ],
            [
                'municipio' => 'Urumaco',
                'parroquia' => 'Buzual',
            ],
            [
                'municipio' => 'Buchivacoa',
                'parroquia' => 'Capatarida',
            ],
            [
                'municipio' => 'Unión',
                'parroquia' => 'Vegas del Tuy',
            ],
            [
                'municipio' => 'Carirubana',
                'parroquia' => 'Norte',
            ],
            [
                'municipio' => 'Democracia',
                'parroquia' => 'Avaria',
            ],
            [
                'municipio' => 'Monseñor Iturriza',
                'parroquia' => 'Chichirivichi',
            ],
            [
                'municipio' => 'Petit',
                'parroquia' => 'Cabure',
            ],
            [
                'municipio' => 'Petit',
                'parroquia' => 'Colina',
            ],
            [
                'municipio' => 'Bolívar',
                'parroquia' => 'San Luis',
            ],
            [
                'municipio' => 'Democracia',
                'parroquia' => 'Pedregal',
            ],
            [
                'municipio' => 'Zamora',
                'parroquia' => 'Puerto Cumarebo',
            ],
            [
                'municipio' => 'Dabajuro',
                'parroquia' => 'Dabajuro',
            ],
            [
                'municipio' => 'Unión',
                'parroquia' => 'El Chral',
            ],
            [
                'municipio' => 'Palmasola',
                'parroquia' => 'Palmasola',
            ],
            [
                'municipio' => 'Tocópero',
                'parroquia' => 'Tocópero',
            ],
            [
                'municipio' => 'Carirubana',
                'parroquia' => 'Punta Cardon',
            ],
            [
                'municipio' => 'Sucre',
                'parroquia' => 'Pecaya',
            ],
            [
                'municipio' => 'Acosta',
                'parroquia' => 'La Pastora',
            ],
        ];

        foreach ($parroquiasCreate as $parr) {
            // Busca en el array de municipios el municipio que coincida con el nombre
            $municipioNow = array_filter($municipios, function ($municipio) use ($parr) {
                return $municipio['name_municipio'] == $parr['municipio'];
            });

            // Si el municipio existe
            if (count($municipioNow) > 0) {
                // Obtiene el id del municipio
                $municipioNow = array_values($municipioNow)[0]['id_municipio'];

                // Crea la parroquia
                $insert_sql = "INSERT INTO parroquias (name_parroquia, municipio_id) VALUES ('{$parr['parroquia']}', {$municipioNow})";
                $insert = $conn->prepare($insert_sql);
                $insert->execute();
            }
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

function Create_Bases_Misiones () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para crear los municipios');
        }

        require 'src/database/connection.php';

        $sql_misiones = "SELECT * FROM base_de_mision";
        $misiones = $conn->prepare($sql_misiones);
        $misiones->execute();
        $misiones = $misiones->fetchAll(PDO::FETCH_ASSOC);

        if (count($misiones) > 0) {
            throw new Exception('Ya existen bases de misiones');
        }

        $sql_parroquias = "SELECT * FROM parroquias";
        $parroquias = $conn->prepare($sql_parroquias);
        $parroquias->execute();
        $parroquias = $parroquias->fetchAll(PDO::FETCH_ASSOC);

        if (count($parroquias) == 0) {
            throw new Exception('No existen parroquias');
        }

        $basesCreate = [
            [
                'parroquia' => 'Moruy',
                'base' => 'BSM EL MOREARY',
            ],
            [
                'parroquia' => 'El Vinculo',
                'base' => 'BSM SIEMBRA DEL GIGANTE',
            ],
            [
                'parroquia' => 'El Vinculo',
                'base' => 'BSM NUESTRA HEROÍNA JOSEFA CAMEJO',
            ],
            [
                'parroquia' => 'Tucacas',
                'base' => 'BSM CARMEN QUEVEDO',
            ],
            [
                'parroquia' => 'Agua Larga',
                'base' => 'BSM INDEPEDENCIA',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'HUGO CHAVEZ FRIAS',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'LOS CAQUETIOS DE LIBERTADORES',
            ],
            [
                'parroquia' => 'Píritu',
                'base' => 'VALENTIN MENDOZA',
            ],
            [
                'parroquia' => 'Píritu',
                'base' => 'ALI PRIMERA',
            ],
            [
                'parroquia' => 'La Vela',
                'base' => 'EL HEROICO COMANDANTE CHAVEZ',
            ],
            [
                'parroquia' => 'Casigua',
                'base' => 'BSM GIGANTE DE AMERICA',
            ],
            [
                'parroquia' => 'Casigua',
                'base' => 'BSM JEHOVA YIRETH',
            ],
            [
                'parroquia' => 'Carirubana',
                'base' => 'BSM LUCHADORES DE LA PATRIA',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'GRAN MARISCAL DE AYACUCHO',
            ],
            [
                'parroquia' => 'Judibana',
                'base' => 'MAMA PANCHA',
            ],
            [
                'parroquia' => 'Mirimire',
                'base' => 'COMANDANTE ETERNO',
            ],
            [
                'parroquia' => 'Jacura',
                'base' => 'BSM HOY LA PATRIA AVANZA',
            ],
            [
                'parroquia' => 'Jacura',
                'base' => 'BSM INDIO MANAURE',
            ],
            [
                'parroquia' => 'Agua Linda',
                'base' => 'BMS ERASMO PACHECO',
            ],
            [
                'parroquia' => 'Buzual',
                'base' => 'CHE GUEVARA',
            ],
            [
                'parroquia' => 'Agua Larga',
                'base' => 'BSM AGUA LARGA',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'SIMON BOLIVAR',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => '4 DE FEBRERO',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'BSM EZEQUIEL ZAMORA',
            ],
            [
                'parroquia' => 'Capatarida',
                'base' => 'BSM CHE GUEVARA',
            ],
            [
                'parroquia' => 'Vegas del Tuy',
                'base' => 'BSM MARIA CRISTINA DE BELLO',
            ],
            [
                'parroquia' => 'San Antonio',
                'base' => 'BSM EL SUEÑO DEL COMANDANTE',
            ],
            [
                'parroquia' => 'Norte',
                'base' => 'SANTA ROSALIA',
            ],
            [
                'parroquia' => 'Avaria',
                'base' => 'BSM FUERZA TRIUNFADORA DE AVARIA',
            ],
            [
                'parroquia' => 'Chichirivichi',
                'base' => 'BSM 4F HUGO CHAVEZ',
            ],
            [
                'parroquia' => 'Chichirivichi',
                'base' => 'BSM NUEVA REVOLUCION',
            ],
            [
                'parroquia' => 'Cabure',
                'base' => 'BMS EL URUPAGUAL',
            ],
            [
                'parroquia' => 'Colina',
                'base' => 'BSM JOSE LEONARDO CHIRINOS',
            ],
            [
                'parroquia' => 'San Luis',
                'base' => 'BSM LUIS LUGO',
            ],
            [
                'parroquia' => 'Pedregal',
                'base' => 'BSM EBENEZER',
            ],
            [
                'parroquia' => 'Puerto Cumarebo',
                'base' => 'BSM JOSEFA CAMEJO',
            ],
            [
                'parroquia' => 'Dabajuro',
                'base' => 'BMS VANGUARDIA DEL OCCIDENTE',
            ],
            [
                'parroquia' => 'El Chral',
                'base' => 'BSM MANUELA SAENZ',
            ],
            [
                'parroquia' => 'Palmasola',
                'base' => 'BSM DR. HENRY VENTURA',
            ],
            [
                'parroquia' => 'Tocópero',
                'base' => 'BSM ADA WALTER',
            ],
            [
                'parroquia' => 'Tocópero',
                'base' => 'BSM ADA ROMERO',
            ],
            [
                'parroquia' => 'Punta Cardon',
                'base' => 'EL AMANECER DE CHAVEZ EN SU COSECHA',
            ],
            [
                'parroquia' => 'Pecaya',
                'base' => 'ANTONIO JOSE DE SUCRE',
            ],
            [
                'parroquia' => 'La Pastora',
                'base' => 'BSM ENTRE MAR Y SERRANIA',
            ],
        ];

        foreach ($basesCreate as $base) {
            $parroquiaNow = array_filter($parroquias, function ($parroquia) use ($base) {
                return $parroquia['name_parroquia'] == $base['parroquia'];
            });

            if (count($parroquiaNow) > 0) {
               // Obtiene el id del municipio
               $parroquiaNow = array_values($parroquiaNow)[0]['id_parroquias'];

               // Crea la parroquia
               $insert_sql = "INSERT INTO base_de_mision (parroquia_id , name_mision, cantidad_familias) VALUES ($parroquiaNow, '{$base['base']}', 0)";
               $insert = $conn->prepare($insert_sql);
               $insert->execute();
            }
        }

        echo json_encode(array(
            'success' => true
        ));

    } catch (\Throwable $th) {
        echo json_encode(array(
            'error' => $th->getMessage()
        ));
    }
}

function Mercal_Misiones_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    $sql_misiones = "SELECT * FROM base_de_mision 
                    LEFT JOIN parroquias ON base_de_mision.parroquia_id = parroquias.id_parroquias
                    LEFT JOIN municipios ON parroquias.municipio_id = municipios.id_municipio
                    ORDER BY id_base_de_mision ASC LIMIT $offset, $limit";
    $sql_misiones = $conn->prepare($sql_misiones);
    $sql_misiones->execute();
    $misiones = $sql_misiones->fetchAll();

    // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
    $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
    $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');

    $sql_entregas = "SELECT base_de_mision_id,
                    SUM(proteina_entregada) as proteina_entregada, 
                    SUM(clap_entregado) as clap_entregado
                    FROM entrega_mision_mercal 
                    WHERE fecha_entrega BETWEEN '$start' AND '$end' 
                    GROUP BY base_de_mision_id
                    ORDER BY id_entrega_mision_mercal DESC";
    $sql_entregas = $conn->prepare($sql_entregas);
    $sql_entregas->execute();
    $entregas = $sql_entregas->fetchAll();

    $data_return = array();

    foreach ($misiones as $mision) {
        // Busca si en $entregas hay un base_de_mision_id igual al id_base_de_mision de $mision
        $entregasNow = array_filter($entregas, function($entrega) use ($mision) {
            return $entrega['base_de_mision_id'] == $mision['id_base_de_mision'];
        });

        $entregasNow = array_values($entregasNow);

        $data_return[] = array(
            'id_base_de_mision' => $mision['id_base_de_mision'],
            'name_mision' => $mision['name_mision'],
            'parroquia_id' => $mision['parroquia_id'],
            'cantidad_familias' => $mision['cantidad_familias'],
            'name_parroquia' => $mision['name_parroquia'],
            'name_municipio' => $mision['name_municipio'],
            'proteina_entregada' => isset($entregasNow[0]) ? $entregasNow[0]['proteina_entregada'] : 0,
            'clap_entregado' => isset($entregasNow[0]) ? $entregasNow[0]['clap_entregado'] : 0,
        );
    }

    // Obtener el total
    $sql_total = "SELECT COUNT(*) AS total FROM base_de_mision";
    $result_total = $conn->prepare($sql_total);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - MERCAL';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal_bm/mercal_bm_viewer.php';
    include_once 'src/blocks/footer.php';
}

function Mercal_Misiones_Edit ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $sql_mision = "SELECT bm.id_base_de_mision, bm.name_mision, bm.cantidad_familias, p.name_parroquia, m.name_municipio
                    FROM base_de_mision as bm 
                    LEFT JOIN parroquias as p ON bm.parroquia_id = p.id_parroquias
                    LEFT JOIN municipios as m ON p.municipio_id = m.id_municipio
                    WHERE id_base_de_mision = $id";
    $sql_mision = $conn->prepare($sql_mision);
    $sql_mision->execute();
    $mision = $sql_mision->fetch();

    $title = 'MINPPAL - MERCAL';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal_bm/mercal_bm_edicion.php';
    include_once 'src/blocks/footer.php';   
}

function Mercal_Misiones_Put () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            header('Location: /login');
            exit();
        }

        require 'src/database/connection.php';

        if (!isset($_POST['id_mision'])) {
            throw new Exception('La misión no es válida');
        }

        if (!is_numeric($_POST['id_mision'])) {
            throw new Exception('La misión no es válida');
        }

        $id_mision = $_POST['id_mision'];
        $sql_mision = "SELECT * FROM base_de_mision WHERE id_base_de_mision = $id_mision";
        $sql_mision = $conn->prepare($sql_mision);
        $sql_mision->execute();
        $mision = $sql_mision->fetch(PDO::FETCH_ASSOC);

        if (!$mision) {
            throw new Exception('La misión no es válida');
        }

        if (!isset($_POST['familias'])) {
            throw new Exception('La cantidad de familias no es válida');
        }

        if (!is_numeric($_POST['familias'])) {
            throw new Exception('La cantidad de familias no es válida');
        }

        if ($_POST['familias'] < 0) {
            throw new Exception('La cantidad de familias no es válida');
        }

        $familias = $_POST['familias'];

        $sql_update = "UPDATE base_de_mision SET cantidad_familias = $familias WHERE id_base_de_mision = $id_mision";
        $sql_update = $conn->prepare($sql_update);
        $sql_update->execute();

        echo json_encode(array(
            'status' => 'ok',
            'message' => 'La cantidad de familias se ha actualizado correctamente'
        ));

    } catch (\Throwable $th) {
        //throw $th;
        echo json_encode(array(
            'status' => 'error',
            'error' => $th->getMessage()
        ));

        http_response_code(400); 
    }
}

function Mercal_Misiones_Detalle ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    $sql_mision = "SELECT bm.id_base_de_mision, bm.name_mision, bm.cantidad_familias, p.name_parroquia, m.name_municipio
                    FROM base_de_mision as bm 
                    LEFT JOIN parroquias as p ON bm.parroquia_id = p.id_parroquias
                    LEFT JOIN municipios as m ON p.municipio_id = m.id_municipio
                    WHERE id_base_de_mision = $id";
    $sql_mision = $conn->prepare($sql_mision);
    $sql_mision->execute();
    $mision = $sql_mision->fetch(PDO::FETCH_ASSOC);

    // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
    $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
    $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');

    $sql_entregas = "SELECT * FROM entrega_mision_mercal WHERE base_de_mision_id = $id AND fecha_entrega 
                    BETWEEN '$start' AND '$end' ORDER BY fecha_entrega ASC LIMIT $offset, $limit";
    $sql_entregas = $conn->prepare($sql_entregas);
    $sql_entregas->execute();
    $entregas = $sql_entregas->fetchAll(PDO::FETCH_ASSOC);

    $sql_total = "SELECT COUNT(*) as total FROM entrega_mision_mercal WHERE base_de_mision_id = $id AND fecha_entrega BETWEEN '$start' AND '$end'";
    $sql_total = $conn->prepare($sql_total);
    $sql_total->execute();
    $total = $sql_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - MERCAL - '.$mision['name_mision'];
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal_bm/mercal_bm_detalle.php';
    include_once 'src/blocks/footer.php';
}

function Mercal_Misiones_Load () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $sql_misiones = "SELECT bm.id_base_de_mision, bm.name_mision, bm.cantidad_familias, p.name_parroquia, m.name_municipio
                    FROM base_de_mision as bm 
                    LEFT JOIN parroquias as p ON bm.parroquia_id = p.id_parroquias
                    LEFT JOIN municipios as m ON p.municipio_id = m.id_municipio";
    $sql_misiones = $conn->prepare($sql_misiones);
    $sql_misiones->execute();
    $misiones = $sql_misiones->fetchAll(PDO::FETCH_ASSOC);

    $title = 'MINPPAL - MERCAL - Nueva entrega';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/mercal_bm/mercal_bm_load.php';
    include_once 'src/blocks/footer.php';
}

function Mercal_Misiones_Load_Post () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            header('Location: /login');
            exit();
        }

        require 'src/database/connection.php';

        if (!isset($_POST['id_mision'])) {
            throw new Exception('La base de mision no es válida');
        }

        if (!is_numeric($_POST['id_mision'])) {
            throw new Exception('La base de mision no es válida');
        }

        $id_mision = $_POST['id_mision'];
        $sql_mision = "SELECT * FROM base_de_mision WHERE id_base_de_mision = $id_mision";
        $sql_mision = $conn->prepare($sql_mision);
        $sql_mision->execute();
        $mision = $sql_mision->fetch(PDO::FETCH_ASSOC);

        if (!$mision) {
            throw new Exception('La base de mision no es válida');
        }

        if (!isset($_POST['fecha']) || !isset($_POST['proteina']) || !isset($_POST['clap'])) { 
            throw new Exception('Todos los campos son obligatorios');
        }

        if (!is_numeric($_POST['proteina']) || !is_numeric($_POST['clap'])) {
            throw new Exception('Los campos deben ser numéricos');
        }

        if ($_POST['proteina'] < 0 || $_POST['clap'] < 0) {
            throw new Exception('Datos no válidos');
        }

        if ($_POST['proteina'] == 0 && $_POST['clap'] == 0) {
            throw new Exception('Debe ingresar al menos un dato');
        }

        // La fecha debe ser menor o igual a la fecha actual
        if ($_POST['fecha'] > date('Y-m-d')) {
            throw new Exception('La fecha no puede ser mayor a la fecha actual');
        }

        $fecha = $_POST['fecha'];
        $proteina = addslashes(trim($_POST['proteina']));
        $clap = addslashes(trim($_POST['clap']));

        // La proteina viene en kilos, se debe convertir a toneladas
        $proteina = $proteina / 1000;

        $sql_insert = "INSERT INTO entrega_mision_mercal (base_de_mision_id, fecha_entrega, proteina_entregada, clap_entregado, user_id) VALUES ($id_mision, '$fecha', $proteina, $clap, {$_SESSION['id']})";
        $sql_insert = $conn->prepare($sql_insert);
        $sql_insert->execute();

        echo json_encode(array(
            'status' => 'ok',
            'message' => 'La entrega se ha registrado correctamente'
        ));

    } catch (\Throwable $th) {
        //throw $th;
        echo json_encode(array(
            'status' => 'error',
            'error' => $th->getMessage()
        ));

        http_response_code(400); 
    }
}

function Mercal_Misiones_Export_Pdf () {
    try {
        require_once 'src/database/connection.php';

        $sql_misiones = "SELECT * FROM base_de_mision 
                    LEFT JOIN parroquias ON base_de_mision.parroquia_id = parroquias.id_parroquias
                    LEFT JOIN municipios ON parroquias.municipio_id = municipios.id_municipio
                    ORDER BY id_base_de_mision ASC";
        $sql_misiones = $conn->prepare($sql_misiones);
        $sql_misiones->execute();
        $misiones = $sql_misiones->fetchAll();

        // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
        $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
        $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');

        $sql_entregas = "SELECT base_de_mision_id,
                        SUM(proteina_entregada) as proteina_entregada, 
                        SUM(clap_entregado) as clap_entregado
                        FROM entrega_mision_mercal 
                        WHERE fecha_entrega BETWEEN '$start' AND '$end' 
                        GROUP BY base_de_mision_id
                        ORDER BY id_entrega_mision_mercal DESC";
        $sql_entregas = $conn->prepare($sql_entregas);
        $sql_entregas->execute();
        $entregas = $sql_entregas->fetchAll();

        $data_return = array();

        foreach ($misiones as $mision) {
            // Busca si en $entregas hay un base_de_mision_id igual al id_base_de_mision de $mision
            $entregasNow = array_filter($entregas, function($entrega) use ($mision) {
                return $entrega['base_de_mision_id'] == $mision['id_base_de_mision'];
            });

            $entregasNow = array_values($entregasNow);

            $data_return[] = array(
                'id_base_de_mision' => $mision['id_base_de_mision'],
                'name_mision' => $mision['name_mision'],
                'parroquia_id' => $mision['parroquia_id'],
                'cantidad_familias' => $mision['cantidad_familias'],
                'name_parroquia' => $mision['name_parroquia'],
                'name_municipio' => $mision['name_municipio'],
                'proteina_entregada' => isset($entregasNow[0]) ? $entregasNow[0]['proteina_entregada'] : 0,
                'clap_entregado' => isset($entregasNow[0]) ? $entregasNow[0]['clap_entregado'] : 0,
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
        $pdf->SetTitle('MERCAL - Bases de Misiones');
        $pdf->SetSubject('MERCAL - Bases de Misiones');
        $pdf->SetKeywords('MERCAL, Bases de Misiones');
        
        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte Mercal - Bases de Misiones', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($start)) . ' - Hasta: ' . date('d/m/Y', strtotime($end)), 0, 1, 'C');
        $pdf->Ln(2);

        $html_tablas_por_mision = '';

        foreach ($data_return as $mision) {
            $html_tablas_por_mision .= '
            <h6 style="text-align: center; color: #001640; font-size: 12px">' . $mision['name_mision'] . '</h6>
            <table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Municipio</th>
                        <th class="description">Parroquia</th>
                        <th class="description">Base de Mision</th>
                        <th class="description">Familias</th>
                        <th class="description">Proteína Entregada</th>
                        <th class="description">Claps Entregados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td class="description">' . $mision['name_municipio'] . '</td>
                        <td class="description">' . $mision['name_parroquia'] . '</td>
                        <td class="description">' . $mision['name_mision'] . '</td>
                        <td class="description">' . number_format($mision['cantidad_familias'], 0, ',', '.') . '</td>
                        <td class="description">' . number_format($mision['proteina_entregada'], 2, ',', '.') . ' TON</td>
                        <td class="description">' . number_format($mision['clap_entregado'], 0, ',', '.') . '</td>
                    </tr>
                </tbody>
            </table>
            ';
        }

        $pdf->writeHTML($html_tablas_por_mision, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output('reporte_mercal_misiones.pdf', 'I');

    } catch (\Throwable $th) {
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}

function Mercal_Misiones_Detalle_Export_Pdf ($id) {
    try {
        require_once 'src/database/connection.php';

        $sql_mision = "SELECT bm.id_base_de_mision, bm.name_mision, bm.cantidad_familias, p.name_parroquia, m.name_municipio
                    FROM base_de_mision as bm 
                    LEFT JOIN parroquias as p ON bm.parroquia_id = p.id_parroquias
                    LEFT JOIN municipios as m ON p.municipio_id = m.id_municipio
                    WHERE id_base_de_mision = $id";
        $sql_mision = $conn->prepare($sql_mision);
        $sql_mision->execute();
        $mision = $sql_mision->fetch(PDO::FETCH_ASSOC);

        // Si no viene start o end se toma el mes actual, es decir el primer y ultimo dia del mes
        $start = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
        $end = isset($_GET['end']) ? $_GET['end'] : date('Y-m-t');

        $sql_entregas = "SELECT * FROM entrega_mision_mercal WHERE base_de_mision_id = $id AND fecha_entrega 
                        BETWEEN '$start' AND '$end' ORDER BY fecha_entrega ASC";
        $sql_entregas = $conn->prepare($sql_entregas);
        $sql_entregas->execute();
        $entregas = $sql_entregas->fetchAll(PDO::FETCH_ASSOC);

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
        $pdf->SetTitle('MERCAL - Bases de Misiones - ' . $mision['name_mision']);
        $pdf->SetSubject('MERCAL - Bases de Misiones - ' . $mision['name_mision']);
        $pdf->SetKeywords('MERCAL, Bases de Misiones, ' . $mision['name_mision']);
        
        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte Mercal - ' . $mision['name_mision'], 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Municipio: ' . $mision['name_municipio'] . ' - Parroquia: ' . $mision['name_parroquia'], 0, 1, 'C');
        $pdf->Cell(0, 10, 'Cantidad de familias: ' . number_format($mision['cantidad_familias'], 0, ',', '.'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($start)) . ' - Hasta: ' . date('d/m/Y', strtotime($end)), 0, 1, 'C');
        $pdf->Ln(2);

        $html_tablas_por_programa = '<table border="1" cellpadding="4">
            <thead>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Proteína Entregada</th>
                    <th class="description">Claps Entregados</th>
                    <th class="description">Fecha de entrega</th>
                    <th class="description">Registrado el</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($entregas as $entrega) {
            $html_tablas_por_programa .= '<tr style="font-size: 7px;">
                <td class="description" style="text-align: center;">' . number_format($entrega['proteina_entregada'], 2, ',', '.') . ' TON</td>
                <td class="description" style="text-align: center;">' . number_format($entrega['clap_entregado'], 0, ',', '.') . '</td>
                <td class="description" style="text-align: center;">' . date('d/m/Y', strtotime($entrega['fecha_entrega'])) . '</td>
                <td class="description" style="text-align: center;">' . date('d/m/Y', strtotime($entrega['created_at'])) . '</td>
            </tr>';
        }

        if (count($entregas) == 0) {
            $html_tablas_por_programa .= '<tr style="font-size: 7px;">
                <td class="description" colspan="4" style="text-align: center;">No hay datos para mostrar</td>
            </tr>';
        }

        $html_tablas_por_programa .= '</tbody></table>';

        $pdf->writeHTML($html_tablas_por_programa, true, false, false, false, '');

        ob_end_clean();
        $pdf->Output('reporte_mercal_' . $mision['name_mision'] . '.pdf', 'I');
    } catch (\Throwable $th) {
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}