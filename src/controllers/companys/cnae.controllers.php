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
    $sql_cnae_por_mes = "SELECT cnae_por_mes.id_cnae_por_mes, cnae_por_mes.fecha_inicio_cnae_por_mes, cnae_por_mes.fecha_fin_cnae_por_mes, 
                                SUM(cnae_por_municipio.proteina_asignada_cnae_por_municipio) AS proteina_asignada_cnae_por_mes, 
                                SUM(cnae_por_municipio.clap_asignados_cnae_por_municipio) AS clap_asignados_cnae_por_mes, 
                                SUM(cnae_por_municipio.fruta_asignada_cnae_por_municipio) AS fruta_asignada_cnae_por_mes, 
                                SUM(cnae_por_municipio.instituciones_cnae_por_municipio) AS instituciones_cnae_por_mes, 
                                SUM(cnae_por_municipio.matricula_cnae_por_municipio) AS matricula_cnae_por_mes 
                                FROM cnae_por_mes INNER JOIN cnae_por_municipio ON cnae_por_mes.id_cnae_por_mes = cnae_por_municipio.mes_id_cnae_por_municipio 
                                GROUP BY cnae_por_mes.id_cnae_por_mes ORDER BY cnae_por_mes.id_cnae_por_mes DESC LIMIT $offset, $limit";
    $result_cnae_por_mes = $conn->prepare($sql_cnae_por_mes);
    $result_cnae_por_mes->execute();
    $cnae_por_mes = $result_cnae_por_mes->fetchAll(PDO::FETCH_ASSOC);

    $data_return = array();

    foreach ($cnae_por_mes as $cnae) {

        // Obtener las sumatorias de las cargas
        $sql_cnae_carga = "SELECT SUM(cnae_carga.proteina_despachada_cnae_carga) AS proteina_despachada_cnae_carga, 
                                    SUM(cnae_carga.claps_despachados_cnae_carga) AS clap_despachados_cnae_carga, 
                                    SUM(cnae_carga.fruta_despachada_cnae_carga) AS fruta_despachada_cnae_carga, 
                                    SUM(cnae_carga.instituciones_atendidas_cnae_carga) AS instituciones_despachadas_cnae_carga, 
                                    SUM(cnae_carga.matricula_atendida_cnae_carga) AS matricula_despachada_cnae_carga 
                                    FROM cnae_carga INNER JOIN cnae_por_municipio ON cnae_carga.cnae_por_municipio_id_cnae_carga = cnae_por_municipio.id_cnae_por_municipio 
                                    WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ?";
        $result_cnae_carga = $conn->prepare($sql_cnae_carga);
        $result_cnae_carga->bindParam(1, $cnae['id_cnae_por_mes']);
        $result_cnae_carga->execute();
        $cnae_carga = $result_cnae_carga->fetch(PDO::FETCH_ASSOC);

        $data_return[] = array(
            'id_cnae_por_mes' => $cnae['id_cnae_por_mes'],
            'fecha_inicio_cnae_por_mes' => $cnae['fecha_inicio_cnae_por_mes'],
            'fecha_fin_cnae_por_mes' => $cnae['fecha_fin_cnae_por_mes'],
            'proteina_asignada_cnae_por_mes' => number_format($cnae['proteina_asignada_cnae_por_mes'], 2, ',', '.'),
            'clap_asignados_cnae_por_mes' => number_format($cnae['clap_asignados_cnae_por_mes'], 0, ',', '.'),
            'fruta_asignada_cnae_por_mes' => number_format($cnae['fruta_asignada_cnae_por_mes'], 2, ',', '.'),
            'instituciones_cnae_por_mes' => number_format($cnae['instituciones_cnae_por_mes'], 0, ',', '.'),
            'matricula_cnae_por_mes' => number_format($cnae['matricula_cnae_por_mes'], 0, ',', '.'),
            'proteina_despachada_cnae_carga' => number_format($cnae_carga['proteina_despachada_cnae_carga'], 2, ',', '.'),
            'clap_despachados_cnae_carga' => number_format($cnae_carga['clap_despachados_cnae_carga'], 0, ',', '.'),
            'fruta_despachada_cnae_carga' => number_format($cnae_carga['fruta_despachada_cnae_carga'], 2, ',', '.'),
            'instituciones_despachadas_cnae_carga' => number_format($cnae_carga['instituciones_despachadas_cnae_carga'], 0, ',', '.'),
            'matricula_despachada_cnae_carga' => number_format($cnae_carga['matricula_despachada_cnae_carga'], 0, ',', '.'),
            'porcentaje_proteina_despachada' => number_format(($cnae_carga['proteina_despachada_cnae_carga'] / $cnae['proteina_asignada_cnae_por_mes']) * 100, 2, ',', '.'),
            'porcentaje_clap_despachados' => number_format(($cnae_carga['clap_despachados_cnae_carga'] / $cnae['clap_asignados_cnae_por_mes']) * 100, 2, ',', '.'),
            'porcentaje_fruta_despachada' => number_format(($cnae_carga['fruta_despachada_cnae_carga'] / $cnae['fruta_asignada_cnae_por_mes']) * 100, 2, ',', '.'),
            'porcentaje_instituciones_despachadas' => number_format(($cnae_carga['instituciones_despachadas_cnae_carga'] / $cnae['instituciones_cnae_por_mes']) * 100, 2, ',', '.'),
            'porcentaje_matricula_despachada' => number_format(($cnae_carga['matricula_despachada_cnae_carga'] / $cnae['matricula_cnae_por_mes']) * 100, 2, ',', '.')
        );
    }

    // Console_log($data_return);
    echo '<script>console.log(' . json_encode($data_return) . ')</script>';

    // Obtener el total
    $sql_total = "SELECT COUNT(*) AS total FROM cnae_por_mes";
    $result_total = $conn->prepare($sql_total);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

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

        // Si no existe el mes, redireccionar
        if (!$cnae_por_mes) {
            header('Location: /admin/cnae');
            exit();
        }

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

        $data_return = array();

        foreach ($cnae_por_municipio as $cnae) {
            
            // Obtener las sumatorias de las cargas
            $sql_cnae_carga = "SELECT SUM(cnae_carga.proteina_despachada_cnae_carga) AS proteina_despachada_cnae_carga,
                                        SUM(cnae_carga.claps_despachados_cnae_carga) AS clap_despachados_cnae_carga,
                                        SUM(cnae_carga.fruta_despachada_cnae_carga) AS fruta_despachada_cnae_carga,
                                        SUM(cnae_carga.instituciones_atendidas_cnae_carga) AS instituciones_despachadas_cnae_carga,
                                        SUM(cnae_carga.matricula_atendida_cnae_carga) AS matricula_despachada_cnae_carga
                                        FROM cnae_carga WHERE cnae_por_municipio_id_cnae_carga = ?";
            $result_cnae_carga = $conn->prepare($sql_cnae_carga);
            $result_cnae_carga->bindParam(1, $cnae['id_cnae_por_municipio']);
            $result_cnae_carga->execute();
            $cnae_carga = $result_cnae_carga->fetch(PDO::FETCH_ASSOC);

            // $cnae['proteina_asignada_cnae_por_municipio'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada = $cnae['proteina_asignada_cnae_por_municipio'] != 0 ? ($cnae_carga['proteina_despachada_cnae_carga'] * 100) / $cnae['proteina_asignada_cnae_por_municipio'] : 0;
            $porcentaje_clap_despachados = $cnae['clap_asignados_cnae_por_municipio'] != 0 ? ($cnae_carga['clap_despachados_cnae_carga'] * 100) / $cnae['clap_asignados_cnae_por_municipio'] : 0;
            $porcentaje_fruta_despachada = $cnae['fruta_asignada_cnae_por_municipio'] != 0 ? ($cnae_carga['fruta_despachada_cnae_carga'] * 100) / $cnae['fruta_asignada_cnae_por_municipio'] : 0;
            $porcentaje_instituciones_despachadas = $cnae['instituciones_cnae_por_municipio'] != 0 ? ($cnae_carga['instituciones_despachadas_cnae_carga'] * 100) / $cnae['instituciones_cnae_por_municipio'] : 0;
            $porcentaje_matricula_despachada = $cnae['matricula_cnae_por_municipio'] != 0 ? ($cnae_carga['matricula_despachada_cnae_carga'] * 100) / $cnae['matricula_cnae_por_municipio'] : 0;

            $data_return[] = array(
                'id_cnae_por_municipio' => $cnae['id_cnae_por_municipio'],
                'municipio_id_cnae_por_municipio' => $cnae['municipio_id_cnae_por_municipio'],
                'name_municipio' => $cnae['name_municipio'],
                'proteina_asignada_cnae_por_municipio' => number_format($cnae['proteina_asignada_cnae_por_municipio'], 2, ',', '.'),
                'clap_asignados_cnae_por_municipio' => number_format($cnae['clap_asignados_cnae_por_municipio'], 0, ',', '.'),
                'fruta_asignada_cnae_por_municipio' => number_format($cnae['fruta_asignada_cnae_por_municipio'], 2, ',', '.'),
                'instituciones_cnae_por_municipio' => number_format($cnae['instituciones_cnae_por_municipio'], 0, ',', '.'),
                'matricula_cnae_por_municipio' => number_format($cnae['matricula_cnae_por_municipio'], 0, ',', '.'),
                'proteina_despachada_cnae_carga' => number_format($cnae_carga['proteina_despachada_cnae_carga'], 2, ',', '.'),
                'clap_despachados_cnae_carga' => number_format($cnae_carga['clap_despachados_cnae_carga'], 0, ',', '.'),
                'fruta_despachada_cnae_carga' => number_format($cnae_carga['fruta_despachada_cnae_carga'], 2, ',', '.'),
                'instituciones_despachadas_cnae_carga' => number_format($cnae_carga['instituciones_despachadas_cnae_carga'], 0, ',', '.'),
                'matricula_despachada_cnae_carga' => number_format($cnae_carga['matricula_despachada_cnae_carga'] , 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados, 2, ',', '.'),
                'porcentaje_fruta_despachada' => number_format($porcentaje_fruta_despachada, 2, ',', '.'),
                'porcentaje_instituciones_despachadas' => number_format($porcentaje_instituciones_despachadas, 2, ',', '.'),
                'porcentaje_matricula_despachada' => number_format($porcentaje_matricula_despachada, 2, ',', '.'),
            );
        }

        echo '<script>console.log(' . json_encode($data_return) . ')</script>';

        // Obtener el total
        $sql_total = "SELECT COUNT(*) AS total FROM cnae_por_municipio WHERE mes_id_cnae_por_municipio = ?";
        $result_total = $conn->prepare($sql_total);
        $result_total->bindParam(1, $id);
        $result_total->execute();
        $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_year = strftime("%B %Y", strtotime($cnae_por_mes['fecha_inicio_cnae_por_mes']));

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

// EDICION DE RECURSOS ASIGNADOS POR MES

function Update_CNAE_Assigned ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del cnae_por_mes seleccionado
    $sql_cnae_por_mes = "SELECT * FROM cnae_por_mes WHERE id_cnae_por_mes = ?";
    $result_cnae_por_mes = $conn->prepare($sql_cnae_por_mes);
    $result_cnae_por_mes->bindParam(1, $id);
    $result_cnae_por_mes->execute();
    $cnae_por_mes = $result_cnae_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$cnae_por_mes) {
        header('Location: /admin/cnae');
        exit();
    }

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($cnae_por_mes['fecha_inicio_cnae_por_mes']));

    // Obtener todas las datas CNAE por municipio relacionado al municipio
    $sql_cnae_por_municipio = "SELECT * FROM cnae_por_municipio INNER JOIN municipios ON cnae_por_municipio.municipio_id_cnae_por_municipio = municipios.id_municipio WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ? ORDER BY cnae_por_municipio.id_cnae_por_municipio ASC";
    $result_cnae_por_municipio = $conn->prepare($sql_cnae_por_municipio);
    $result_cnae_por_municipio->bindParam(1, $id);
    $result_cnae_por_municipio->execute();
    $cnae_por_municipio = $result_cnae_por_municipio->fetchAll(PDO::FETCH_ASSOC);


    $title = 'MINPPAL - CNAE - Actualizar';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/cnae/cnae_edit_assigned.php';
    include_once 'src/blocks/footer.php';
}

function PUT_CNAE_Assigned () {
    try {

        // Si no es admin, no puede actualizar
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        // Debe un month_id y debe ser un numero
        // Luego valida que exista en la base de datos y que el mes no haya pasado
        if (!isset($_POST['month_id']) || !is_numeric($_POST['month_id'])) {
            throw new Exception('Debe seleccionar un mes');
        }

        require 'src/database/connection.php';

        $sql_month = "SELECT * FROM cnae_por_mes WHERE id_cnae_por_mes = ?";
        $result_month = $conn->prepare($sql_month);
        $result_month->bindParam(1, $_POST['month_id']);
        $result_month->execute();
        $month = $result_month->fetch(PDO::FETCH_ASSOC);

        if (!$month) {
            throw new Exception('El mes seleccionado no existe');
        }

        // Si el mes ya paso, no se puede actualizar
        if (date('Y-m-d') > $month['fecha_fin_cnae_por_mes']) {
            throw new Exception('El mes seleccionado ya paso, no se puede actualizar');
        }

        // Estamos recibiendo algo como esto
        // {"clap_151":"0","proteina_151":"10000000.00","fruver_151":"0.00","inst_151":"0","matricula_151":"0","clap_152":"0","proteina_152":"0.00","fruver_152":"0.00","inst_152":"0","matricula_152":"0","clap_153":"0","proteina_153":"0.00","fruver_153":"0.00","inst_153":"0","matricula_153":"0","clap_154":"0","proteina_154":"0.00","fruver_154":"0.00","inst_154":"0","matricula_154":"0","clap_155":"10","proteina_155":"28.00","fruver_155":"120.23","inst_155":"1020","matricula_155":"201","clap_156":"0","proteina_156":"40.20","fruver_156":"0.00","inst_156":"0","matricula_156":"420","clap_157":"0","proteina_157":"0.00","fruver_157":"0.00","inst_157":"0","matricula_157":"0","clap_158":"0","proteina_158":"0.00","fruver_158":"0.00","inst_158":"0","matricula_158":"0","clap_159":"0","proteina_159":"0.00","fruver_159":"0.00","inst_159":"0","matricula_159":"0","clap_160":"0","proteina_160":"0.00","fruver_160":"0.00","inst_160":"0","matricula_160":"0","clap_161":"0","proteina_161":"0.00","fruver_161":"0.00","inst_161":"0","matricula_161":"0","clap_162":"0","proteina_162":"0.00","fruver_162":"0.00","inst_162":"0","matricula_162":"0","clap_163":"0","proteina_163":"0.00","fruver_163":"0.00","inst_163":"0","matricula_163":"0","clap_164":"0","proteina_164":"0.00","fruver_164":"0.00","inst_164":"0","matricula_164":"0","clap_165":"0","proteina_165":"0.00","fruver_165":"0.00","inst_165":"0","matricula_165":"0","clap_166":"0","proteina_166":"0.00","fruver_166":"0.00","inst_166":"0","matricula_166":"0","clap_167":"0","proteina_167":"0.00","fruver_167":"0.00","inst_167":"0","matricula_167":"0","clap_168":"0","proteina_168":"0.00","fruver_168":"0.00","inst_168":"0","matricula_168":"0","clap_169":"0","proteina_169":"0.00","fruver_169":"0.00","inst_169":"0","matricula_169":"0","clap_170":"0","proteina_170":"0.00","fruver_170":"0.00","inst_170":"0","matricula_170":"0","clap_171":"0","proteina_171":"0.00","fruver_171":"0.00","inst_171":"0","matricula_171":"0","clap_172":"0","proteina_172":"0.00","fruver_172":"0.00","inst_172":"0","matricula_172":"0","clap_173":"0","proteina_173":"0.00","fruver_173":"0.00","inst_173":"0","matricula_173":"0","clap_174":"0","proteina_174":"0.00","fruver_174":"0.00","inst_174":"0","matricula_174":"0","clap_175":"0","proteina_175":"0.00","fruver_175":"0.00","inst_175":"0","matricula_175":"0"}
        // Debemos recorrerlo y actualizar cada uno de los datos
        // Tenemos la palabra que lo identifica, por ejemplo: clap, proteina, fruver, inst, matricula, seguido de un guion bajo y el id del municipio
        // Ej: clap_151, proteina_151, fruver_151, inst_151, matricula_151
        // Esas 5 personas son del municipio con id 151
        // Y asi sucesivamente
        // Debemos recorrer el array y actualizar cada uno de los datos

        // Recorrer el array
        foreach ($_POST as $key => $value) {

            // Obtener el id del municipio
            $municipio_id = explode('_', $key)[1];
            $key_value = explode('_', $key)[0];

            // Si la key_value no es clap, proteina, fruver, inst, matricula, se salta al siguiente
            // Si el value no es numerico, se salta al siguiente
            // Si el municipio_id no es numerico, se salta al siguiente
            // Si el value es menor a 0, se salta al siguiente

            if ($key_value != 'clap' && $key_value != 'proteina' && $key_value != 'fruver' && $key_value != 'inst' && $key_value != 'matricula') {
                continue;
            }

            if (!is_numeric($value) || !is_numeric($municipio_id) || $value < 0) {
                continue;
            }

            // si el key_value es clap, la columna a actualizar es clap_asignados_cnae_por_municipio
            // si el key_value es proteina, la columna a actualizar es proteina_asignada_cnae_por_municipio
            // si el key_value es fruver, la columna a actualizar es fruta_asignada_cnae_por_municipio
            // si el key_value es inst, la columna a actualizar es instituciones_cnae_por_municipio
            // si el key_value es matricula, la columna a actualizar es matricula_cnae_por_municipio

            $column = $key_value == 'clap' ? 'clap_asignados_cnae_por_municipio' : ($key_value == 'proteina' ? 'proteina_asignada_cnae_por_municipio' : ($key_value == 'fruver' ? 'fruta_asignada_cnae_por_municipio' : ($key_value == 'inst' ? 'instituciones_cnae_por_municipio' : 'matricula_cnae_por_municipio')));

            // Actualizar el dato
            $sql_update = "UPDATE cnae_por_municipio SET $column = ? WHERE id_cnae_por_municipio = ?";
            $result_update = $conn->prepare($sql_update);
            $result_update->bindParam(1, $value);
            $result_update->bindParam(2, $municipio_id);
            $result_update->execute();
        }

        $response = array(
            'status' => 'success',
            'message' => 'Datos actualizados correctamente',
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

// FIN EDICION DE RECURSOS ASIGNADOS POR MES

// CARGA DE ENTREGAS POR MES

function Load_Data_CNAE ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del cnae_por_mes seleccionado
    $sql_cnae_por_mes = "SELECT * FROM cnae_por_mes WHERE id_cnae_por_mes = ?";
    $result_cnae_por_mes = $conn->prepare($sql_cnae_por_mes);
    $result_cnae_por_mes->bindParam(1, $id);
    $result_cnae_por_mes->execute();
    $cnae_por_mes = $result_cnae_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$cnae_por_mes) {
        header('Location: /admin/cnae');
        exit();
    }

    // Obtener todas las datas CNAE por municipio relacionado al municipio
    $sql_cnae_por_municipio = "SELECT * FROM cnae_por_municipio INNER JOIN municipios ON cnae_por_municipio.municipio_id_cnae_por_municipio = municipios.id_municipio WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ? ORDER BY cnae_por_municipio.id_cnae_por_municipio ASC";
    $result_cnae_por_municipio = $conn->prepare($sql_cnae_por_municipio);
    $result_cnae_por_municipio->bindParam(1, $id);
    $result_cnae_por_municipio->execute();
    $cnae_por_municipio = $result_cnae_por_municipio->fetchAll(PDO::FETCH_ASSOC);

    echo '<script>console.log(' . json_encode($cnae_por_municipio) . ')</script>';

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($cnae_por_mes['fecha_inicio_cnae_por_mes']));
    $month_id = $cnae_por_mes['id_cnae_por_mes'];

    $title = 'MINPPAL - CNAE - Carga de Entregas';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/cnae/cnae_load.php';
    include_once 'src/blocks/footer.php';
}

function POST_Data_CNAE () {
    try {

        // Recibiendo algo como esto
        // month_id=26&municipio=0&fecha_entrega=2023-06-05&clap=&proteina=&fruta=&instituciones=&matricula=

        // Si no es admin, no puede actualizar
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        // Verifica que se haya enviado el municipio, que sea numerico y que exista en la base de datos
        if (!isset($_POST['municipio']) || !is_numeric($_POST['municipio'])) {
            throw new Exception('Debe seleccionar un municipio');
        }

        require 'src/database/connection.php';

        $sql_municipio = "SELECT * FROM cnae_por_municipio 
                            LEFT JOIN cnae_por_mes ON cnae_por_municipio.mes_id_cnae_por_municipio = cnae_por_mes.id_cnae_por_mes
                            LEFT JOIN municipios ON cnae_por_municipio.municipio_id_cnae_por_municipio = municipios.id_municipio
                            WHERE cnae_por_municipio.id_cnae_por_municipio = ?"; 
        $result_municipio = $conn->prepare($sql_municipio);
        $result_municipio->bindParam(1, $_POST['municipio']);
        $result_municipio->execute();
        $municipio = $result_municipio->fetch(PDO::FETCH_ASSOC);

        if (!$municipio) {
            throw new Exception('El municipio seleccionado no existe');
        }

        // Verifica que se haya enviado la fecha, que sea una fecha valida
        if (!isset($_POST['fecha_entrega']) || !strtotime($_POST['fecha_entrega'])) {
            throw new Exception('Debe seleccionar una fecha valida');
        }

        // Verifica que la fecha seleccionada no sea mayor a la fecha actual
        if (date('Y-m-d') < $_POST['fecha_entrega']) {
            throw new Exception('La fecha seleccionada no puede ser mayor a la fecha actual');
        }

        // Verifica que la fecha seleccionada no sea menor a la fecha de inicio del mes
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_selected = strftime("%B %Y", strtotime($municipio['fecha_inicio_cnae_por_mes']));
        if ($_POST['fecha_entrega'] < $municipio['fecha_inicio_cnae_por_mes']) {
            throw new Exception('La fecha seleccionada no puede ser menor a la fecha de inicio del mes ' . $month_selected);
        }

        // Si clap, proteina, fruta, instituciones, matricula no se mandan vacios, deben ser numericos y mayores o iguales a 0, sino se establecen en 0
        $clap = (isset($_POST['clap']) && is_numeric($_POST['clap']) && $_POST['clap'] >= 0) ? $_POST['clap'] : 0;
        $proteina = (isset($_POST['proteina']) && is_numeric($_POST['proteina']) && $_POST['proteina'] >= 0) ? $_POST['proteina'] : 0;
        $fruta = (isset($_POST['fruta']) && is_numeric($_POST['fruta']) && $_POST['fruta'] >= 0) ? $_POST['fruta'] : 0;
        $instituciones = (isset($_POST['instituciones']) && is_numeric($_POST['instituciones']) && $_POST['instituciones'] >= 0) ? $_POST['instituciones'] : 0;
        $matricula = (isset($_POST['matricula']) && is_numeric($_POST['matricula']) && $_POST['matricula'] >= 0) ? $_POST['matricula'] : 0;

        // Proteina y fruta estan en kilogramos, se deben convertir a toneladas
        $proteina = $proteina / 1000;
        $fruta = $fruta / 1000;

        // Si todos los datos son 0, no se puede guardar
        if ($clap == 0 && $proteina == 0 && $fruta == 0 && $instituciones == 0 && $matricula == 0) {
            throw new Exception('Debe ingresar al menos un dato');
        }

        // Verificar que la cantidad de clap, proteina, fruta, instituciones, matricula que se estan enviando no sea mayor a la cantidad asignada
        // Para eso toma en cuenta la data actual del municipio y suma la data que se esta enviando
        // Si la data que se esta enviando es mayor a la data asignada, no se puede guardar

        $sql_cantidades_entregadas = "SELECT SUM(claps_despachados_cnae_carga) AS clap_despachados_cnae_carga, 
                                        SUM(proteina_despachada_cnae_carga) AS proteina_despachada_cnae_carga, 
                                        SUM(fruta_despachada_cnae_carga) AS fruta_despachada_cnae_carga, 
                                        SUM(instituciones_atendidas_cnae_carga) AS instituciones_atendidas_cnae_carga, 
                                        SUM(matricula_atendida_cnae_carga) AS matricula_atendida_cnae_carga 
                                        FROM cnae_carga WHERE cnae_por_municipio_id_cnae_carga = ?";
        $result_cantidades_entregadas = $conn->prepare($sql_cantidades_entregadas);
        $result_cantidades_entregadas->bindParam(1, $_POST['municipio']);
        $result_cantidades_entregadas->execute();
        $cantidades_entregadas = $result_cantidades_entregadas->fetch(PDO::FETCH_ASSOC);

        // Si clap, proteina, fruta, instituciones, matricula que se estan enviando es mayor a la cantidad asignada, no se puede guardar
        if (($clap + $cantidades_entregadas['clap_despachados_cnae_carga']) > $municipio['clap_asignados_cnae_por_municipio']) {
            throw new Exception('La cantidad de entregas clap que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($proteina + $cantidades_entregadas['proteina_despachada_cnae_carga']) > $municipio['proteina_asignada_cnae_por_municipio']) {
            throw new Exception('La cantidad de proteina que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($fruta + $cantidades_entregadas['fruta_despachada_cnae_carga']) > $municipio['fruta_asignada_cnae_por_municipio']) {
            throw new Exception('La cantidad de fruta que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($instituciones + $cantidades_entregadas['instituciones_atendidas_cnae_carga']) > $municipio['instituciones_cnae_por_municipio']) {
            throw new Exception('La cantidad de instituciones que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($matricula + $cantidades_entregadas['matricula_atendida_cnae_carga']) > $municipio['matricula_cnae_por_municipio']) {
            throw new Exception('La cantidad de matricula que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }

        // Guardar la data
        // id_cnae_carga 	cnae_por_municipio_id_cnae_carga 	matricula_atendida_cnae_carga 	instituciones_atendidas_cnae_carga 	proteina_despachada_cnae_carga 	claps_despachados_cnae_carga 	fruta_despachada_cnae_carga 	fecha_entrega_cnae_carga 	fecha_creacion_cnae_carga 	
        $sql_insert = "INSERT INTO cnae_carga (cnae_por_municipio_id_cnae_carga, matricula_atendida_cnae_carga, instituciones_atendidas_cnae_carga, 
                        proteina_despachada_cnae_carga, claps_despachados_cnae_carga, fruta_despachada_cnae_carga, fecha_entrega_cnae_carga, user_id_cnae_carga)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $result_insert = $conn->prepare($sql_insert);
        $result_insert->bindParam(1, $_POST['municipio']);
        $result_insert->bindParam(2, $matricula);
        $result_insert->bindParam(3, $instituciones);
        $result_insert->bindParam(4, $proteina);
        $result_insert->bindParam(5, $clap);
        $result_insert->bindParam(6, $fruta);
        $result_insert->bindParam(7, $_POST['fecha_entrega']);
        $result_insert->bindParam(8, $_SESSION['id']);
        $result_insert->execute();

        if ($result_insert->rowCount() == 0) {
            throw new Exception('No se pudo guardar la data');
        }

        $response = array(
            'status' => 'success',
            'message' => 'Data guardada correctamente',
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

function Export_PDF_CNAE_Por_Mes ($id) {
    try {
        
        require_once 'src/database/connection.php';

        // $sql = "SELECT * FROM cnae_por_mes WHERE id_cnae_por_mes = ?";
        $sql_cnae_por_mes = "SELECT cnae_por_mes.id_cnae_por_mes, cnae_por_mes.fecha_inicio_cnae_por_mes, cnae_por_mes.fecha_fin_cnae_por_mes, 
                                SUM(cnae_por_municipio.proteina_asignada_cnae_por_municipio) AS proteina_asignada_cnae_por_mes, 
                                SUM(cnae_por_municipio.clap_asignados_cnae_por_municipio) AS clap_asignados_cnae_por_mes, 
                                SUM(cnae_por_municipio.fruta_asignada_cnae_por_municipio) AS fruta_asignada_cnae_por_mes, 
                                SUM(cnae_por_municipio.instituciones_cnae_por_municipio) AS instituciones_cnae_por_mes, 
                                SUM(cnae_por_municipio.matricula_cnae_por_municipio) AS matricula_cnae_por_mes 
                                FROM cnae_por_mes INNER JOIN cnae_por_municipio ON cnae_por_mes.id_cnae_por_mes = cnae_por_municipio.mes_id_cnae_por_municipio 
                                WHERE cnae_por_mes.id_cnae_por_mes = ?
                                GROUP BY cnae_por_mes.id_cnae_por_mes ORDER BY cnae_por_mes.id_cnae_por_mes DESC";
        $result = $conn->prepare($sql_cnae_por_mes);
        $result->bindParam(1, $id);
        $result->execute();
        $cnae_por_mes = $result->fetch(PDO::FETCH_ASSOC);
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        // Quiero: Mayo 2020
        $month_selected = strftime("%B %Y", strtotime($cnae_por_mes['fecha_inicio_cnae_por_mes']));

        if (!$cnae_por_mes) {
            header('Location: /admin/cnae');
            exit();
        }

        // Obtener las sumatorias de las cargas
        $sql_cnae_carga = "SELECT SUM(cnae_carga.proteina_despachada_cnae_carga) AS proteina_despachada_cnae_carga, 
                                    SUM(cnae_carga.claps_despachados_cnae_carga) AS clap_despachados_cnae_carga, 
                                    SUM(cnae_carga.fruta_despachada_cnae_carga) AS fruta_despachada_cnae_carga, 
                                    SUM(cnae_carga.instituciones_atendidas_cnae_carga) AS instituciones_despachadas_cnae_carga, 
                                    SUM(cnae_carga.matricula_atendida_cnae_carga) AS matricula_despachada_cnae_carga 
                                    FROM cnae_carga INNER JOIN cnae_por_municipio ON cnae_carga.cnae_por_municipio_id_cnae_carga = cnae_por_municipio.id_cnae_por_municipio 
                                    WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ?";
        $result_cnae_carga = $conn->prepare($sql_cnae_carga);
        $result_cnae_carga->bindParam(1, $cnae_por_mes['id_cnae_por_mes']);
        $result_cnae_carga->execute();
        $cnae_carga = $result_cnae_carga->fetch(PDO::FETCH_ASSOC);

        // Obtener los porcentajes de las cargas, pendiente con la division por 0
        $porcentaje_proteina_despachada = $cnae_por_mes['proteina_asignada_cnae_por_mes'] == 0 ? 0 : ($cnae_carga['proteina_despachada_cnae_carga'] * 100) / $cnae_por_mes['proteina_asignada_cnae_por_mes'];
        $porcentaje_clap_despachados = $cnae_por_mes['clap_asignados_cnae_por_mes'] == 0 ? 0 : ($cnae_carga['clap_despachados_cnae_carga'] * 100) / $cnae_por_mes['clap_asignados_cnae_por_mes'];
        $porcentaje_fruta_despachada = $cnae_por_mes['fruta_asignada_cnae_por_mes'] == 0 ? 0 : ($cnae_carga['fruta_despachada_cnae_carga'] * 100) / $cnae_por_mes['fruta_asignada_cnae_por_mes'];
        $porcentaje_instituciones_despachadas = $cnae_por_mes['instituciones_cnae_por_mes'] == 0 ? 0 : ($cnae_carga['instituciones_despachadas_cnae_carga'] * 100) / $cnae_por_mes['instituciones_cnae_por_mes'];
        $porcentaje_matricula_despachada = $cnae_por_mes['matricula_cnae_por_mes'] == 0 ? 0 : ($cnae_carga['matricula_despachada_cnae_carga'] * 100) / $cnae_por_mes['matricula_cnae_por_mes'];

        // Obtener las cantidades asignadas y entregadas por municipio

        $sql_cnae_por_municipio = "SELECT * FROM cnae_por_municipio INNER JOIN municipios ON cnae_por_municipio.municipio_id_cnae_por_municipio = municipios.id_municipio 
                                    WHERE cnae_por_municipio.mes_id_cnae_por_municipio = ? ORDER BY cnae_por_municipio.id_cnae_por_municipio ASC";
        $result_cnae_por_municipio = $conn->prepare($sql_cnae_por_municipio);
        $result_cnae_por_municipio->bindParam(1, $id);
        $result_cnae_por_municipio->execute();
        $cnae_por_municipio = $result_cnae_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($cnae_por_municipio as $cnae) {
            
            // Obtener las sumatorias de las cargas
            $sql_cnae_carga = "SELECT SUM(cnae_carga.proteina_despachada_cnae_carga) AS proteina_despachada_cnae_carga,
                                        SUM(cnae_carga.claps_despachados_cnae_carga) AS clap_despachados_cnae_carga,
                                        SUM(cnae_carga.fruta_despachada_cnae_carga) AS fruta_despachada_cnae_carga,
                                        SUM(cnae_carga.instituciones_atendidas_cnae_carga) AS instituciones_despachadas_cnae_carga,
                                        SUM(cnae_carga.matricula_atendida_cnae_carga) AS matricula_despachada_cnae_carga
                                        FROM cnae_carga WHERE cnae_por_municipio_id_cnae_carga = ?";
            $result_cnae_carga_mun = $conn->prepare($sql_cnae_carga);
            $result_cnae_carga_mun->bindParam(1, $cnae['id_cnae_por_municipio']);
            $result_cnae_carga_mun->execute();
            $cnae_carga_mun = $result_cnae_carga_mun->fetch(PDO::FETCH_ASSOC);

            // $cnae['proteina_asignada_cnae_por_municipio'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada_mun = $cnae['proteina_asignada_cnae_por_municipio'] != 0 ? ($cnae_carga_mun['proteina_despachada_cnae_carga'] * 100) / $cnae['proteina_asignada_cnae_por_municipio'] : 0;
            $porcentaje_clap_despachados_mun = $cnae['clap_asignados_cnae_por_municipio'] != 0 ? ($cnae_carga_mun['clap_despachados_cnae_carga'] * 100) / $cnae['clap_asignados_cnae_por_municipio'] : 0;
            $porcentaje_fruta_despachada_mun = $cnae['fruta_asignada_cnae_por_municipio'] != 0 ? ($cnae_carga_mun['fruta_despachada_cnae_carga'] * 100) / $cnae['fruta_asignada_cnae_por_municipio'] : 0;
            $porcentaje_instituciones_despachadas_mun = $cnae['instituciones_cnae_por_municipio'] != 0 ? ($cnae_carga_mun['instituciones_despachadas_cnae_carga'] * 100) / $cnae['instituciones_cnae_por_municipio'] : 0;
            $porcentaje_matricula_despachada_mun = $cnae['matricula_cnae_por_municipio'] != 0 ? ($cnae_carga_mun['matricula_despachada_cnae_carga'] * 100) / $cnae['matricula_cnae_por_municipio'] : 0;
            $diff_proteina = $cnae['proteina_asignada_cnae_por_municipio'] - $cnae_carga_mun['proteina_despachada_cnae_carga'];
            $diff_clap = $cnae['clap_asignados_cnae_por_municipio'] - $cnae_carga_mun['clap_despachados_cnae_carga'];
            $diff_fruta = $cnae['fruta_asignada_cnae_por_municipio'] - $cnae_carga_mun['fruta_despachada_cnae_carga'];
            $diff_instituciones = $cnae['instituciones_cnae_por_municipio'] - $cnae_carga_mun['instituciones_despachadas_cnae_carga'];
            $diff_matricula = $cnae['matricula_cnae_por_municipio'] - $cnae_carga_mun['matricula_despachada_cnae_carga'];

            $data_return[] = array(
                'id_cnae_por_municipio' => $cnae['id_cnae_por_municipio'],
                'municipio_id_cnae_por_municipio' => $cnae['municipio_id_cnae_por_municipio'],
                'name_municipio' => $cnae['name_municipio'],
                'proteina_asignada_cnae_por_municipio' => number_format($cnae['proteina_asignada_cnae_por_municipio'], 2, ',', '.'),
                'clap_asignados_cnae_por_municipio' => number_format($cnae['clap_asignados_cnae_por_municipio'], 0, ',', '.'),
                'fruta_asignada_cnae_por_municipio' => number_format($cnae['fruta_asignada_cnae_por_municipio'], 2, ',', '.'),
                'instituciones_cnae_por_municipio' => number_format($cnae['instituciones_cnae_por_municipio'], 0, ',', '.'),
                'matricula_cnae_por_municipio' => number_format($cnae['matricula_cnae_por_municipio'], 0, ',', '.'),
                'proteina_despachada_cnae_carga' => number_format($cnae_carga_mun['proteina_despachada_cnae_carga'], 2, ',', '.'),
                'clap_despachados_cnae_carga' => number_format($cnae_carga_mun['clap_despachados_cnae_carga'], 0, ',', '.'),
                'fruta_despachada_cnae_carga' => number_format($cnae_carga_mun['fruta_despachada_cnae_carga'], 2, ',', '.'),
                'instituciones_despachadas_cnae_carga' => number_format($cnae_carga_mun['instituciones_despachadas_cnae_carga'], 0, ',', '.'),
                'matricula_despachada_cnae_carga' => number_format($cnae_carga_mun['matricula_despachada_cnae_carga'] , 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada_mun, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados_mun, 2, ',', '.'),
                'porcentaje_fruta_despachada' => number_format($porcentaje_fruta_despachada_mun, 2, ',', '.'),
                'porcentaje_instituciones_despachadas' => number_format($porcentaje_instituciones_despachadas_mun, 2, ',', '.'),
                'porcentaje_matricula_despachada' => number_format($porcentaje_matricula_despachada_mun, 2, ',', '.'),
                'diff_proteina' => $diff_proteina,
                'diff_clap' => $diff_clap,
                'diff_fruta' => $diff_fruta,
                'diff_instituciones' => $diff_instituciones,
                'diff_matricula' => $diff_matricula,
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

        // Establecer la configuración básica del documento PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MINPPAL');
        $pdf->SetTitle('Reporte CNAE - ' . $month_selected);
        $pdf->SetSubject('Reporte CNAE - ' . $month_selected);
        $pdf->SetKeywords('MINPPAL, PDF, CNAE, Reporte, ' . $month_selected);

        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte CNAE - ' . $month_selected, 0, 1, 'C');
        $pdf->Ln(2);

        $html = '
        <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Instituciones Asignadas</th>
                    <th class="description">Matricula Asignada</th>
                    <th class="description">Proteina Asignada</th>
                    <th class="description">Fruver Asignado</th>
                    <th class="description">Clap Asignados</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Instituciones Atendidas</th>
                    <th class="description">Matricula Atendida</th>
                    <th class="description">Proteina Despachada</th>
                    <th class="description">Fruver Despachado</th>
                    <th class="description">Clap Despachados</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Porcentaje de Instituciones Atendidas</th>
                    <th class="description">Porcentaje de Matricula Atendida</th>
                    <th class="description">Porcentaje de Proteina Despachada</th>
                    <th class="description">Porcentaje de Fruver Despachado</th>
                    <th class="description">Porcentaje de Clap Despachados</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($cnae_por_mes['instituciones_cnae_por_mes'], 0, ',', '.') . '</td>
                    <td>' . number_format($cnae_por_mes['matricula_cnae_por_mes'], 0, ',', '.') . '</td>
                    <td>' . number_format($cnae_por_mes['proteina_asignada_cnae_por_mes'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($cnae_por_mes['fruta_asignada_cnae_por_mes'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($cnae_por_mes['clap_asignados_cnae_por_mes'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($cnae_carga['instituciones_despachadas_cnae_carga'], 0, ',', '.') . '</td>
                    <td>' . number_format($cnae_carga['matricula_despachada_cnae_carga'], 0, ',', '.') . '</td>
                    <td>' . number_format($cnae_carga['proteina_despachada_cnae_carga'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($cnae_carga['fruta_despachada_cnae_carga'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($cnae_carga['clap_despachados_cnae_carga'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($porcentaje_instituciones_despachadas, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_matricula_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_proteina_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_fruta_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_clap_despachados, 2, ',', '.') . '%</td>
                </tr>
            </tbody>
        </table>
        ';

        $html_diff_cnae_carga = '';
        if ($cnae_por_mes['instituciones_cnae_por_mes'] > $cnae_carga['instituciones_despachadas_cnae_carga']) {
            $html_diff_cnae_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($cnae_por_mes['instituciones_cnae_por_mes'] - $cnae_carga['instituciones_despachadas_cnae_carga'], 0, ',', '.') . ' instituciones sin atender
            </h6>
            ';
        }
        if ($cnae_por_mes['matricula_cnae_por_mes'] > $cnae_carga['matricula_despachada_cnae_carga']) {
            $html_diff_cnae_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($cnae_por_mes['matricula_cnae_por_mes'] - $cnae_carga['matricula_despachada_cnae_carga'], 0, ',', '.') . ' matriculas sin atender
            </h6>
            ';
        }
        if ($cnae_por_mes['proteina_asignada_cnae_por_mes'] > $cnae_carga['proteina_despachada_cnae_carga']) {
            $html_diff_cnae_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($cnae_por_mes['proteina_asignada_cnae_por_mes'] - $cnae_carga['proteina_despachada_cnae_carga'], 2, ',', '.') . ' TON de proteina sin despachar
            </h6>
            ';
        }
        if ($cnae_por_mes['fruta_asignada_cnae_por_mes'] > $cnae_carga['fruta_despachada_cnae_carga']) {
            $html_diff_cnae_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($cnae_por_mes['fruta_asignada_cnae_por_mes'] - $cnae_carga['fruta_despachada_cnae_carga'], 2, ',', '.') . ' TON de fruta sin despachar
            </h6>
            ';
        }
        if ($cnae_por_mes['clap_asignados_cnae_por_mes'] > $cnae_carga['clap_despachados_cnae_carga']) {
            $html_diff_cnae_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($cnae_por_mes['clap_asignados_cnae_por_mes'] - $cnae_carga['clap_despachados_cnae_carga'], 0, ',', '.') . ' CLAP sin despachar
            </h6>
            ';
        }

        $html .= $html_diff_cnae_carga;

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // HTML Tablas por municipio separadas
        // Se recorre el array de municipios (data_return)

        $html_tablas_por_municipio = '';

        foreach ($data_return as $municipio) {

            $html_tablas_por_municipio .= '
            <h6 style="text-align: center; color: #001640">' . $municipio['name_municipio'] . '</h6>
            <table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Instituciones Asignadas</th>
                        <th class="description">Matricula Asignada</th>
                        <th class="description">Proteina Asignada</th>
                        <th class="description">Fruta Asignada</th>
                        <th class="description">Clap Asignados</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Instituciones Atendidas</th>
                        <th class="description">Matricula Atendida</th>
                        <th class="description">Proteina Despachada</th>
                        <th class="description">Fruta Despachada</th>
                        <th class="description">Clap Despachados</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Porcentaje de Instituciones Atendidas</th>
                        <th class="description">Porcentaje de Matricula Atendida</th>
                        <th class="description">Porcentaje de Proteina Despachada</th>
                        <th class="description">Porcentaje de Fruta Despachada</th>
                        <th class="description">Porcentaje de Clap Despachados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['instituciones_cnae_por_municipio'] . '</td>
                        <td>' . $municipio['matricula_cnae_por_municipio']. '</td>
                        <td>' . $municipio['proteina_asignada_cnae_por_municipio'] . ' TON</td>
                        <td>' . $municipio['fruta_asignada_cnae_por_municipio'] . ' TON</td>
                        <td>' . $municipio['clap_asignados_cnae_por_municipio'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['instituciones_despachadas_cnae_carga'] . '</td>
                        <td>' . $municipio['matricula_despachada_cnae_carga'] . '</td>
                        <td>' . $municipio['proteina_despachada_cnae_carga'] . ' TON</td>
                        <td>' . $municipio['fruta_despachada_cnae_carga'] . ' TON</td>
                        <td>' . $municipio['clap_despachados_cnae_carga'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['porcentaje_instituciones_despachadas'] . '%</td>
                        <td>' . $municipio['porcentaje_matricula_despachada'] . '%</td>
                        <td>' . $municipio['porcentaje_proteina_despachada'] . '%</td>
                        <td>' . $municipio['porcentaje_fruta_despachada'] . '%</td>
                        <td>' . $municipio['porcentaje_clap_despachados'] . '%</td>
                    </tr>
                </tbody>
            </table>
            ';
            if ($municipio['diff_proteina'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_proteina'], 2, ',', '.') . ' TON de proteina sin despachar
                </h6>
                ';
            }
            if ($municipio['diff_clap'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_clap'], 0, ',', '.') . ' CLAP sin despachar
                </h6>
                ';
            }
            if ($municipio['diff_fruta'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_fruta'], 2, ',', '.') . ' TON de fruta sin despachar
                </h6>
                ';
            }
            if ($municipio['diff_instituciones'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_instituciones'], 0, ',', '.') . ' instituciones sin despachar
                </h6>
                ';
            }
            if ($municipio['diff_matricula'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_matricula'], 0, ',', '.') . ' matricula sin despachar
                </h6>
                ';
            }
        }

        $pdf->writeHTML($html_tablas_por_municipio, true, false, true, false, '');

        $pdf->Output('Reporte CNAE - ' . $month_selected . '.pdf', 'I');

    } catch (\Throwable $th) {
        
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}