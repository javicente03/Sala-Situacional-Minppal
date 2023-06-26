<?php

function Create_Entrega () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    $title = 'MINPPAL - Registro de nueva jornada de entrega';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/clap/clap_create_entrega.php';
    include_once 'src/blocks/footer.php';
}

function POST_Entrega () {
    try {
        // Si no es admin, no puede actualizar
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        $desde = addslashes($_POST['desde']);
        $hasta = addslashes($_POST['hasta']);

        if (empty($desde) || empty($hasta)) {
            throw new Exception('Debe llenar todos los campos');
        }

        // Validar que la fecha de inicio no sea mayor a la fecha de fin
        if ($desde > $hasta) {
            throw new Exception('La fecha de inicio no puede ser mayor a la fecha de fin');
        }

        require 'src/database/connection.php';

        $sql = "INSERT INTO clap_por_entrega (fecha_inicio_entrega, fecha_fin_entrega) VALUES ('$desde', '$hasta')";
        $result = $conn->prepare($sql);
        $result->execute();
        $new_clap = $conn->lastInsertId();

        $municipios = $conn->query("SELECT * FROM municipios")->fetchAll(PDO::FETCH_ASSOC);

        // INSERT INTO `clap_por_municipio` (`id_clap_por_municipio`, `entrega_clap_id`, `municipio_id`, `precio`, `fecha_cobro`, `fecha_despacho`, `comercializadora`) VALUES ('1', '1', '2', '0.00', NULL, NULL, '');
        foreach ($municipios as $municipio) {
            $sql = "INSERT INTO clap_por_municipio (entrega_clap_id, municipio_id) VALUES ($new_clap, {$municipio['id_municipio']})";
            $result = $conn->prepare($sql);
            $result->execute();
        }

        echo json_encode([
            'status' => 'ok',
            'message' => 'Jornada de entrega registrada con éxito',
            'redirectId' => $new_clap
        ]);

    } catch (\Throwable $th) {
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}

function Clap_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT clap_por_entrega.*, SUM(clap_carga.cantidad) as beneficios_entregados
        FROM clap_por_entrega 
        LEFT JOIN clap_por_municipio ON clap_por_entrega.id_clap_por_entrega = clap_por_municipio.entrega_clap_id
        LEFT JOIN clap_carga ON clap_por_municipio.id_clap_por_municipio = clap_carga.clap_por_municipio_id
        GROUP BY clap_por_entrega.id_clap_por_entrega
        ORDER BY clap_por_entrega.id_clap_por_entrega DESC LIMIT $offset, $limit";
    $result = $conn->prepare($sql);
    $result->execute();
    $claps = $result->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT COUNT(*) as total FROM clap_por_entrega";
    $result = $conn->prepare($sql);
    $result->execute();
    $total = $result->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - CLAP';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/clap/clap_viewer.php';
    include_once 'src/blocks/footer.php';
}

function Clap_Custom ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    if (!is_numeric($id)) {
        header('Location: /admin/clap');
        exit();
    }

    require 'src/database/connection.php';

    $sql = "SELECT * FROM clap_por_entrega WHERE id_clap_por_entrega = $id";
    $result = $conn->prepare($sql);
    $result->execute();
    $clap = $result->fetch(PDO::FETCH_ASSOC);

    if (!$clap) {
        header('Location: /admin/clap');
        exit();
    }

    $sql = "SELECT * FROM clap_por_municipio 
    LEFT JOIN municipios ON clap_por_municipio.municipio_id = municipios.id_municipio
    WHERE entrega_clap_id = $id";
    $result = $conn->prepare($sql);
    $result->execute();
    $municipios = $result->fetchAll(PDO::FETCH_ASSOC);

    $title = 'MINPPAL - CLAP - ' . $id;
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/clap/clap_custom.php';
    include_once 'src/blocks/footer.php';
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function POST_Clap_Custom () {
    try {
        // Si no es admin, no puede actualizar
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        $id = addslashes($_POST['id_clap_por_entrega']);

        if (empty($id)) {
            throw new Exception('Debe llenar todos los campos');
        }

        require 'src/database/connection.php';

        $sql = "SELECT * FROM clap_por_entrega WHERE id_clap_por_entrega = $id";
        $result = $conn->prepare($sql);
        $result->execute();
        $clap = $result->fetch(PDO::FETCH_ASSOC);

        if (!$clap) {
            throw new Exception('No se encontró la jornada de entrega');
        }

        // Llega algo como esto
        // id_clap_por_entrega=5&fecha_cobro_2=&fecha_despacho_2=&precio_2=0.00&comercializadora_2=&fecha_cobro_3=&fecha_despacho_3=&precio_3=0.00&comercializadora_3=&fecha_cobro_4=2023-06-11&fecha_despacho_4=2023-06-14&precio_4=20&comercializadora_4=Mercal&fecha_cobro_5=&fecha_despacho_5=&precio_5=0.00&comercializadora_5=&fecha_cobro_6=&fecha_despacho_6=&precio_6=0.00&comercializadora_6=&fecha_cobro_7=&fecha_despacho_7=&precio_7=0.00&comercializadora_7=&fecha_cobro_8=&fecha_despacho_8=&precio_8=0.00&comercializadora_8=&fecha_cobro_9=&fecha_despacho_9=&precio_9=0.00&comercializadora_9=&fecha_cobro_10=&fecha_despacho_10=&precio_10=0.00&comercializadora_10=&fecha_cobro_11=&fecha_despacho_11=&precio_11=0.00&comercializadora_11=&fecha_cobro_12=&fecha_despacho_12=&precio_12=0.00&comercializadora_12=&fecha_cobro_13=&fecha_despacho_13=&precio_13=0.00&comercializadora_13=&fecha_cobro_14=&fecha_despacho_14=&precio_14=0.00&comercializadora_14=&fecha_cobro_15=&fecha_despacho_15=&precio_15=0.00&comercializadora_15=&fecha_cobro_16=&fecha_despacho_16=&precio_16=0.00&comercializadora_16=&fecha_cobro_17=&fecha_despacho_17=&precio_17=0.00&comercializadora_17=&fecha_cobro_18=&fecha_despacho_18=&precio_18=0.00&comercializadora_18=&fecha_cobro_19=&fecha_despacho_19=&precio_19=0.00&comercializadora_19=&fecha_cobro_20=&fecha_despacho_20=&precio_20=0.00&comercializadora_20=&fecha_cobro_21=&fecha_despacho_21=&precio_21=0.00&comercializadora_21=&fecha_cobro_22=&fecha_despacho_22=&precio_22=0.00&comercializadora_22=&fecha_cobro_23=&fecha_despacho_23=&precio_23=0.00&comercializadora_23=&fecha_cobro_24=&fecha_despacho_24=&precio_24=0.00&comercializadora_24=&fecha_cobro_25=&fecha_despacho_25=&precio_25=0.00&comercializadora_25=&fecha_cobro_26=&fecha_despacho_26=&precio_26=0.00&comercializadora_26=
        // Se debe recorrer y actualizar cada campo
        $data = array();
        foreach ($_POST as $key => $value) {
            // Obtener el id del municipio
            $municipio_id = explode('_', $key)[1];
            $key_value = explode('_', $key)[0];

            if ($key_value != 'fechacobro' && $key_value != 'fechadespacho' && $key_value != 'precio' && $key_value != 'comercializadora') {
                continue;
            }

            if ($key_value == 'fechacobro' || $key_value == 'fechadespacho') {
                $key_value = $key_value == 'fechacobro' ? 'fecha_cobro' : 'fecha_despacho';
                // Si no es una fecha válida, se debe actualizar a null
                if (!validateDate($value, 'Y-m-d')) {
                    continue;
                }
            } else if ($key_value == 'precio') {
                // Si no es un número válido, se debe actualizar a 0
                if (!is_numeric($value)) {
                    continue;
                }
            }

            $sql = "UPDATE clap_por_municipio SET $key_value = '$value' WHERE id_clap_por_municipio = $municipio_id";
            $result = $conn->prepare($sql);
            $result->execute();
        }


        echo json_encode([
            'status' => 'ok',
            'message' => 'Se actualizó la jornada de entrega',
            'data' => $data,
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

function Clap_Load ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    if (!is_numeric($id)) {
        header('Location: /admin/clap');
        exit();
    }

    require 'src/database/connection.php';

    $sql = "SELECT * FROM clap_por_entrega WHERE id_clap_por_entrega = $id";
    $result = $conn->prepare($sql);
    $result->execute();
    $clap = $result->fetch(PDO::FETCH_ASSOC);

    if (!$clap) {
        header('Location: /admin/clap');
        exit();
    }

    $sql_municipios = "SELECT * FROM clap_por_municipio 
    LEFT JOIN municipios ON clap_por_municipio.municipio_id = municipios.id_municipio
    WHERE entrega_clap_id = $id";
    $result_municipios = $conn->prepare($sql_municipios);
    $result_municipios->execute();
    $municipios = $result_municipios->fetchAll(PDO::FETCH_ASSOC);

    $title = 'Cargando jornada de entrega';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/clap/clap_load.php';
    include_once 'src/blocks/footer.php';
}

function Post_Load_Clap () {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        if (!isset($_POST['cantidad']) || !isset($_POST['municipio']) || !isset($_POST['nota']) || !isset($_POST['id_entrega'])) {
            throw new Exception('No se recibieron todos los datos');
        }

        $cantidad = addslashes($_POST['cantidad']);
        $municipio = addslashes($_POST['municipio']);
        $nota = addslashes(trim($_POST['nota']));
        $id = addslashes($_POST['id_entrega']);

        if (!is_numeric($cantidad)) {
            throw new Exception('La cantidad debe ser un número');
        }

        if (!is_numeric($municipio)) {
            throw new Exception('El municipio debe ser un número');
        }

        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser mayor a 0');
        }

        require 'src/database/connection.php';

        $sql = "SELECT * FROM clap_por_entrega WHERE id_clap_por_entrega = $id";
        $result = $conn->prepare($sql);
        $result->execute();
        $clap = $result->fetch(PDO::FETCH_ASSOC);

        if (!$clap) {
            throw new Exception('No se encontró la jornada de entrega');
        }

        $sql_municipio = "SELECT * FROM clap_por_municipio WHERE id_clap_por_municipio = $municipio";
        $result_municipio = $conn->prepare($sql_municipio);
        $result_municipio->execute();
        $municipio = $result_municipio->fetch(PDO::FETCH_ASSOC);

        if (!$municipio) {
            throw new Exception('No se encontró el municipio');
        }

        $sql = "INSERT INTO clap_carga (clap_por_municipio_id, cantidad, nota, user_id) VALUES ($municipio[id_clap_por_municipio], $cantidad, '$nota', $_SESSION[id])";
        $result = $conn->prepare($sql);
        $result->execute();

        echo json_encode([
            'status' => 'ok',
            'message' => 'Entrega cargada correctamente',
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

function Export_Pdf_Clap_Por_Entrega ($id) {
    try {
        require_once 'src/database/connection.php';

        if (!is_numeric($id)) {
            throw new Exception('El id de la jornada de entrega debe ser un número');
        }
        
        $sql = "SELECT clap_por_entrega.*, SUM(clap_carga.cantidad) as beneficios_entregados
                FROM clap_por_entrega 
                LEFT JOIN clap_por_municipio ON clap_por_entrega.id_clap_por_entrega = clap_por_municipio.entrega_clap_id
                LEFT JOIN clap_carga ON clap_por_municipio.id_clap_por_municipio = clap_carga.clap_por_municipio_id
                WHERE id_clap_por_entrega = $id
                GROUP BY clap_por_entrega.id_clap_por_entrega";
        $result = $conn->prepare($sql);
        $result->execute();
        $clap = $result->fetch(PDO::FETCH_ASSOC);

        

        if (!$clap) {
            throw new Exception('No se encontró la jornada de entrega');
        }

        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');

        $sql_municipios = "SELECT SUM(clap_carga.cantidad) AS beneficios_entregados, 
        clap_por_municipio.*, municipios.* FROM `clap_por_municipio` 
        LEFT JOIN clap_carga ON clap_por_municipio.id_clap_por_municipio = clap_carga.clap_por_municipio_id 
        LEFT JOIN municipios ON clap_por_municipio.municipio_id = municipios.id_municipio 
        WHERE entrega_clap_id = $id GROUP BY clap_por_municipio.id_clap_por_municipio";

        $result_municipios = $conn->prepare($sql_municipios);
        $result_municipios->execute();
        $municipios = $result_municipios->fetchAll(PDO::FETCH_ASSOC);

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
        // Establecer la configuración básica del documento PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MINPPAL');
        $pdf->SetTitle('Reporte CLAP ' . date('d/m/Y', strtotime($clap['fecha_inicio_entrega'])) . ' - ' . date('d/m/Y', strtotime($clap['fecha_fin_entrega'])));
        $pdf->SetSubject('Reporte CLAP ' . date('d/m/Y', strtotime($clap['fecha_inicio_entrega'])) . ' - ' . date('d/m/Y', strtotime($clap['fecha_fin_entrega'])));
        $pdf->SetKeywords('MINPPAL, PDF, CLAP, Reporte');

        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte CLAP (' . date('d/m/Y', strtotime($clap['fecha_inicio_entrega'])) . ' - ' . date('d/m/Y', strtotime($clap['fecha_fin_entrega'])) .')', 0, 1, 'C');
        $pdf->Ln(2);

        $html_tablas_por_entrega = '
            <h6 style="text-align: center; color: #001640">Beneficios totales entregados: ' . number_format($clap['beneficios_entregados'], 0, ',', '.') . '</h6>
        ';

        $html_tablas_por_municipio = $html_tablas_por_entrega;

        foreach ($municipios as $municipio) {
            $sql_cargas = "SELECT * FROM clap_carga WHERE clap_por_municipio_id = " . $municipio['id_clap_por_municipio'] . " AND nota != ''";
            $result_cargas = $conn->prepare($sql_cargas);
            $result_cargas->execute();
            $cargas = $result_cargas->fetchAll(PDO::FETCH_ASSOC);

            $html_tablas_por_municipio .= '
                <h6 style="text-align: center; color: #001640">' . $municipio['name_municipio'] . '</h6>
                <table border="1" cellpadding="4">
                    <thead>
                        <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                            <th class="description">Parroquias</th>
                            <th class="description">Comunidades</th>
                            <th class="description">Precio</th>
                            <th class="description">Fecha de cobro</th>
                            <th class="description">Fecha de despacho</th>
                            <th class="description">Comercializadora</th>
                            <th class="description">Cantidad de Beneficiarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                            <td>' . $municipio['cantidad_parroquias'] . '</td>
                            <td>' . $municipio['cantidad_comunidades']. '</td>
                            <td>' . number_format($municipio['precio'], 2, ',', '.') . '</td>
                            <td>' . ($municipio['fecha_cobro'] == null ? '' : date('d/m/Y', strtotime($municipio['fecha_cobro']))) . '</td>
                            <td>' . ($municipio['fecha_despacho'] == null ? '' : date('d/m/Y', strtotime($municipio['fecha_despacho']))) . '</td>
                            <td>' . $municipio['comercializadora'] . '</td>
                            <td>' . number_format($municipio['beneficios_entregados'], 0, ',', '.') . '</td>
                        </tr>
                    </tbody>
                </table>';

            $html_notas_cargas = '';

            foreach ($cargas as $carga) {
                $html_notas_cargas .= '
                    <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                        ' . date('d/m/Y', strtotime($carga['created_at'])) . ' -
                        ' . $carga['nota'] . '
                    </h6>
                ';
            }

            $html_tablas_por_municipio .= $html_notas_cargas;

            $html_tablas_por_municipio .= '<br>';
        }

        $pdf->writeHTML($html_tablas_por_municipio, true, false, true, false, '');

        ob_end_clean();
        $pdf->output('reporte_clap.pdf', 'I');


    } catch (\Throwable $th) {
        //throw $th;
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
} 