<?php

// Crear class CNAE_Por_Mes, esta contiene: fecha_inicio_cnae_por_mes, fecha_fin_cnae_por_mes
class CNAE_Por_Mes {
    public $fecha_inicio_cnae_por_mes;
    public $fecha_fin_cnae_por_mes;

    public function __construct($fecha_inicio_cnae_por_mes, $fecha_fin_cnae_por_mes) {
        $this->fecha_inicio_cnae_por_mes = $fecha_inicio_cnae_por_mes;
        $this->fecha_fin_cnae_por_mes = $fecha_fin_cnae_por_mes;
    }
}

// Crear class CNAE_Por_Municipio, esta contiene: municipio_id_cnae_por_municipio 	mes_id_cnae_por_municipio 	proteina_asignada_cnae_por_municipio 	clap_asignados_cnae_por_municipio 	fruta_asignada_cnae_por_municipio 	instituciones_cnae_por_municipio 	matricula_cnae_por_municipio
// Ademas es un array de CNAE_Por_Municipio
class CNAE_Por_Municipio {
    public $municipio_id_cnae_por_municipio;
    public $mes_id_cnae_por_municipio;
    public $proteina_asignada_cnae_por_municipio;
    public $clap_asignados_cnae_por_municipio;
    public $fruta_asignada_cnae_por_municipio;
    public $instituciones_cnae_por_municipio;
    public $matricula_cnae_por_municipio;

    public function __construct($municipio_id_cnae_por_municipio, $mes_id_cnae_por_municipio, $proteina_asignada_cnae_por_municipio, $clap_asignados_cnae_por_municipio, $fruta_asignada_cnae_por_municipio, $instituciones_cnae_por_municipio, $matricula_cnae_por_municipio) {
        $this->municipio_id_cnae_por_municipio = $municipio_id_cnae_por_municipio;
        $this->mes_id_cnae_por_municipio = $mes_id_cnae_por_municipio;
        $this->proteina_asignada_cnae_por_municipio = $proteina_asignada_cnae_por_municipio;
        $this->clap_asignados_cnae_por_municipio = $clap_asignados_cnae_por_municipio;
        $this->fruta_asignada_cnae_por_municipio = $fruta_asignada_cnae_por_municipio;
        $this->instituciones_cnae_por_municipio = $instituciones_cnae_por_municipio;
        $this->matricula_cnae_por_municipio = $matricula_cnae_por_municipio;
    }
}


function Create_New_Data_CNAE ($last_month) {
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
        $data_cnae_por_mes = new CNAE_Por_Mes($first_day_of_month, $last_day_of_month);

        // Inserta en la tabla cnae_por_mes
        $sql_insert_cnae_por_mes = "INSERT INTO cnae_por_mes (fecha_inicio_cnae_por_mes, fecha_fin_cnae_por_mes) VALUES (?, ?)";
        $result_insert_cnae_por_mes = $conn->prepare($sql_insert_cnae_por_mes);
        $result_insert_cnae_por_mes->bindParam(1, $data_cnae_por_mes->fecha_inicio_cnae_por_mes);
        $result_insert_cnae_por_mes->bindParam(2, $data_cnae_por_mes->fecha_fin_cnae_por_mes);
        $result_insert_cnae_por_mes->execute();
        $id_cnae_por_mes = $conn->lastInsertId();

        // Recorrer listado de municipios
        foreach ($municipios as $municipio) {
            if ($last_month === null) {
                $data_cnae_por_municipio = new CNAE_Por_Municipio($municipio['id_municipio'], $id_cnae_por_mes, 0, 0, 0, 0, 0);
            } else {
                // Obtener los datos del ultimo mes registrado para que se copien en el nuevo mes
                $sql_last_month_data = "SELECT * FROM cnae_por_municipio WHERE mes_id_cnae_por_municipio = ? AND municipio_id_cnae_por_municipio = ?";
                $result_last_month_data = $conn->prepare($sql_last_month_data);
                $result_last_month_data->bindParam(1, $last_month['id_cnae_por_mes']);
                $result_last_month_data->bindParam(2, $municipio['id_municipio']);
                $result_last_month_data->execute();
                $last_month_data = $result_last_month_data->fetch(PDO::FETCH_ASSOC);

                $data_cnae_por_municipio = new CNAE_Por_Municipio($municipio['id_municipio'], $id_cnae_por_mes, $last_month_data['proteina_asignada_cnae_por_municipio'], $last_month_data['clap_asignados_cnae_por_municipio'], $last_month_data['fruta_asignada_cnae_por_municipio'], $last_month_data['instituciones_cnae_por_municipio'], $last_month_data['matricula_cnae_por_municipio']);
            }

            // Inserta en la tabla cnae_por_municipio
            $sql_insert_cnae_por_municipio = "INSERT INTO cnae_por_municipio (municipio_id_cnae_por_municipio, mes_id_cnae_por_municipio, proteina_asignada_cnae_por_municipio, clap_asignados_cnae_por_municipio, fruta_asignada_cnae_por_municipio, instituciones_cnae_por_municipio, matricula_cnae_por_municipio) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $result_insert_cnae_por_municipio = $conn->prepare($sql_insert_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(1, $data_cnae_por_municipio->municipio_id_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(2, $data_cnae_por_municipio->mes_id_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(3, $data_cnae_por_municipio->proteina_asignada_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(4, $data_cnae_por_municipio->clap_asignados_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(5, $data_cnae_por_municipio->fruta_asignada_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(6, $data_cnae_por_municipio->instituciones_cnae_por_municipio);
            $result_insert_cnae_por_municipio->bindParam(7, $data_cnae_por_municipio->matricula_cnae_por_municipio);
            $result_insert_cnae_por_municipio->execute();
        }


    } catch (\Throwable $th) {
        //throw $th;
    }
}

function CNAE_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener el ultimo mes registrado
    $sql_last_month = "SELECT * FROM cnae_por_mes ORDER BY id_cnae_por_mes DESC LIMIT 1";
    $result_last_month = $conn->prepare($sql_last_month);
    $result_last_month->execute();
    $last_month = $result_last_month->fetch(PDO::FETCH_ASSOC);

    // Si el ultimo mes registrado es el actual, no se puede crear un nuevo mes
    // Si el ultimo mes registrado ya es el anterior, se puede crear un nuevo mes
    // fin_cnae_por_mes, tiene el ultimo dia del mes registrado: Ej: 2021-05-31
    // Verifica si la fecha actual es mayor a la fecha del ultimo mes registrado
    if ($last_month) {
        if (date('Y-m-d') > $last_month['fecha_fin_cnae_por_mes']) {
            Create_New_Data_CNAE($last_month);
        }
    } else {
        Create_New_Data_CNAE(null);
    }

    // Obtener todas las datas CNAE por mes
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    // $sql_cnae_por_mes = "SELECT * FROM cnae_por_mes ORDER BY id_cnae_por_mes DESC LIMIT $offset, $limit";
    // necesito que me traiga la sumatoria de los cnae_por_municipio (proteina_asignada_cnae_por_municipio, clap_asignados_cnae_por_municipio, fruta_asignada_cnae_por_municipio, instituciones_cnae_por_municipio, matricula_cnae_por_municipio)
    $sql_cnae_por_mes = "SELECT cnae_por_mes.id_cnae_por_mes, cnae_por_mes.fecha_inicio_cnae_por_mes, cnae_por_mes.fecha_fin_cnae_por_mes, SUM(cnae_por_municipio.proteina_asignada_cnae_por_municipio) AS proteina_asignada_cnae_por_mes, SUM(cnae_por_municipio.clap_asignados_cnae_por_municipio) AS clap_asignados_cnae_por_mes, SUM(cnae_por_municipio.fruta_asignada_cnae_por_municipio) AS fruta_asignada_cnae_por_mes, SUM(cnae_por_municipio.instituciones_cnae_por_municipio) AS instituciones_cnae_por_mes, SUM(cnae_por_municipio.matricula_cnae_por_municipio) AS matricula_cnae_por_mes FROM cnae_por_mes INNER JOIN cnae_por_municipio ON cnae_por_mes.id_cnae_por_mes = cnae_por_municipio.mes_id_cnae_por_municipio GROUP BY cnae_por_mes.id_cnae_por_mes ORDER BY cnae_por_mes.id_cnae_por_mes DESC LIMIT $offset, $limit";
    $result_cnae_por_mes = $conn->prepare($sql_cnae_por_mes);
    $result_cnae_por_mes->execute();
    $cnae_por_mes = $result_cnae_por_mes->fetchAll(PDO::FETCH_ASSOC);

    $title = 'MINPPAL - CNAE';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/cnae/CNAE_Viewer.php';
    include_once 'src/blocks/footer.php';
}

function Get_Cnae_Por_Mes ($id) {
    try {
        require 'src/database/connection.php';

        // Obtener todas las datas CNAE por mes, igual su relacion con cnae_por_municipio
        $sql_cnae_por_mes = "SELECT cnae_por_mes.id_cnae_por_mes, cnae_por_mes.fecha_inicio_cnae_por_mes, cnae_por_mes.fecha_fin_cnae_por_mes, SUM(cnae_por_municipio.proteina_asignada_cnae_por_municipio) AS proteina_asignada_cnae_por_mes, SUM(cnae_por_municipio.clap_asignados_cnae_por_municipio) AS clap_asignados_cnae_por_mes, SUM(cnae_por_municipio.fruta_asignada_cnae_por_municipio) AS fruta_asignada_cnae_por_mes, SUM(cnae_por_municipio.instituciones_cnae_por_municipio) AS instituciones_cnae_por_mes, SUM(cnae_por_municipio.matricula_cnae_por_municipio) AS matricula_cnae_por_mes FROM cnae_por_mes INNER JOIN cnae_por_municipio ON cnae_por_mes.id_cnae_por_mes = cnae_por_municipio.mes_id_cnae_por_municipio WHERE cnae_por_mes.id_cnae_por_mes = ? GROUP BY cnae_por_mes.id_cnae_por_mes ORDER BY cnae_por_mes.id_cnae_por_mes DESC";
        $result_cnae_por_mes = $conn->prepare($sql_cnae_por_mes);
        $result_cnae_por_mes->bindParam(1, $id);
        $result_cnae_por_mes->execute();
        $cnae_por_mes = $result_cnae_por_mes->fetch(PDO::FETCH_ASSOC);

        // Paginacion
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $offset = ($page - 1) * $limit;

        // Obtener todas las datas CNAE por municipio relacionado al municipio
        $sql_cnae_por_municipio = "SELECT * FROM cnae_por_municipio INNER JOIN municipios ON cnae_por_municipio.municipio_id_cnae_por_municipio = municipios.id_municipio WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ? ORDER BY cnae_por_municipio.id_cnae_por_municipio ASC LIMIT $limit OFFSET $offset";
        $result_cnae_por_municipio = $conn->prepare($sql_cnae_por_municipio);
        $result_cnae_por_municipio->bindParam(1, $id);
        $result_cnae_por_municipio->execute();
        $cnae_por_municipio = $result_cnae_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        // Obtener el total
        $sql_total = "SELECT COUNT(*) AS total FROM cnae_por_municipio WHERE mes_id_cnae_por_municipio = ?";
        $result_total = $conn->prepare($sql_total);
        $result_total->bindParam(1, $id);
        $result_total->execute();
        $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_year = strftime("%B %Y", strtotime($cnae_por_mes['fecha_inicio_cnae_por_mes']));

        // echo '<script>console.log(' . json_encode($total) . ')</script>';
        // echo '<script>console.log(' . json_encode($totalPages) . ')</script>';

        $title = 'MINPPAL - CNAE - ' . $month_year;
        include_once 'src/blocks/header.php';
        include_once 'src/blocks/menu/admin/menu.php';
        include_once 'src/blocks/menu/admin/menu_responsive.php';
        include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
        include_once 'src/views/admin/companies/cnae/CNAE_Municipios.php';
        include_once 'src/blocks/footer.php';
    } catch (\Throwable $th) {
        //throw $th;
    }

}