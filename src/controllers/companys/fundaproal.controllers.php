<?php


// Crear class FUNDAPROAL_Por_Mes, esta contiene: fecha_inicio_fundaproal_por_mes, fecha_fin_fundaproal_por_mes
class FUNDAPROAL_Por_Mes {
    public $fecha_inicio_fundaproal_por_mes;
    public $fecha_fin_fundaproal_por_mes;

    public function __construct($fecha_inicio_fundaproal_por_mes, $fecha_fin_fundaproal_por_mes) {
        $this->fecha_inicio_fundaproal_por_mes = $fecha_inicio_fundaproal_por_mes;
        $this->fecha_fin_fundaproal_por_mes = $fecha_fin_fundaproal_por_mes;
    }
}

// Crear class FUNDAPROAL_Por_Municipio, esta contiene: municipio_id	mes_id	proteina_asignada 	clap_asignados 	fruta_asignada 	cantidad_casas_alimentacion     cantidad_misioneros      cantidad_madres_elab     cantidad_padres_elab     cemr   plan_papa_asignado     plan_paca_asignado
// Ademas es un array de FUNDAPROAL_Por_Municipio
class FUNDAPROAL_Por_Municipio {
    public $municipio_id;
    public $mes_id;
    public $proteina_asignada;
    public $clap_asignados;
    public $fruta_asignada;
    public $cantidad_casas_alimentacion;
    public $cantidad_misioneros;
    public $cantidad_madres_elab;
    public $cantidad_padres_elab;
    public $cemr;
    public $plan_papa_asignado;
    public $plan_paca_asignado;

    public function __construct($municipio_id, $mes_id, $proteina_asignada, $clap_asignados, $fruta_asignada, $cantidad_casas_alimentacion, $cantidad_misioneros, $cantidad_madres_elab, $cantidad_padres_elab, $cemr, $plan_papa_asignado, $plan_paca_asignado) {
        $this->municipio_id = $municipio_id;
        $this->mes_id = $mes_id;
        $this->proteina_asignada = $proteina_asignada;
        $this->clap_asignados = $clap_asignados;
        $this->fruta_asignada = $fruta_asignada;
        $this->cantidad_casas_alimentacion = $cantidad_casas_alimentacion;
        $this->cantidad_misioneros = $cantidad_misioneros;
        $this->cantidad_madres_elab = $cantidad_madres_elab;
        $this->cantidad_padres_elab = $cantidad_padres_elab;
        $this->cemr = $cemr;
        $this->plan_papa_asignado = $plan_papa_asignado;
        $this->plan_paca_asignado = $plan_paca_asignado;
    }
}

function Create_New_Data_FUNDAPROAL ($last_month) {
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
        $data_fundaproal_por_mes = new FUNDAPROAL_Por_Mes($first_day_of_month, $last_day_of_month);

        // Inserta en la tabla fundaproal_por_mes
        $sql_insert_fundaproal_por_mes = "INSERT INTO fundaproal_por_mes (fecha_inicio_fundaproal_por_mes, fecha_fin_fundaproal_por_mes) VALUES (?, ?)";
        $result_insert_fundaproal_por_mes = $conn->prepare($sql_insert_fundaproal_por_mes);
        $result_insert_fundaproal_por_mes->bindParam(1, $data_fundaproal_por_mes->fecha_inicio_fundaproal_por_mes);
        $result_insert_fundaproal_por_mes->bindParam(2, $data_fundaproal_por_mes->fecha_fin_fundaproal_por_mes);
        $result_insert_fundaproal_por_mes->execute();
        $id_fundaproal_por_mes = $conn->lastInsertId();

        // Recorrer listado de municipios
        foreach ($municipios as $municipio) {
            if ($last_month === null) {
                // $data_fundaproal_por_municipio = new FUNDAPROAL_Por_Municipio($municipio['id_municipio'], $id_fundaproal_por_mes, 0, 0, 0, 0, 0);
                $data_fundaproal_por_municipio = new FUNDAPROAL_Por_Municipio($municipio['id_municipio'], $id_fundaproal_por_mes, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            } else {
                // Obtener los datos del ultimo mes registrado para que se copien en el nuevo mes
                $sql_last_month_data = "SELECT * FROM fundaproal_por_municipio WHERE mes_id = ? AND municipio_id = ?";
                $result_last_month_data = $conn->prepare($sql_last_month_data);
                $result_last_month_data->bindParam(1, $last_month['id_fundaproal_por_mes']);
                $result_last_month_data->bindParam(2, $municipio['id_municipio']);
                $result_last_month_data->execute();
                $last_month_data = $result_last_month_data->fetch(PDO::FETCH_ASSOC);

                $data_fundaproal_por_municipio = new FUNDAPROAL_Por_Municipio($municipio['id_municipio'], 
                    $id_fundaproal_por_mes, $last_month_data['proteina_asignada'], $last_month_data['clap_asignados'], 
                    $last_month_data['fruta_asignada'], $last_month_data['cantidad_casas_alimentacion'],
                    $last_month_data['cantidad_misioneros'], $last_month_data['cantidad_madres_elab'],
                    $last_month_data['cantidad_padres_elab'], $last_month_data['cemr'],
                    $last_month_data['plan_papa_asignado'], $last_month_data['plan_paca_asignado']);
            }

            // Inserta en la tabla fundaproal_por_municipio
            $sql_insert_fundaproal_por_municipio = "INSERT INTO fundaproal_por_municipio (municipio_id, mes_id, proteina_asignada, clap_asignados, fruta_asignada, plan_papa_asignado, plan_paca_asignado, cantidad_casas_alimentacion, cantidad_misioneros, cantidad_madres_elab, cantidad_padres_elab, cemr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $result_insert_fundaproal_por_municipio = $conn->prepare($sql_insert_fundaproal_por_municipio);
            $result_insert_fundaproal_por_municipio->bindParam(1, $data_fundaproal_por_municipio->municipio_id);
            $result_insert_fundaproal_por_municipio->bindParam(2, $data_fundaproal_por_municipio->mes_id);
            $result_insert_fundaproal_por_municipio->bindParam(3, $data_fundaproal_por_municipio->proteina_asignada);
            $result_insert_fundaproal_por_municipio->bindParam(4, $data_fundaproal_por_municipio->clap_asignados);
            $result_insert_fundaproal_por_municipio->bindParam(5, $data_fundaproal_por_municipio->fruta_asignada);
            $result_insert_fundaproal_por_municipio->bindParam(6, $data_fundaproal_por_municipio->plan_papa_asignado);
            $result_insert_fundaproal_por_municipio->bindParam(7, $data_fundaproal_por_municipio->plan_paca_asignado);
            $result_insert_fundaproal_por_municipio->bindParam(8, $data_fundaproal_por_municipio->cantidad_casas_alimentacion);
            $result_insert_fundaproal_por_municipio->bindParam(9, $data_fundaproal_por_municipio->cantidad_misioneros);
            $result_insert_fundaproal_por_municipio->bindParam(10, $data_fundaproal_por_municipio->cantidad_madres_elab);
            $result_insert_fundaproal_por_municipio->bindParam(11, $data_fundaproal_por_municipio->cantidad_padres_elab);
            $result_insert_fundaproal_por_municipio->bindParam(12, $data_fundaproal_por_municipio->cemr);
            $result_insert_fundaproal_por_municipio->execute();
        }


    } catch (\Throwable $th) {
        //throw $th;
    }
}

function FUNDAPROAL_Viewer () {
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener el ultimo mes registrado
    $sql_last_month = "SELECT * FROM fundaproal_por_mes ORDER BY id_fundaproal_por_mes DESC LIMIT 1";
    $result_last_month = $conn->prepare($sql_last_month);
    $result_last_month->execute();
    $last_month = $result_last_month->fetch(PDO::FETCH_ASSOC);

    // Si el ultimo mes registrado es el actual, no se puede crear un nuevo mes
    // Si el ultimo mes registrado ya es el anterior, se puede crear un nuevo mes
    // fin_fundaproal_por_mes, tiene el ultimo dia del mes registrado: Ej: 2021-05-31
    // Verifica si la fecha actual es mayor a la fecha del ultimo mes registrado
    if ($last_month) {
        if (date('Y-m-d') > $last_month['fecha_fin_fundaproal_por_mes']) {
            Create_New_Data_FUNDAPROAL($last_month);
        }
    } else {
        Create_New_Data_FUNDAPROAL(null);
    }

    // Obtener todas las datas FUNDAPROAL por mes
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $offset = ($page - 1) * $limit;

    // $sql_fundaproal_por_mes = "SELECT * FROM fundaproal_por_mes ORDER BY id_fundaproal_por_mes DESC LIMIT $offset, $limit";
    // necesito que me traiga la sumatoria de los fundaproal_por_municipio (proteina_asignada, clap_asignados, fruta_asignada, cantidad_casas_alimentacion, cemr, cantidad_misioneros, cantidad_madres_elab, cantidad_padres_elab, plan_paca_asignado, plan_papa_asignado)
    $sql_fundaproal_por_mes = "SELECT fundaproal_por_mes.id_fundaproal_por_mes, fundaproal_por_mes.fecha_inicio_fundaproal_por_mes, fundaproal_por_mes.fecha_fin_fundaproal_por_mes, 
                                SUM(fundaproal_por_municipio.proteina_asignada) AS proteina_asignada, 
                                SUM(fundaproal_por_municipio.clap_asignados) AS clap_asignados, 
                                SUM(fundaproal_por_municipio.fruta_asignada) AS fruta_asignada, 
                                SUM(fundaproal_por_municipio.cantidad_casas_alimentacion) AS cantidad_casas_alimentacion,
                                SUM(fundaproal_por_municipio.cemr) AS cemr,
                                SUM(fundaproal_por_municipio.cantidad_misioneros) AS cantidad_misioneros,
                                SUM(fundaproal_por_municipio.cantidad_madres_elab) AS cantidad_madres_elab,
                                SUM(fundaproal_por_municipio.cantidad_padres_elab) AS cantidad_padres_elab,
                                SUM(fundaproal_por_municipio.plan_paca_asignado) AS plan_paca_asignado,
                                SUM(fundaproal_por_municipio.plan_papa_asignado) AS plan_papa_asignado
                                FROM fundaproal_por_mes INNER JOIN fundaproal_por_municipio ON fundaproal_por_mes.id_fundaproal_por_mes = fundaproal_por_municipio.mes_id 
                                GROUP BY fundaproal_por_mes.id_fundaproal_por_mes ORDER BY fundaproal_por_mes.id_fundaproal_por_mes DESC LIMIT $offset, $limit";
    $result_fundaproal_por_mes = $conn->prepare($sql_fundaproal_por_mes);
    $result_fundaproal_por_mes->execute();
    $fundaproal_por_mes = $result_fundaproal_por_mes->fetchAll(PDO::FETCH_ASSOC);

    $data_return = array();

    foreach ($fundaproal_por_mes as $fundaproal) {

        // Obtener las sumatorias de las cargas
        $sql_fundaproal_carga = "SELECT SUM(fundaproal_carga.proteina_despachada) AS proteina_despachada, 
                                    SUM(fundaproal_carga.clap_despachados) AS clap_despachados, 
                                    SUM(fundaproal_carga.fruta_despachada) AS fruta_despachada, 
                                    SUM(fundaproal_carga.plan_paca_despachado) AS plan_paca_despachado,
                                    SUM(fundaproal_carga.plan_papa_despachado) AS plan_papa_despachado
                                    FROM fundaproal_carga INNER JOIN fundaproal_por_municipio ON fundaproal_carga.fundaproal_por_municipio_id = fundaproal_por_municipio.id_fundaproal_por_municipio 
                                    WHERE fundaproal_por_municipio.mes_id = ?";
        $result_fundaproal_carga = $conn->prepare($sql_fundaproal_carga);
        $result_fundaproal_carga->bindParam(1, $fundaproal['id_fundaproal_por_mes']);
        $result_fundaproal_carga->execute();
        $fundaproal_carga = $result_fundaproal_carga->fetch(PDO::FETCH_ASSOC);

        $data_return[] = array(
            'id_fundaproal_por_mes' => $fundaproal['id_fundaproal_por_mes'],
            'fecha_inicio_fundaproal_por_mes' => $fundaproal['fecha_inicio_fundaproal_por_mes'],
            'fecha_fin_fundaproal_por_mes' => $fundaproal['fecha_fin_fundaproal_por_mes'],
            'proteina_asignada' => number_format($fundaproal['proteina_asignada'], 2, ',', '.'),
            'clap_asignados' => number_format($fundaproal['clap_asignados'], 0, ',', '.'),
            'fruta_asignada' => number_format($fundaproal['fruta_asignada'], 2, ',', '.'),
            'cantidad_casas_alimentacion' => number_format($fundaproal['cantidad_casas_alimentacion'], 0, ',', '.'),
            'cemr' => number_format($fundaproal['cemr'], 0, ',', '.'),
            'cantidad_misioneros' => number_format($fundaproal['cantidad_misioneros'], 0, ',', '.'),
            'cantidad_madres_elab' => number_format($fundaproal['cantidad_madres_elab'], 0, ',', '.'),
            'cantidad_padres_elab' => number_format($fundaproal['cantidad_padres_elab'], 0, ',', '.'),
            'plan_paca_asignado' => number_format($fundaproal['plan_paca_asignado'], 0, ',', '.'),
            'plan_papa_asignado' => number_format($fundaproal['plan_papa_asignado'], 0, ',', '.'),
            'proteina_despachada' => number_format($fundaproal_carga['proteina_despachada'], 2, ',', '.'),
            'clap_despachados' => number_format($fundaproal_carga['clap_despachados'], 0, ',', '.'),
            'fruta_despachada' => number_format($fundaproal_carga['fruta_despachada'], 2, ',', '.'),
            'plan_paca_despachado' => number_format($fundaproal_carga['plan_paca_despachado'], 0, ',', '.'),
            'plan_papa_despachado' => number_format($fundaproal_carga['plan_papa_despachado'], 0, ',', '.'),
            'porcentaje_proteina_despachada' => $fundaproal['proteina_asignada'] == 0 ? 0 : number_format(($fundaproal_carga['proteina_despachada'] / $fundaproal['proteina_asignada']) * 100, 2, ',', '.'),
            'porcentaje_clap_despachados' => $fundaproal['clap_asignados'] == 0 ? 0 : number_format(($fundaproal_carga['clap_despachados'] / $fundaproal['clap_asignados']) * 100, 2, ',', '.'),
            'porcentaje_fruta_despachada' => $fundaproal['fruta_asignada'] == 0 ? 0 : number_format(($fundaproal_carga['fruta_despachada'] / $fundaproal['fruta_asignada']) * 100, 2, ',', '.'),
            'porcentaje_plan_paca_despachado' => $fundaproal['plan_paca_asignado'] == 0 ? 0 : number_format(($fundaproal_carga['plan_paca_despachado'] / $fundaproal['plan_paca_asignado']) * 100, 2, ',', '.'),
            'porcentaje_plan_papa_despachado' => $fundaproal['plan_papa_asignado'] == 0 ? 0 : number_format(($fundaproal_carga['plan_papa_despachado'] / $fundaproal['plan_papa_asignado']) * 100, 2, ',', '.'),
        );
    }

    // Console_log($data_return);
    echo '<script>console.log(' . json_encode($data_return) . ')</script>';

    // Obtener el total
    $sql_total = "SELECT COUNT(*) AS total FROM fundaproal_por_mes";
    $result_total = $conn->prepare($sql_total);
    $result_total->execute();
    $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($total / $limit);

    $title = 'MINPPAL - FUNDAPROAL';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/fundaproal/fundaproal_viewer.php';
    include_once 'src/blocks/footer.php';
}

function Get_FUNDAPROAL_Por_Mes ($id) {
    try {
        require 'src/database/connection.php';

        // Obtener todas las datas FUNDAPROAL por mes, igual su relacion con fundaproal_por_municipio
        $sql_fundaproal_por_mes = "SELECT fundaproal_por_mes.id_fundaproal_por_mes, fundaproal_por_mes.fecha_inicio_fundaproal_por_mes, fundaproal_por_mes.fecha_fin_fundaproal_por_mes, 
        SUM(fundaproal_por_municipio.proteina_asignada) AS proteina_asignada, 
        SUM(fundaproal_por_municipio.clap_asignados) AS clap_asignados, 
        SUM(fundaproal_por_municipio.fruta_asignada) AS fruta_asignada,
        SUM(fundaproal_por_municipio.cantidad_casas_alimentacion) AS cantidad_casas_alimentacion,
        SUM(fundaproal_por_municipio.cantidad_misioneros) AS cantidad_misioneros,
        SUM(fundaproal_por_municipio.cantidad_madres_elab) AS cantidad_madres_elab,
        SUM(fundaproal_por_municipio.cantidad_padres_elab) AS cantidad_padres_elab,
        SUM(fundaproal_por_municipio.plan_paca_asignado) AS plan_paca_asignado,
        SUM(fundaproal_por_municipio.plan_papa_asignado) AS plan_papa_asignado,
        SUM(fundaproal_por_municipio.cemr) AS cemr
        FROM fundaproal_por_mes INNER JOIN fundaproal_por_municipio ON fundaproal_por_mes.id_fundaproal_por_mes = fundaproal_por_municipio.mes_id 
        WHERE fundaproal_por_mes.id_fundaproal_por_mes = ? GROUP BY fundaproal_por_mes.id_fundaproal_por_mes ORDER BY fundaproal_por_mes.id_fundaproal_por_mes DESC";
        $result_fundaproal_por_mes = $conn->prepare($sql_fundaproal_por_mes);
        $result_fundaproal_por_mes->bindParam(1, $id);
        $result_fundaproal_por_mes->execute();
        $fundaproal_por_mes = $result_fundaproal_por_mes->fetch(PDO::FETCH_ASSOC);

        // // Si no existe el mes, redireccionar
        if (!$fundaproal_por_mes) {
            header('Location: /admin/fundaproal');
            exit();
        }

        // // Paginacion
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $offset = ($page - 1) * $limit;

        // // Obtener todas las datas FUNDAPROAL por municipio relacionado al municipio
        $sql_fundaproal_por_municipio = "SELECT * FROM fundaproal_por_municipio INNER JOIN municipios ON fundaproal_por_municipio.municipio_id = municipios.id_municipio WHERE fundaproal_por_municipio.mes_id = ? ORDER BY fundaproal_por_municipio.id_fundaproal_por_municipio ASC LIMIT $limit OFFSET $offset";
        $result_fundaproal_por_municipio = $conn->prepare($sql_fundaproal_por_municipio);
        $result_fundaproal_por_municipio->bindParam(1, $id);
        $result_fundaproal_por_municipio->execute();
        $fundaproal_por_municipio = $result_fundaproal_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($fundaproal_por_municipio as $fundaproal) {
            
            // Obtener las sumatorias de las cargas
            $sql = "SELECT SUM(fundaproal_carga.proteina_despachada) AS proteina_despachada,
                                        SUM(fundaproal_carga.clap_despachados) AS clap_despachados,
                                        SUM(fundaproal_carga.fruta_despachada) AS fruta_despachada,
                                        SUM(fundaproal_carga.plan_paca_despachado) AS plan_paca_despachado,
                                        SUM(fundaproal_carga.plan_papa_despachado) AS plan_papa_despachado
                                        FROM fundaproal_carga WHERE fundaproal_por_municipio_id = ?";
            $result = $conn->prepare($sql);
            $result->bindParam(1, $fundaproal['id_fundaproal_por_municipio']);
            $result->execute();
            $fundaproal_carga = $result->fetch(PDO::FETCH_ASSOC);

            // $fundaproal['proteina_asignada'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada = $fundaproal['proteina_asignada'] != 0 ? ($fundaproal_carga['proteina_despachada'] * 100) / $fundaproal['proteina_asignada'] : 0;
            $porcentaje_clap_despachados = $fundaproal['clap_asignados'] != 0 ? ($fundaproal_carga['clap_despachados'] * 100) / $fundaproal['clap_asignados'] : 0;
            $porcentaje_fruta_despachada = $fundaproal['fruta_asignada'] != 0 ? ($fundaproal_carga['fruta_despachada'] * 100) / $fundaproal['fruta_asignada'] : 0;
            $porcentaje_plan_paca_despachado = $fundaproal['plan_paca_asignado'] != 0 ? ($fundaproal_carga['plan_paca_despachado'] * 100) / $fundaproal['plan_paca_asignado'] : 0;
            $porcentaje_plan_papa_despachado = $fundaproal['plan_papa_asignado'] != 0 ? ($fundaproal_carga['plan_papa_despachado'] * 100) / $fundaproal['plan_papa_asignado'] : 0;

            $data_return[] = array(
                'id_fundaproal_por_municipio' => $fundaproal['id_fundaproal_por_municipio'],
                'municipio_id' => $fundaproal['municipio_id'],
                'name_municipio' => $fundaproal['name_municipio'],
                'cantidad_casas_alimentacion' => number_format($fundaproal['cantidad_casas_alimentacion'], 0, ',', '.'),
                'cantidad_misioneros' => number_format($fundaproal['cantidad_misioneros'], 0, ',', '.'),
                'cantidad_madres_elab' => number_format($fundaproal['cantidad_madres_elab'], 0, ',', '.'),
                'cantidad_padres_elab' => number_format($fundaproal['cantidad_padres_elab'], 0, ',', '.'),
                'cemr' => number_format($fundaproal['cemr'], 0, ',', '.'),
                'proteina_asignada' => number_format($fundaproal['proteina_asignada'], 2, ',', '.'),
                'clap_asignados' => number_format($fundaproal['clap_asignados'], 0, ',', '.'),
                'fruta_asignada' => number_format($fundaproal['fruta_asignada'], 2, ',', '.'),
                'plan_paca_asignado' => number_format($fundaproal['plan_paca_asignado'], 0, ',', '.'),
                'plan_papa_asignado' => number_format($fundaproal['plan_papa_asignado'], 0, ',', '.'),
                'proteina_despachada' => number_format($fundaproal_carga['proteina_despachada'], 2, ',', '.'),
                'clap_despachados' => number_format($fundaproal_carga['clap_despachados'], 0, ',', '.'),
                'fruta_despachada' => number_format($fundaproal_carga['fruta_despachada'], 2, ',', '.'),
                'plan_paca_despachado' => number_format($fundaproal_carga['plan_paca_despachado'], 0, ',', '.'),
                'plan_papa_despachado' => number_format($fundaproal_carga['plan_papa_despachado'], 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados, 2, ',', '.'),
                'porcentaje_fruta_despachada' => number_format($porcentaje_fruta_despachada, 2, ',', '.'),
                'porcentaje_plan_paca_despachado' => number_format($porcentaje_plan_paca_despachado, 2, ',', '.'),
                'porcentaje_plan_papa_despachado' => number_format($porcentaje_plan_papa_despachado, 2, ',', '.'),
            );
        }

        echo '<script>console.log(' . json_encode($data_return) . ')</script>';

        // Obtener el total
        $sql_total = "SELECT COUNT(*) AS total FROM fundaproal_por_municipio WHERE mes_id = ?";
        $result_total = $conn->prepare($sql_total);
        $result_total->bindParam(1, $id);
        $result_total->execute();
        $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_year = strftime("%B %Y", strtotime($fundaproal_por_mes['fecha_inicio_fundaproal_por_mes']));

        $title = 'MINPPAL - FUNDAPROAL - ' . $month_year;
        include_once 'src/blocks/header.php';
        include_once 'src/blocks/menu/admin/menu.php';
        include_once 'src/blocks/menu/admin/menu_responsive.php';
        include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
        include_once 'src/views/admin/companies/fundaproal/fundaproal_municipios.php';
        include_once 'src/blocks/footer.php';
    } catch (\Throwable $th) {
        //throw $th;
    }

}

// EDICION DE RECURSOS ASIGNADOS POR MES

function Update_FUNDAPROAL_Assigned ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del fundaproal_por_mes seleccionado
    $sql_fundaproal_por_mes = "SELECT * FROM fundaproal_por_mes WHERE id_fundaproal_por_mes = ?";
    $result_fundaproal_por_mes = $conn->prepare($sql_fundaproal_por_mes);
    $result_fundaproal_por_mes->bindParam(1, $id);
    $result_fundaproal_por_mes->execute();
    $fundaproal_por_mes = $result_fundaproal_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$fundaproal_por_mes) {
        header('Location: /admin/fundaproal');
        exit();
    }

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($fundaproal_por_mes['fecha_inicio_fundaproal_por_mes']));

    // Obtener todas las datas fundaproal por municipio relacionado al municipio
    $sql_fundaproal_por_municipio = "SELECT * FROM fundaproal_por_municipio INNER JOIN municipios ON fundaproal_por_municipio.municipio_id = municipios.id_municipio WHERE fundaproal_por_municipio.mes_id = ? ORDER BY fundaproal_por_municipio.id_fundaproal_por_municipio ASC";
    $result_fundaproal_por_municipio = $conn->prepare($sql_fundaproal_por_municipio);
    $result_fundaproal_por_municipio->bindParam(1, $id);
    $result_fundaproal_por_municipio->execute();
    $fundaproal_por_municipio = $result_fundaproal_por_municipio->fetchAll(PDO::FETCH_ASSOC);


    $title = 'MINPPAL - FUNDAPROAL - Actualizar';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/fundaproal/fundaproal_edit_assigned.php';
    include_once 'src/blocks/footer.php';
}

function PUT_FUNDAPROAL_Assigned () {
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

        $sql_month = "SELECT * FROM fundaproal_por_mes WHERE id_fundaproal_por_mes = ?";
        $result_month = $conn->prepare($sql_month);
        $result_month->bindParam(1, $_POST['month_id']);
        $result_month->execute();
        $month = $result_month->fetch(PDO::FETCH_ASSOC);

        if (!$month) {
            throw new Exception('El mes seleccionado no existe');
        }

        // Si el mes ya paso, no se puede actualizar
        if (date('Y-m-d') > $month['fecha_fin_fundaproal_por_mes']) {
            throw new Exception('El mes seleccionado ya paso, no se puede actualizar');
        }

        // Recorrer el array
        foreach ($_POST as $key => $value) {

            // Obtener el id del municipio
            $municipio_id = explode('_', $key)[1];
            $key_value = explode('_', $key)[0];

            // Si la key_value no es clap, proteina, fruta, casas, misioneros, madres, padres, papa, paca, cemr
            // Si el value no es numerico, se salta al siguiente
            // Si el municipio_id no es numerico, se salta al siguiente
            // Si el value es menor a 0, se salta al siguiente

            if ($key_value != 'clap' && $key_value != 'proteina' && $key_value != 'fruta' && $key_value != 'casas' && $key_value != 'misioneros' && $key_value != 'madres' && $key_value != 'padres' && $key_value != 'papa' && $key_value != 'paca' && $key_value != 'cemr') {
                continue;
            }

            if (!is_numeric($value) || !is_numeric($municipio_id) || $value < 0) {
                continue;
            }

            // $column = $key_value == 'clap' ? 'clap_asignados' : ($key_value == 'proteina' ? 'proteina_asignada' : ($key_value == 'fruta' ? 'fruta_asignada' : ($key_value == 'casas' ? 'cantidad_casas_alimentacion' : ($key_value == 'misioneros' ? 'cantidad_misioneros' : ($key_value == 'madres' ? 'cantidad_madres_elab' : ($key_value == 'padres' ? 'cantidad_padres_elab' : ($key_value == 'papa' ? 'plan_papa_asignado' : ($key_value == 'paca' ? 'plan_paca_asignado' : 'cemr'))))))
            $column = $key_value == 'clap' ? 'clap_asignados' : ($key_value == 'proteina' ? 'proteina_asignada' : ($key_value == 'fruta' ? 'fruta_asignada' : ($key_value == 'casas' ? 'cantidad_casas_alimentacion' : ($key_value == 'misioneros' ? 'cantidad_misioneros' : ($key_value == 'madres' ? 'cantidad_madres_elab' : ($key_value == 'padres' ? 'cantidad_padres_elab' : ($key_value == 'papa' ? 'plan_papa_asignado' : ($key_value == 'paca' ? 'plan_paca_asignado' : 'cemr'))))))));

            // Actualizar el dato
            $sql_update = "UPDATE fundaproal_por_municipio SET $column = ? WHERE id_fundaproal_por_municipio = ?";
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

function Load_Data_FUNDAPROAL ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del fundaproal_por_mes seleccionado
    $sql_fundaproal_por_mes = "SELECT * FROM fundaproal_por_mes WHERE id_fundaproal_por_mes = ?";
    $result_fundaproal_por_mes = $conn->prepare($sql_fundaproal_por_mes);
    $result_fundaproal_por_mes->bindParam(1, $id);
    $result_fundaproal_por_mes->execute();
    $fundaproal_por_mes = $result_fundaproal_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$fundaproal_por_mes) {
        header('Location: /admin/fundaproal');
        exit();
    }

    // Obtener todas las datas FUNDAPROAL por municipio relacionado al municipio
    $sql_fundaproal_por_municipio = "SELECT * FROM fundaproal_por_municipio INNER JOIN municipios ON fundaproal_por_municipio.municipio_id = municipios.id_municipio WHERE fundaproal_por_municipio.mes_id = ? ORDER BY fundaproal_por_municipio.id_fundaproal_por_municipio ASC";
    $result_fundaproal_por_municipio = $conn->prepare($sql_fundaproal_por_municipio);
    $result_fundaproal_por_municipio->bindParam(1, $id);
    $result_fundaproal_por_municipio->execute();
    $fundaproal_por_municipio = $result_fundaproal_por_municipio->fetchAll(PDO::FETCH_ASSOC);

    echo '<script>console.log(' . json_encode($fundaproal_por_municipio) . ')</script>';

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($fundaproal_por_mes['fecha_inicio_fundaproal_por_mes']));
    $month_id = $fundaproal_por_mes['id_fundaproal_por_mes'];

    $title = 'MINPPAL - FUNDAPROAL - Carga de Entregas';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/fundaproal/fundaproal_load.php';
    include_once 'src/blocks/footer.php';
}

function POST_Data_FUNDAPROAL () {
    try {

        // Si no es admin, no puede actualizar
        if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
            throw new Exception('No tiene permisos para realizar esta acción');
        }

        // Verifica que se haya enviado el municipio, que sea numerico y que exista en la base de datos
        if (!isset($_POST['municipio']) || !is_numeric($_POST['municipio'])) {
            throw new Exception('Debe seleccionar un municipio');
        }

        require 'src/database/connection.php';

        $sql_municipio = "SELECT * FROM fundaproal_por_municipio 
                            LEFT JOIN fundaproal_por_mes ON fundaproal_por_municipio.mes_id = fundaproal_por_mes.id_fundaproal_por_mes
                            LEFT JOIN municipios ON fundaproal_por_municipio.municipio_id = municipios.id_municipio
                            WHERE fundaproal_por_municipio.id_fundaproal_por_municipio = ?"; 
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
        $month_selected = strftime("%B %Y", strtotime($municipio['fecha_inicio_fundaproal_por_mes']));
        // if ($_POST['fecha_entrega'] < $municipio['fecha_inicio_fundaproal_por_mes']) {
        //     throw new Exception('La fecha seleccionada no puede ser menor a la fecha de inicio del mes ' . $month_selected);
        // }

        $clap = (isset($_POST['clap']) && is_numeric($_POST['clap']) && $_POST['clap'] >= 0) ? $_POST['clap'] : 0;
        $proteina = (isset($_POST['proteina']) && is_numeric($_POST['proteina']) && $_POST['proteina'] >= 0) ? $_POST['proteina'] : 0;
        $fruta = (isset($_POST['fruta']) && is_numeric($_POST['fruta']) && $_POST['fruta'] >= 0) ? $_POST['fruta'] : 0;
        $papa = (isset($_POST['papa']) && is_numeric($_POST['papa']) && $_POST['papa'] >= 0) ? $_POST['papa'] : 0;
        $paca = (isset($_POST['paca']) && is_numeric($_POST['paca']) && $_POST['paca'] >= 0) ? $_POST['paca'] : 0;

        // Proteina y fruta estan en kilogramos, se deben convertir a toneladas
        $proteina = $proteina / 1000;
        $fruta = $fruta / 1000;

        // Si todos los datos son 0, no se puede guardar
        if ($clap == 0 && $proteina == 0 && $fruta == 0 && $papa == 0 && $paca == 0) {
            throw new Exception('Debe ingresar al menos un dato');
        }

        // Verificar que la cantidad de clap, proteina, personas que se estan enviando no sea mayor a la cantidad asignada
        // Para eso toma en cuenta la data actual del municipio y suma la data que se esta enviando
        // Si la data que se esta enviando es mayor a la data asignada, no se puede guardar

        $sql_cantidades_entregadas = "SELECT SUM(clap_despachados) AS clap_despachados, 
                                        SUM(proteina_despachada) AS proteina_despachada, 
                                        SUM(fruta_despachada) AS fruta_despachada,
                                        SUM(plan_papa_despachado) AS plan_papa_despachado,
                                        SUM(plan_paca_despachado) AS plan_paca_despachado
                                        FROM fundaproal_carga WHERE fundaproal_por_municipio_id = ?";
        $result_cantidades_entregadas = $conn->prepare($sql_cantidades_entregadas);
        $result_cantidades_entregadas->bindParam(1, $_POST['municipio']);
        $result_cantidades_entregadas->execute();
        $cantidades_entregadas = $result_cantidades_entregadas->fetch(PDO::FETCH_ASSOC);

        // Si clap, proteina, fruta, papa, paca que se estan enviando es mayor a la cantidad asignada, no se puede guardar
        if (($clap + $cantidades_entregadas['clap_despachados']) > $municipio['clap_asignados']) {
            throw new Exception('La cantidad de entregas clap que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($proteina + $cantidades_entregadas['proteina_despachada']) > $municipio['proteina_asignada']) {
            throw new Exception('La cantidad de proteina que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($fruta + $cantidades_entregadas['fruta_despachada']) > $municipio['fruta_asignada']) {
            throw new Exception('La cantidad de fruta que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($papa + $cantidades_entregadas['plan_papa_despachado']) > $municipio['plan_papa_asignado']) {
            throw new Exception('La cantidad de papa que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($paca + $cantidades_entregadas['plan_paca_despachado']) > $municipio['plan_paca_asignado']) {
            throw new Exception('La cantidad de paca que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }

        // Guardar la data
        // id 	fundaproal_por_municipio_id	proteina_despachada 	clap_despachados 	fruta_despachada, plan_papa_despachado, plan_paca_despachado 	fecha_entrega 	user_id 	
        $sql_insert = "INSERT INTO fundaproal_carga (fundaproal_por_municipio_id, proteina_despachada, clap_despachados, fruta_despachada, plan_papa_despachado, plan_paca_despachado, fecha_despacho, user_id)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $result_insert = $conn->prepare($sql_insert);
        $result_insert->bindParam(1, $_POST['municipio']);
        $result_insert->bindParam(2, $proteina);
        $result_insert->bindParam(3, $clap);
        $result_insert->bindParam(4, $fruta);
        $result_insert->bindParam(5, $papa);
        $result_insert->bindParam(6, $paca);
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


function Export_PDF_FUNDAPROAL_Por_Mes ($id) {
    try {
        
        require_once 'src/database/connection.php';

        // $sql = "SELECT * FROM fundaproal_por_mes WHERE id_fundaproal_por_mes = ?";
        $sql_fundaproal_por_mes = "SELECT fundaproal_por_mes.id_fundaproal_por_mes, fundaproal_por_mes.fecha_inicio_fundaproal_por_mes, fundaproal_por_mes.fecha_fin_fundaproal_por_mes, 
                                SUM(fundaproal_por_municipio.proteina_asignada) AS proteina_asignada, 
                                SUM(fundaproal_por_municipio.clap_asignados) AS clap_asignados, 
                                SUM(fundaproal_por_municipio.fruta_asignada) AS fruta_asignada,
                                SUM(fundaproal_por_municipio.plan_papa_asignado) AS plan_papa_asignado,
                                SUM(fundaproal_por_municipio.plan_paca_asignado) AS plan_paca_asignado,
                                SUM(fundaproal_por_municipio.cantidad_casas_alimentacion) AS cantidad_casas_alimentacion,
                                SUM(fundaproal_por_municipio.cantidad_misioneros) AS cantidad_misioneros,
                                SUM(fundaproal_por_municipio.cantidad_madres_elab) AS cantidad_madres_elab,
                                SUM(fundaproal_por_municipio.cantidad_padres_elab) AS cantidad_padres_elab,
                                SUM(fundaproal_por_municipio.cemr) AS cemr
                                FROM fundaproal_por_mes INNER JOIN fundaproal_por_municipio ON fundaproal_por_mes.id_fundaproal_por_mes = fundaproal_por_municipio.mes_id
                                WHERE fundaproal_por_mes.id_fundaproal_por_mes = ?
                                GROUP BY fundaproal_por_mes.id_fundaproal_por_mes ORDER BY fundaproal_por_mes.id_fundaproal_por_mes DESC";
        $result = $conn->prepare($sql_fundaproal_por_mes);
        $result->bindParam(1, $id);
        $result->execute();
        $fundaproal_por_mes = $result->fetch(PDO::FETCH_ASSOC);
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        // Quiero: Mayo 2020
        $month_selected = strftime("%B %Y", strtotime($fundaproal_por_mes['fecha_inicio_fundaproal_por_mes']));

        if (!$fundaproal_por_mes) {
            header('Location: /admin/fundaproal');
            exit();
        }

        // Obtener las sumatorias de las cargas
        $sql_fundaproal_carga = "SELECT SUM(fundaproal_carga.proteina_despachada) AS proteina_despachada, 
                                    SUM(fundaproal_carga.clap_despachados) AS clap_despachados, 
                                    SUM(fundaproal_carga.fruta_despachada) AS fruta_despachada,
                                    SUM(fundaproal_carga.plan_papa_despachado) AS plan_papa_despachado,
                                    SUM(fundaproal_carga.plan_paca_despachado) AS plan_paca_despachado
                                    FROM fundaproal_carga INNER JOIN fundaproal_por_municipio ON fundaproal_carga.fundaproal_por_municipio_id = fundaproal_por_municipio.id_fundaproal_por_municipio 
                                    WHERE fundaproal_por_municipio.mes_id = ?";
        $result_fundaproal_carga = $conn->prepare($sql_fundaproal_carga);
        $result_fundaproal_carga->bindParam(1, $fundaproal_por_mes['id_fundaproal_por_mes']);
        $result_fundaproal_carga->execute();
        $fundaproal_carga = $result_fundaproal_carga->fetch(PDO::FETCH_ASSOC);

        // Obtener los porcentajes de las cargas, pendiente con la division por 0
        $porcentaje_proteina_despachada = $fundaproal_por_mes['proteina_asignada'] == 0 ? 0 : ($fundaproal_carga['proteina_despachada'] * 100) / $fundaproal_por_mes['proteina_asignada'];
        $porcentaje_clap_despachados = $fundaproal_por_mes['clap_asignados'] == 0 ? 0 : ($fundaproal_carga['clap_despachados'] * 100) / $fundaproal_por_mes['clap_asignados'];
        $porcentaje_fruta_despachada = $fundaproal_por_mes['fruta_asignada'] == 0 ? 0 : ($fundaproal_carga['fruta_despachada'] * 100) / $fundaproal_por_mes['fruta_asignada'];
        $porcentaje_plan_papa_despachado = $fundaproal_por_mes['plan_papa_asignado'] == 0 ? 0 : ($fundaproal_carga['plan_papa_despachado'] * 100) / $fundaproal_por_mes['plan_papa_asignado'];
        $porcentaje_plan_paca_despachado = $fundaproal_por_mes['plan_paca_asignado'] == 0 ? 0 : ($fundaproal_carga['plan_paca_despachado'] * 100) / $fundaproal_por_mes['plan_paca_asignado'];

        // Obtener las cantidades asignadas y entregadas por municipio

        $sql_fundaproal_por_municipio = "SELECT * FROM fundaproal_por_municipio INNER JOIN municipios ON fundaproal_por_municipio.municipio_id = municipios.id_municipio 
                                    WHERE fundaproal_por_municipio.mes_id = ? ORDER BY fundaproal_por_municipio.id_fundaproal_por_municipio ASC";
        $result_fundaproal_por_municipio = $conn->prepare($sql_fundaproal_por_municipio);
        $result_fundaproal_por_municipio->bindParam(1, $id);
        $result_fundaproal_por_municipio->execute();
        $fundaproal_por_municipio = $result_fundaproal_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($fundaproal_por_municipio as $fundaproal) {
            
            // Obtener las sumatorias de las cargas
            $sql_fundaproal_carga = "SELECT SUM(fundaproal_carga.proteina_despachada) AS proteina_despachada,
                                        SUM(fundaproal_carga.clap_despachados) AS clap_despachados,
                                        SUM(fundaproal_carga.fruta_despachada) AS fruta_despachada,
                                        SUM(fundaproal_carga.plan_papa_despachado) AS plan_papa_despachado,
                                        SUM(fundaproal_carga.plan_paca_despachado) AS plan_paca_despachado
                                        FROM fundaproal_carga WHERE fundaproal_por_municipio_id = ?";
            $result_fundaproal_carga_mun = $conn->prepare($sql_fundaproal_carga);
            $result_fundaproal_carga_mun->bindParam(1, $fundaproal['id_fundaproal_por_municipio']);
            $result_fundaproal_carga_mun->execute();
            $fundaproal_carga_mun = $result_fundaproal_carga_mun->fetch(PDO::FETCH_ASSOC);

            // $fundaproal['proteina_asignada_fundaproal_por_municipio'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada_mun = $fundaproal['proteina_asignada'] != 0 ? ($fundaproal_carga_mun['proteina_despachada'] * 100) / $fundaproal['proteina_asignada'] : 0;
            $porcentaje_clap_despachados_mun = $fundaproal['clap_asignados'] != 0 ? ($fundaproal_carga_mun['clap_despachados'] * 100) / $fundaproal['clap_asignados'] : 0;
            $porcentaje_fruta_despachada_mun = $fundaproal['fruta_asignada'] != 0 ? ($fundaproal_carga_mun['fruta_despachada'] * 100) / $fundaproal['fruta_asignada'] : 0;
            $porcentaje_plan_papa_despachado_mun = $fundaproal['plan_papa_asignado'] != 0 ? ($fundaproal_carga_mun['plan_papa_despachado'] * 100) / $fundaproal['plan_papa_asignado'] : 0;
            $porcentaje_plan_paca_despachado_mun = $fundaproal['plan_paca_asignado'] != 0 ? ($fundaproal_carga_mun['plan_paca_despachado'] * 100) / $fundaproal['plan_paca_asignado'] : 0;
            $diff_proteina = $fundaproal['proteina_asignada'] - $fundaproal_carga_mun['proteina_despachada'];
            $diff_clap = $fundaproal['clap_asignados'] - $fundaproal_carga_mun['clap_despachados'];
            $diff_fruta = $fundaproal['fruta_asignada'] - $fundaproal_carga_mun['fruta_despachada'];
            $diff_plan_papa = $fundaproal['plan_papa_asignado'] - $fundaproal_carga_mun['plan_papa_despachado'];
            $diff_plan_paca = $fundaproal['plan_paca_asignado'] - $fundaproal_carga_mun['plan_paca_despachado'];

            $data_return[] = array(
                'id_fundaproal_por_municipio' => $fundaproal['id_fundaproal_por_municipio'],
                'municipio_id' => $fundaproal['municipio_id'],
                'name_municipio' => $fundaproal['name_municipio'],
                'cantidad_casas_alimentacion' => number_format($fundaproal['cantidad_casas_alimentacion'], 0, ',', '.'),
                'cantidad_misioneros' => number_format($fundaproal['cantidad_misioneros'], 0, ',', '.'),
                'cantidad_madres_elab' => number_format($fundaproal['cantidad_madres_elab'], 0, ',', '.'),
                'cantidad_padres_elab' => number_format($fundaproal['cantidad_padres_elab'], 0, ',', '.'),
                'cemr' => number_format($fundaproal['cemr'], 0, ',', '.'),
                'proteina_asignada' => number_format($fundaproal['proteina_asignada'], 2, ',', '.'),
                'clap_asignados' => number_format($fundaproal['clap_asignados'], 0, ',', '.'),
                'fruta_asignada' => number_format($fundaproal['fruta_asignada'], 2, ',', '.'),
                'plan_papa_asignado' => number_format($fundaproal['plan_papa_asignado'], 0, ',', '.'),
                'plan_paca_asignado' => number_format($fundaproal['plan_paca_asignado'], 0, ',', '.'),
                'proteina_despachada' => number_format($fundaproal_carga_mun['proteina_despachada'], 2, ',', '.'),
                'clap_despachados' => number_format($fundaproal_carga_mun['clap_despachados'], 0, ',', '.'),
                'fruta_despachada' => number_format($fundaproal_carga_mun['fruta_despachada'], 2, ',', '.'),
                'plan_papa_despachado' => number_format($fundaproal_carga_mun['plan_papa_despachado'], 0, ',', '.'),
                'plan_paca_despachado' => number_format($fundaproal_carga_mun['plan_paca_despachado'], 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada_mun, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados_mun, 2, ',', '.'),
                'porcentaje_fruta_despachada' => number_format($porcentaje_fruta_despachada_mun, 2, ',', '.'),
                'porcentaje_plan_papa_despachado' => number_format($porcentaje_plan_papa_despachado_mun, 2, ',', '.'),
                'porcentaje_plan_paca_despachado' => number_format($porcentaje_plan_paca_despachado_mun, 2, ',', '.'),
                'diff_proteina' => $diff_proteina,
                'diff_clap' => $diff_clap,
                'diff_fruta' => $diff_fruta,
                'diff_plan_papa' => $diff_plan_papa,
                'diff_plan_paca' => $diff_plan_paca,
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
        $pdf->SetTitle('Reporte FUNDAPROAL - ' . $month_selected);
        $pdf->SetSubject('Reporte FUNDAPROAL - ' . $month_selected);
        $pdf->SetKeywords('MINPPAL, PDF, FUNDAPROAL, Reporte, ' . $month_selected);

        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte FUNDAPROAL - ' . $month_selected, 0, 1, 'C');
        $pdf->Ln(2);

        $html = '
        <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Cantidad de casas de alimentación</th>
                    <th class="description">CEMR</th>
                    <th class="description">Cantidad de misioneros</th>
                    <th class="description">Cantidad de madres elaboradoras</th>
                    <th class="description">Cantidad de padres elaboradores</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Proteina Asignada</th>
                    <th class="description">Clap Asignados</th>
                    <th class="description">Fruta Asignada</th>
                    <th class="description">Plan Papa Asignado</th>
                    <th class="description">Plan Paca Asignado</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Proteina Despachada</th>
                    <th class="description">Clap Despachados</th>
                    <th class="description">Fruta Despachada</th>
                    <th class="description">Plan Papa Despachado</th>
                    <th class="description">Plan Paca Despachado</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Porcentaje de Proteina Despachada</th>
                    <th class="description">Porcentaje de Clap Despachados</th>
                    <th class="description">Porcentaje de Fruta Despachada</th>
                    <th class="description">Porcentaje de Plan Papa Despachado</th>
                    <th class="description">Porcentaje de Plan Paca Despachado</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($fundaproal_por_mes['cantidad_casas_alimentacion'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['cemr'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['cantidad_misioneros'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['cantidad_madres_elab'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['cantidad_padres_elab'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($fundaproal_por_mes['proteina_asignada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($fundaproal_por_mes['clap_asignados'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['fruta_asignada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($fundaproal_por_mes['plan_papa_asignado'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_por_mes['plan_paca_asignado'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($fundaproal_carga['proteina_despachada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($fundaproal_carga['clap_despachados'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_carga['fruta_despachada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($fundaproal_carga['plan_papa_despachado'], 0, ',', '.') . '</td>
                    <td>' . number_format($fundaproal_carga['plan_paca_despachado'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($porcentaje_proteina_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_clap_despachados, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_fruta_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_plan_papa_despachado, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_plan_paca_despachado, 2, ',', '.') . '%</td>
                </tr>
            </tbody>
        </table>
        ';

        $html_diff_fundaproal_carga = '';
        
        if ($fundaproal_por_mes['proteina_asignada'] > $fundaproal_carga['proteina_despachada']) {
            $html_diff_fundaproal_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($fundaproal_por_mes['proteina_asignada'] - $fundaproal_carga['proteina_despachada'], 2, ',', '.') . ' TON de proteina sin despachar
            </h6>
            ';
        }
        if ($fundaproal_por_mes['clap_asignados'] > $fundaproal_carga['clap_despachados']) {
            $html_diff_fundaproal_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($fundaproal_por_mes['clap_asignados'] - $fundaproal_carga['clap_despachados'], 0, ',', '.') . ' CLAP sin despachar
            </h6>
            ';
        }
        if ($fundaproal_por_mes['fruta_asignada'] > $fundaproal_carga['fruta_despachada']) {
            $html_diff_fundaproal_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($fundaproal_por_mes['fruta_asignada'] - $fundaproal_carga['fruta_despachada'], 2, ',', '.') . ' TON de fruta sin despachar
            </h6>
            ';
        }
        if ($fundaproal_por_mes['plan_papa_asignado'] > $fundaproal_carga['plan_papa_despachado']) {
            $html_diff_fundaproal_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($fundaproal_por_mes['plan_papa_asignado'] - $fundaproal_carga['plan_papa_despachado'], 0, ',', '.') . ' Plan Papa sin despachar
            </h6>
            ';
        }
        if ($fundaproal_por_mes['plan_paca_asignado'] > $fundaproal_carga['plan_paca_despachado']) {
            $html_diff_fundaproal_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($fundaproal_por_mes['plan_paca_asignado'] - $fundaproal_carga['plan_paca_despachado'], 0, ',', '.') . ' Plan Paca sin despachar
            </h6>
            ';
        }

        $html .= $html_diff_fundaproal_carga;

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
                        <th class="description">Cantidad de casas de alimentación</th>
                        <th class="description">CEMR</th>
                        <th class="description">Cantidad de misioneros</th>
                        <th class="description">Cantidad de madres elaboradoras</th>
                        <th class="description">Cantidad de padres elaboradores</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Proteina Asignada</th>
                        <th class="description">Clap Asignados</th>
                        <th class="description">Fruta Asignada</th>
                        <th class="description">Plan Papa Asignado</th>
                        <th class="description">Plan Paca Asignado</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Proteina Despachada</th>
                        <th class="description">Clap Despachados</th>
                        <th class="description">Fruta Despachada</th>
                        <th class="description">Plan Papa Despachado</th>
                        <th class="description">Plan Paca Despachado</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Porcentaje de Proteina Despachada</th>
                        <th class="description">Porcentaje de Clap Despachados</th>
                        <th class="description">Porcentaje de Fruta Despachada</th>
                        <th class="description">Porcentaje de Plan Papa Despachado</th>
                        <th class="description">Porcentaje de Plan Paca Despachado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['cantidad_casas_alimentacion'] . '</td>
                        <td>' . $municipio['cemr'] . '</td>
                        <td>' . $municipio['cantidad_misioneros'] . '</td>
                        <td>' . $municipio['cantidad_madres_elab'] . '</td>
                        <td>' . $municipio['cantidad_padres_elab'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['proteina_asignada'] . ' TON</td>
                        <td>' . $municipio['clap_asignados'] . '</td>
                        <td>' . $municipio['fruta_asignada'] . ' TON</td>
                        <td>' . $municipio['plan_papa_asignado'] . '</td>
                        <td>' . $municipio['plan_paca_asignado'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['proteina_despachada'] . ' TON</td>
                        <td>' . $municipio['clap_despachados'] . '</td>
                        <td>' . $municipio['fruta_despachada'] . ' TON</td>
                        <td>' . $municipio['plan_papa_despachado'] . '</td>
                        <td>' . $municipio['plan_paca_despachado'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['porcentaje_proteina_despachada'] . '%</td>
                        <td>' . $municipio['porcentaje_clap_despachados'] . '%</td>
                        <td>' . $municipio['porcentaje_fruta_despachada'] . '%</td>
                        <td>' . $municipio['porcentaje_plan_papa_despachado'] . '%</td>
                        <td>' . $municipio['porcentaje_plan_paca_despachado'] . '%</td>
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
            if ($municipio['diff_plan_papa'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_plan_papa'], 0, ',', '.') . ' Planes Papa sin despachar
                </h6>
                ';
            }
            if ($municipio['diff_plan_paca'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_plan_paca'], 0, ',', '.') . ' Planes Paca sin despachar
                </h6>
                ';
            }
        }

        $pdf->writeHTML($html_tablas_por_municipio, true, false, true, false, '');

        $pdf->Output('Reporte FUNDAPROAL - ' . $month_selected . '.pdf', 'I');

    } catch (\Throwable $th) {
        
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}