<?php

// Crear class INN_Por_Mes, esta contiene: fecha_inicio_inn_por_mes, fecha_fin_inn_por_mes
class INN_Por_Mes {
    public $fecha_inicio_inn_por_mes;
    public $fecha_fin_inn_por_mes;

    public function __construct($fecha_inicio_inn_por_mes, $fecha_fin_inn_por_mes) {
        $this->fecha_inicio_inn_por_mes = $fecha_inicio_inn_por_mes;
        $this->fecha_fin_inn_por_mes = $fecha_fin_inn_por_mes;
    }
}

// Crear class INN_Por_Municipio, esta contiene: municipio_id	mes_id 	proteina_asignada 	clap_asignados   personas_por_atender
// Ademas es un array de INN_Por_Municipio
class INN_Por_Municipio {
    public $municipio_id;
    public $mes_id;
    public $proteina_asignada;
    public $clap_asignados;
    public $personas_por_atender;

    public function __construct($municipio_id, $mes_id, $proteina_asignada, $clap_asignados, $personas_por_atender) {
        $this->municipio_id = $municipio_id;
        $this->mes_id = $mes_id;
        $this->proteina_asignada = $proteina_asignada;
        $this->clap_asignados = $clap_asignados;
        $this->personas_por_atender = $personas_por_atender;
    }
}

function Create_New_Data_INN ($last_month) {
    try {
        $date_now = date('Y-m-d');

        require 'src/database/connection.php';

        // Obtener listado de municipios
        $sql_municipios = "SELECT * FROM municipios";
        $result_municipios = $conn->prepare($sql_municipios);
        $result_municipios->execute();
        $municipios = $result_municipios->fetchAll(PDO::FETCH_ASSOC);

        $first_day_of_month = date('Y-m-01');
        $last_day_of_month = date('Y-m-t');
        $data_inn_por_mes = new INN_Por_Mes($first_day_of_month, $last_day_of_month);

        // Inserta en la tabla inn_por_mes
        $sql_insert_inn_por_mes = "INSERT INTO inn_por_mes (fecha_inicio_inn_por_mes, fecha_fin_inn_por_mes) VALUES (?, ?)";
        $result_insert_inn_por_mes = $conn->prepare($sql_insert_inn_por_mes);
        $result_insert_inn_por_mes->bindParam(1, $data_inn_por_mes->fecha_inicio_inn_por_mes);
        $result_insert_inn_por_mes->bindParam(2, $data_inn_por_mes->fecha_fin_inn_por_mes);
        $result_insert_inn_por_mes->execute();
        $id_inn_por_mes = $conn->lastInsertId();

        // Recorrer listado de municipios
        foreach ($municipios as $municipio) {
            if ($last_month === null) {
                $data_inn_por_municipio = new INN_Por_Municipio($municipio['id_municipio'], $id_inn_por_mes, 0, 0, 0);
            } else {
                // Obtener los datos del ultimo mes registrado para que se copien en el nuevo mes
                $sql_last_month_data = "SELECT * FROM inn_por_municipio WHERE mes_id = ? AND municipio_id = ?";
                $result_last_month_data = $conn->prepare($sql_last_month_data);
                $result_last_month_data->bindParam(1, $last_month['id_inn_por_mes']);
                $result_last_month_data->bindParam(2, $municipio['id_municipio']);
                $result_last_month_data->execute();
                $last_month_data = $result_last_month_data->fetch(PDO::FETCH_ASSOC);

                $data_inn_por_municipio = new INN_Por_Municipio($municipio['id_municipio'], $id_inn_por_mes, $last_month_data['proteina_asignada'], $last_month_data['clap_asignados'], $last_month_data['personas_por_atender']);
            }

            // Inserta en la tabla inn_por_municipio
            $sql_insert_inn_por_municipio = "INSERT INTO inn_por_municipio (municipio_id, mes_id, proteina_asignada, clap_asignados, personas_por_atender) VALUES (?, ?, ?, ?, ?)";
            $result_insert_inn_por_municipio = $conn->prepare($sql_insert_inn_por_municipio);
            $result_insert_inn_por_municipio->bindParam(1, $data_inn_por_municipio->municipio_id);
            $result_insert_inn_por_municipio->bindParam(2, $data_inn_por_municipio->mes_id);
            $result_insert_inn_por_municipio->bindParam(3, $data_inn_por_municipio->proteina_asignada);
            $result_insert_inn_por_municipio->bindParam(4, $data_inn_por_municipio->clap_asignados);
            $result_insert_inn_por_municipio->bindParam(5, $data_inn_por_municipio->personas_por_atender);
            $result_insert_inn_por_municipio->execute();
        }


    } catch (\Throwable $th) {
        //throw $th;
    }
}


function INN_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener el ultimo mes registrado
    $sql_last_month = "SELECT * FROM inn_por_mes ORDER BY id_inn_por_mes DESC LIMIT 1";
    $result_last_month = $conn->prepare($sql_last_month);
    $result_last_month->execute();
    $last_month = $result_last_month->fetch(PDO::FETCH_ASSOC);

    // Si el ultimo mes registrado es el actual, no se puede crear un nuevo mes
    // Si el ultimo mes registrado ya es el anterior, se puede crear un nuevo mes
    // fin_inn_por_mes, tiene el ultimo dia del mes registrado: Ej: 2021-05-31
    // Verifica si la fecha actual es mayor a la fecha del ultimo mes registrado
    if ($last_month) {
        if (date('Y-m-d') > $last_month['fecha_fin_inn_por_mes']) {
            Create_New_Data_INN($last_month);
        }
    } else {
        Create_New_Data_INN(null);
    }

    // Obtener todas las datas INN por mes
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    // $sql_inn_por_mes = "SELECT * FROM inn_por_mes ORDER BY id_inn_por_mes DESC LIMIT $offset, $limit";
    // necesito que me traiga la sumatoria de los inn_por_municipio (proteina_asignada_inn, clap_asignados, personas_por_atender)
    $sql_inn_por_mes = "SELECT inn_por_mes.id_inn_por_mes, inn_por_mes.fecha_inicio_inn_por_mes, inn_por_mes.fecha_fin_inn_por_mes, 
                                SUM(inn_por_municipio.proteina_asignada) AS proteina_asignada, 
                                SUM(inn_por_municipio.clap_asignados) AS clap_asignados, 
                                SUM(inn_por_municipio.personas_por_atender) AS personas_por_atender
                                FROM inn_por_mes INNER JOIN inn_por_municipio ON inn_por_mes.id_inn_por_mes = inn_por_municipio.mes_id
                                GROUP BY inn_por_mes.id_inn_por_mes ORDER BY inn_por_mes.id_inn_por_mes DESC LIMIT $offset, $limit";
    $result_inn_por_mes = $conn->prepare($sql_inn_por_mes);
    $result_inn_por_mes->execute();
    $inn_por_mes = $result_inn_por_mes->fetchAll(PDO::FETCH_ASSOC);

    $data_return = array();

    foreach ($inn_por_mes as $inn) {

        // Obtener las sumatorias de las cargas
        $sql_inn_carga = "SELECT SUM(inn_carga.proteina_despachada) AS proteina_despachada, 
                                    SUM(inn_carga.clap_despachados) AS clap_despachados,
                                    SUM(inn_carga.personas_atendidas) AS personas_atendidas 
                                    FROM inn_carga INNER JOIN inn_por_municipio ON inn_carga.inn_por_municipio_id = inn_por_municipio.id_inn_por_municipio 
                                    WHERE inn_por_municipio.mes_id = ?";
        $result = $conn->prepare($sql_inn_carga);
        $result->bindParam(1, $inn['id_inn_por_mes']);
        $result->execute();
        $inn_carga = $result->fetch(PDO::FETCH_ASSOC);

        $data_return[] = array(
            'id_inn_por_mes' => $inn['id_inn_por_mes'],
            'fecha_inicio_inn_por_mes' => $inn['fecha_inicio_inn_por_mes'],
            'fecha_fin_inn_por_mes' => $inn['fecha_fin_inn_por_mes'],
            'proteina_asignada' => number_format($inn['proteina_asignada'], 2, ',', '.'),
            'clap_asignados' => number_format($inn['clap_asignados'], 0, ',', '.'),
            'personas_por_atender' => number_format($inn['personas_por_atender'], 0, ',', '.'),
            'proteina_despachada' => number_format($inn_carga['proteina_despachada'], 2, ',', '.'),
            'clap_despachados' => number_format($inn_carga['clap_despachados'], 0, ',', '.'),
            'personas_atendidas' => number_format($inn_carga['personas_atendidas'], 0, ',', '.'),
            'porcentaje_proteina_despachada' => $inn['proteina_asignada'] == 0 ? 0 : number_format(($inn_carga['proteina_despachada'] / $inn['proteina_asignada']) * 100, 2, ',', '.'),
            'porcentaje_clap_despachados' => $inn['clap_asignados'] == 0 ? 0 : number_format(($inn_carga['clap_despachados'] / $inn['clap_asignados']) * 100, 2, ',', '.'),
            'porcentaje_personas_atendidas' => $inn['personas_por_atender'] == 0 ? 0 : number_format(($inn_carga['personas_atendidas'] / $inn['personas_por_atender']) * 100, 2, ',', '.'),
        );
    }

    // Console_log($data_return);
    echo '<script>console.log(' . json_encode($data_return) . ')</script>';

    // Obtener el total
    $sql_total = "SELECT COUNT(*) AS total FROM inn_por_mes";
    $result_total = $conn->prepare($sql_total);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - INN';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/inn/inn_viewer.php';
    include_once 'src/blocks/footer.php';
}
