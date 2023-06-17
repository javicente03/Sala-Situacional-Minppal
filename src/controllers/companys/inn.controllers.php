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
        $sql = "SELECT SUM(inn_carga.proteina_despachada) AS proteina_despachada, 
                                    SUM(inn_carga.clap_despachados) AS clap_despachados,
                                    SUM(inn_carga.personas_atendidas) AS personas_atendidas 
                                    FROM inn_carga INNER JOIN inn_por_municipio ON inn_carga.inn_por_municipio_id = inn_por_municipio.id_inn_por_municipio 
                                    WHERE inn_por_municipio.mes_id = ?";
        $result = $conn->prepare($sql);
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

function Get_INN_Por_Mes ($id) {
    try {
        require 'src/database/connection.php';

        // Obtener todas las datas INN por mes, igual su relacion con inn_por_municipio
        $sql_inn_por_mes = "SELECT inn_por_mes.id_inn_por_mes, inn_por_mes.fecha_inicio_inn_por_mes, inn_por_mes.fecha_fin_inn_por_mes, SUM(inn_por_municipio.proteina_asignada) AS proteina_asignada, SUM(inn_por_municipio.clap_asignados) AS clap_asignados, SUM(inn_por_municipio.personas_por_atender) AS personas_por_atender FROM inn_por_mes INNER JOIN inn_por_municipio ON inn_por_mes.id_inn_por_mes = inn_por_municipio.mes_id WHERE inn_por_mes.id_inn_por_mes = ? GROUP BY inn_por_mes.id_inn_por_mes ORDER BY inn_por_mes.id_inn_por_mes DESC";
        $result_inn_por_mes = $conn->prepare($sql_inn_por_mes);
        $result_inn_por_mes->bindParam(1, $id);
        $result_inn_por_mes->execute();
        $inn_por_mes = $result_inn_por_mes->fetch(PDO::FETCH_ASSOC);

        // // Si no existe el mes, redireccionar
        if (!$inn_por_mes) {
            header('Location: /admin/inn');
            exit();
        }

        // // Paginacion
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $offset = ($page - 1) * $limit;

        // // Obtener todas las datas INN por municipio relacionado al municipio
        $sql_inn_por_municipio = "SELECT * FROM inn_por_municipio INNER JOIN municipios ON inn_por_municipio.municipio_id = municipios.id_municipio WHERE inn_por_municipio.mes_id = ? ORDER BY inn_por_municipio.id_inn_por_municipio ASC LIMIT $limit OFFSET $offset";
        $result_inn_por_municipio = $conn->prepare($sql_inn_por_municipio);
        $result_inn_por_municipio->bindParam(1, $id);
        $result_inn_por_municipio->execute();
        $inn_por_municipio = $result_inn_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($inn_por_municipio as $inn) {
            
            // Obtener las sumatorias de las cargas
            $sql = "SELECT SUM(inn_carga.proteina_despachada) AS proteina_despachada,
                                        SUM(inn_carga.clap_despachados) AS clap_despachados,
                                        SUM(inn_carga.personas_atendidas) AS personas_atendidas
                                        FROM inn_carga WHERE inn_por_municipio_id = ?";
            $result = $conn->prepare($sql);
            $result->bindParam(1, $inn['id_inn_por_municipio']);
            $result->execute();
            $inn_carga = $result->fetch(PDO::FETCH_ASSOC);

            // $inn['proteina_asignada'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada = $inn['proteina_asignada'] != 0 ? ($inn_carga['proteina_despachada'] * 100) / $inn['proteina_asignada'] : 0;
            $porcentaje_clap_despachados = $inn['clap_asignados'] != 0 ? ($inn_carga['clap_despachados'] * 100) / $inn['clap_asignados'] : 0;
            $porcentaje_personas_atendidas = $inn['personas_por_atender'] != 0 ? ($inn_carga['personas_atendidas'] * 100) / $inn['personas_por_atender'] : 0;

            $data_return[] = array(
                'id_inn_por_municipio' => $inn['id_inn_por_municipio'],
                'municipio_id' => $inn['municipio_id'],
                'name_municipio' => $inn['name_municipio'],
                'proteina_asignada' => number_format($inn['proteina_asignada'], 2, ',', '.'),
                'clap_asignados' => number_format($inn['clap_asignados'], 0, ',', '.'),
                'personas_por_atender' => number_format($inn['personas_por_atender'], 0, ',', '.'),
                'proteina_despachada' => number_format($inn_carga['proteina_despachada'], 2, ',', '.'),
                'clap_despachados' => number_format($inn_carga['clap_despachados'], 0, ',', '.'),
                'personas_atendidas' => number_format($inn_carga['personas_atendidas'], 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados, 2, ',', '.'),
                'porcentaje_personas_atendidas' => number_format($porcentaje_personas_atendidas, 2, ',', '.')
            );
        }

        echo '<script>console.log(' . json_encode($data_return) . ')</script>';

        // Obtener el total
        $sql_total = "SELECT COUNT(*) AS total FROM inn_por_municipio WHERE mes_id = ?";
        $result_total = $conn->prepare($sql_total);
        $result_total->bindParam(1, $id);
        $result_total->execute();
        $total = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_year = strftime("%B %Y", strtotime($inn_por_mes['fecha_inicio_inn_por_mes']));

        $title = 'MINPPAL - INN - ' . $month_year;
        include_once 'src/blocks/header.php';
        include_once 'src/blocks/menu/admin/menu.php';
        include_once 'src/blocks/menu/admin/menu_responsive.php';
        include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
        include_once 'src/views/admin/companies/inn/inn_municipios.php';
        include_once 'src/blocks/footer.php';
    } catch (\Throwable $th) {
        //throw $th;
    }

}

// EDICION DE RECURSOS ASIGNADOS POR MES

function Update_INN_Assigned ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del inn_por_mes seleccionado
    $sql_inn_por_mes = "SELECT * FROM inn_por_mes WHERE id_inn_por_mes = ?";
    $result_inn_por_mes = $conn->prepare($sql_inn_por_mes);
    $result_inn_por_mes->bindParam(1, $id);
    $result_inn_por_mes->execute();
    $inn_por_mes = $result_inn_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$inn_por_mes) {
        header('Location: /admin/inn');
        exit();
    }

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($inn_por_mes['fecha_inicio_inn_por_mes']));

    // Obtener todas las datas inn por municipio relacionado al municipio
    $sql_inn_por_municipio = "SELECT * FROM inn_por_municipio INNER JOIN municipios ON inn_por_municipio.municipio_id = municipios.id_municipio WHERE inn_por_municipio.mes_id = ? ORDER BY inn_por_municipio.id_inn_por_municipio ASC";
    $result_inn_por_municipio = $conn->prepare($sql_inn_por_municipio);
    $result_inn_por_municipio->bindParam(1, $id);
    $result_inn_por_municipio->execute();
    $inn_por_municipio = $result_inn_por_municipio->fetchAll(PDO::FETCH_ASSOC);


    $title = 'MINPPAL - INN - Actualizar';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/inn/inn_edit_assigned.php';
    include_once 'src/blocks/footer.php';
}

// EDICION DE RECURSOS ASIGNADOS POR MES

function PUT_INN_Assigned () {
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

        $sql_month = "SELECT * FROM inn_por_mes WHERE id_inn_por_mes = ?";
        $result_month = $conn->prepare($sql_month);
        $result_month->bindParam(1, $_POST['month_id']);
        $result_month->execute();
        $month = $result_month->fetch(PDO::FETCH_ASSOC);

        if (!$month) {
            throw new Exception('El mes seleccionado no existe');
        }

        // Si el mes ya paso, no se puede actualizar
        if (date('Y-m-d') > $month['fecha_fin_inn_por_mes']) {
            throw new Exception('El mes seleccionado ya paso, no se puede actualizar');
        }

        // Recorrer el array
        foreach ($_POST as $key => $value) {

            // Obtener el id del municipio
            $municipio_id = explode('_', $key)[1];
            $key_value = explode('_', $key)[0];

            // Si la key_value no es clap, proteina, personas, se salta al siguiente
            // Si el value no es numerico, se salta al siguiente
            // Si el municipio_id no es numerico, se salta al siguiente
            // Si el value es menor a 0, se salta al siguiente

            if ($key_value != 'clap' && $key_value != 'proteina' && $key_value != 'personas') {
                continue;
            }

            if (!is_numeric($value) || !is_numeric($municipio_id) || $value < 0) {
                continue;
            }

            // si el key_value es clap, la columna a actualizar es clap_asignados
            // si el key_value es proteina, la columna a actualizar es proteina_asignada}
            // si el key_value es personas, la columna a actualizar es personas_por_atender

            // $column = $key_value == 'clap' ? 'clap_asignados_inn_por_municipio' : ($key_value == 'proteina' ? 'proteina_asignada_inn_por_municipio' : ($key_value == 'fruver' ? 'fruta_asignada_inn_por_municipio' : ($key_value == 'inst' ? 'instituciones_inn_por_municipio' : 'matricula_inn_por_municipio')));
            $column = $key_value == 'clap' ? 'clap_asignados' : ($key_value == 'proteina' ? 'proteina_asignada' : 'personas_por_atender');

            // Actualizar el dato
            $sql_update = "UPDATE inn_por_municipio SET $column = ? WHERE id_inn_por_municipio = ?";
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

function Load_Data_INN ($id) {

    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
        header('Location: /login');
        exit();
    }

    require 'src/database/connection.php';

    // Obtener la data del inn_por_mes seleccionado
    $sql_inn_por_mes = "SELECT * FROM inn_por_mes WHERE id_inn_por_mes = ?";
    $result_inn_por_mes = $conn->prepare($sql_inn_por_mes);
    $result_inn_por_mes->bindParam(1, $id);
    $result_inn_por_mes->execute();
    $inn_por_mes = $result_inn_por_mes->fetch(PDO::FETCH_ASSOC);

    // Si no existe el mes, redireccionar
    if (!$inn_por_mes) {
        header('Location: /admin/inn');
        exit();
    }

    // Obtener todas las datas INN por municipio relacionado al municipio
    $sql_inn_por_municipio = "SELECT * FROM inn_por_municipio INNER JOIN municipios ON inn_por_municipio.municipio_id = municipios.id_municipio WHERE inn_por_municipio.mes_id = ? ORDER BY inn_por_municipio.id_inn_por_municipio ASC";
    $result_inn_por_municipio = $conn->prepare($sql_inn_por_municipio);
    $result_inn_por_municipio->bindParam(1, $id);
    $result_inn_por_municipio->execute();
    $inn_por_municipio = $result_inn_por_municipio->fetchAll(PDO::FETCH_ASSOC);

    echo '<script>console.log(' . json_encode($inn_por_municipio) . ')</script>';

    // Obtener el mes y año: Mayo 2021 en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
    $month_selected = strftime("%B %Y", strtotime($inn_por_mes['fecha_inicio_inn_por_mes']));
    $month_id = $inn_por_mes['id_inn_por_mes'];

    $title = 'MINPPAL - INN - Carga de Entregas';
    include_once 'src/blocks/header.php';
    include_once 'src/blocks/menu/admin/menu.php';
    include_once 'src/blocks/menu/admin/menu_responsive.php';
    include_once 'src/blocks/sidebar/admin/sidebarLeft.php';
    include_once 'src/views/admin/companies/inn/inn_load.php';
    include_once 'src/blocks/footer.php';
}

function POST_Data_INN () {
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

        $sql_municipio = "SELECT * FROM inn_por_municipio 
                            LEFT JOIN inn_por_mes ON inn_por_municipio.mes_id = inn_por_mes.id_inn_por_mes
                            LEFT JOIN municipios ON inn_por_municipio.municipio_id = municipios.id_municipio
                            WHERE inn_por_municipio.id_inn_por_municipio = ?"; 
        $result_municipio = $conn->prepare($sql_municipio);
        $result_municipio->bindParam(1, $_POST['municipio']);
        $result_municipio->execute();
        $municipio = $result_municipio->fetch(PDO::FETCH_ASSOC);

        if (!$municipio) {
            throw new Exception('El municipio seleccionado no existe');
        }

        // Verifica que se haya enviado la fecha, que sea una fecha valida
        // if (!isset($_POST['fecha_entrega']) || !strtotime($_POST['fecha_entrega'])) {
        //     throw new Exception('Debe seleccionar una fecha valida');
        // }

        // Verifica que la fecha seleccionada no sea mayor a la fecha actual
        // if (date('Y-m-d') < $_POST['fecha_entrega']) {
        //     throw new Exception('La fecha seleccionada no puede ser mayor a la fecha actual');
        // }

        // Verifica que la fecha seleccionada no sea menor a la fecha de inicio del mes
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        $month_selected = strftime("%B %Y", strtotime($municipio['fecha_inicio_inn_por_mes']));
        // if ($_POST['fecha_entrega'] < $municipio['fecha_inicio_inn_por_mes']) {
        //     throw new Exception('La fecha seleccionada no puede ser menor a la fecha de inicio del mes ' . $month_selected);
        // }

        // Si clap, proteina, personas no se mandan vacios, deben ser numericos y mayores o iguales a 0, sino se establecen en 0
        $clap = (isset($_POST['clap']) && is_numeric($_POST['clap']) && $_POST['clap'] >= 0) ? $_POST['clap'] : 0;
        $proteina = (isset($_POST['proteina']) && is_numeric($_POST['proteina']) && $_POST['proteina'] >= 0) ? $_POST['proteina'] : 0;
        $personas = (isset($_POST['personas']) && is_numeric($_POST['personas']) && $_POST['personas'] >= 0) ? $_POST['personas'] : 0;

        // Proteina y fruta estan en kilogramos, se deben convertir a toneladas
        $proteina = $proteina / 1000;

        // Si todos los datos son 0, no se puede guardar
        if ($clap == 0 && $proteina == 0 && $personas == 0) {
            throw new Exception('Debe ingresar al menos un dato');
        }

        // Verificar que la cantidad de clap, proteina, personas que se estan enviando no sea mayor a la cantidad asignada
        // Para eso toma en cuenta la data actual del municipio y suma la data que se esta enviando
        // Si la data que se esta enviando es mayor a la data asignada, no se puede guardar

        $sql_cantidades_entregadas = "SELECT SUM(clap_despachados) AS clap_despachados, 
                                        SUM(proteina_despachada) AS proteina_despachada, 
                                        SUM(personas_atendidas) AS personas_atendidas
                                        FROM inn_carga WHERE inn_por_municipio_id = ?";
        $result_cantidades_entregadas = $conn->prepare($sql_cantidades_entregadas);
        $result_cantidades_entregadas->bindParam(1, $_POST['municipio']);
        $result_cantidades_entregadas->execute();
        $cantidades_entregadas = $result_cantidades_entregadas->fetch(PDO::FETCH_ASSOC);

        // Si clap, proteina, personas que se estan enviando es mayor a la cantidad asignada, no se puede guardar
        if (($clap + $cantidades_entregadas['clap_despachados']) > $municipio['clap_asignados']) {
            throw new Exception('La cantidad de entregas clap que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($proteina + $cantidades_entregadas['proteina_despachada']) > $municipio['proteina_asignada']) {
            throw new Exception('La cantidad de proteina que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }
        if (($personas + $cantidades_entregadas['personas_atendidas']) > $municipio['personas_por_atender']) {
            throw new Exception('La cantidad de personas que intenta guardar es mayor a la cantidad asignada para el municipio ' . $municipio['name_municipio']);
        }

        // Guardar la data
        // id 	inn_por_municipio_id	proteina_despachada 	clap_despachados 	personas_atendidas 	fecha_entrega 	fecha_creacion 	
        $sql_insert = "INSERT INTO inn_carga (inn_por_municipio_id, proteina_despachada, clap_despachados, personas_atendidas, user_id)
                        VALUES (?, ?, ?, ?, ?)";

        $result_insert = $conn->prepare($sql_insert);
        $result_insert->bindParam(1, $_POST['municipio']);
        $result_insert->bindParam(2, $proteina);
        $result_insert->bindParam(3, $clap);
        $result_insert->bindParam(4, $personas);
        $result_insert->bindParam(5, $_SESSION['id']);
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

function Export_PDF_INN_Por_Mes ($id) {
    try {
        
        require_once 'src/database/connection.php';

        // $sql = "SELECT * FROM inn_por_mes WHERE id_inn_por_mes = ?";
        $sql_inn_por_mes = "SELECT inn_por_mes.id_inn_por_mes, inn_por_mes.fecha_inicio_inn_por_mes, inn_por_mes.fecha_fin_inn_por_mes, 
                                SUM(inn_por_municipio.proteina_asignada) AS proteina_asignada, 
                                SUM(inn_por_municipio.clap_asignados) AS clap_asignados, 
                                SUM(inn_por_municipio.personas_por_atender) AS personas_por_atender
                                FROM inn_por_mes INNER JOIN inn_por_municipio ON inn_por_mes.id_inn_por_mes = inn_por_municipio.mes_id
                                WHERE inn_por_mes.id_inn_por_mes = ?
                                GROUP BY inn_por_mes.id_inn_por_mes ORDER BY inn_por_mes.id_inn_por_mes DESC";
        $result = $conn->prepare($sql_inn_por_mes);
        $result->bindParam(1, $id);
        $result->execute();
        $inn_por_mes = $result->fetch(PDO::FETCH_ASSOC);
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
        // Quiero: Mayo 2020
        $month_selected = strftime("%B %Y", strtotime($inn_por_mes['fecha_inicio_inn_por_mes']));

        if (!$inn_por_mes) {
            header('Location: /admin/inn');
            exit();
        }

        // Obtener las sumatorias de las cargas
        $sql_inn_carga = "SELECT SUM(inn_carga.proteina_despachada) AS proteina_despachada, 
                                    SUM(inn_carga.clap_despachados) AS clap_despachados, 
                                    SUM(inn_carga.personas_atendidas) AS personas_atendidas
                                    FROM inn_carga INNER JOIN inn_por_municipio ON inn_carga.inn_por_municipio_id = inn_por_municipio.id_inn_por_municipio 
                                    WHERE inn_por_municipio.mes_id = ?";
        $result_inn_carga = $conn->prepare($sql_inn_carga);
        $result_inn_carga->bindParam(1, $inn_por_mes['id_inn_por_mes']);
        $result_inn_carga->execute();
        $inn_carga = $result_inn_carga->fetch(PDO::FETCH_ASSOC);

        // Obtener los porcentajes de las cargas, pendiente con la division por 0
        $porcentaje_proteina_despachada = $inn_por_mes['proteina_asignada'] == 0 ? 0 : ($inn_carga['proteina_despachada'] * 100) / $inn_por_mes['proteina_asignada'];
        $porcentaje_clap_despachados = $inn_por_mes['clap_asignados'] == 0 ? 0 : ($inn_carga['clap_despachados'] * 100) / $inn_por_mes['clap_asignados'];
        $porcentaje_personas_atendidas = $inn_por_mes['personas_por_atender'] == 0 ? 0 : ($inn_carga['personas_atendidas'] * 100) / $inn_por_mes['personas_por_atender'];

        // Obtener las cantidades asignadas y entregadas por municipio

        $sql_inn_por_municipio = "SELECT * FROM inn_por_municipio INNER JOIN municipios ON inn_por_municipio.municipio_id = municipios.id_municipio 
                                    WHERE inn_por_municipio.mes_id = ? ORDER BY inn_por_municipio.id_inn_por_municipio ASC";
        $result_inn_por_municipio = $conn->prepare($sql_inn_por_municipio);
        $result_inn_por_municipio->bindParam(1, $id);
        $result_inn_por_municipio->execute();
        $inn_por_municipio = $result_inn_por_municipio->fetchAll(PDO::FETCH_ASSOC);

        $data_return = array();

        foreach ($inn_por_municipio as $inn) {
            
            // Obtener las sumatorias de las cargas
            $sql_inn_carga = "SELECT SUM(inn_carga.proteina_despachada) AS proteina_despachada,
                                        SUM(inn_carga.clap_despachados) AS clap_despachados,
                                        SUM(inn_carga.personas_atendidas) AS personas_atendidas
                                        FROM inn_carga WHERE inn_por_municipio_id = ?";
            $result_inn_carga_mun = $conn->prepare($sql_inn_carga);
            $result_inn_carga_mun->bindParam(1, $inn['id_inn_por_municipio']);
            $result_inn_carga_mun->execute();
            $inn_carga_mun = $result_inn_carga_mun->fetch(PDO::FETCH_ASSOC);

            // $inn['proteina_asignada_inn_por_municipio'] si es 0, no se puede dividir entre 0
            $porcentaje_proteina_despachada_mun = $inn['proteina_asignada'] != 0 ? ($inn_carga_mun['proteina_despachada'] * 100) / $inn['proteina_asignada'] : 0;
            $porcentaje_clap_despachados_mun = $inn['clap_asignados'] != 0 ? ($inn_carga_mun['clap_despachados'] * 100) / $inn['clap_asignados'] : 0;
            $porcentaje_personas_atendidas_mun = $inn['personas_por_atender'] != 0 ? ($inn_carga_mun['personas_atendidas'] * 100) / $inn['personas_por_atender'] : 0;
            $diff_proteina = $inn['proteina_asignada'] - $inn_carga_mun['proteina_despachada'];
            $diff_clap = $inn['clap_asignados'] - $inn_carga_mun['clap_despachados'];
            $diff_personas = $inn['personas_por_atender'] - $inn_carga_mun['personas_atendidas'];

            $data_return[] = array(
                'id_inn_por_municipio' => $inn['id_inn_por_municipio'],
                'municipio_id' => $inn['municipio_id'],
                'name_municipio' => $inn['name_municipio'],
                'proteina_asignada' => number_format($inn['proteina_asignada'], 2, ',', '.'),
                'clap_asignados' => number_format($inn['clap_asignados'], 0, ',', '.'),
                'personas_por_atender' => number_format($inn['personas_por_atender'], 0, ',', '.'),
                'proteina_despachada' => number_format($inn_carga_mun['proteina_despachada'], 2, ',', '.'),
                'clap_despachados' => number_format($inn_carga_mun['clap_despachados'], 0, ',', '.'),
                'personas_atendidas' => number_format($inn_carga_mun['personas_atendidas'], 0, ',', '.'),
                'porcentaje_proteina_despachada' => number_format($porcentaje_proteina_despachada_mun, 2, ',', '.'),
                'porcentaje_clap_despachados' => number_format($porcentaje_clap_despachados_mun, 2, ',', '.'),
                'porcentaje_personas_atendidas' => number_format($porcentaje_personas_atendidas_mun, 2, ',', '.'),
                'diff_proteina' => $diff_proteina,
                'diff_clap' => $diff_clap,
                'diff_personas' => $diff_personas
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
        $pdf->SetTitle('Reporte INN - ' . $month_selected);
        $pdf->SetSubject('Reporte INN - ' . $month_selected);
        $pdf->SetKeywords('MINPPAL, PDF, INN, Reporte, ' . $month_selected);

        // Establecer la configuración de la página
        $pdf->setHeaderFont(Array('helvetica', '', 6));
        $pdf->SetHeaderMargin(10);
        $pdf->setPrintFooter(true);

        // Agregar una página
        $pdf->AddPage();

        // Seteamos el tipo de letra y creamos el título de la página. No es un encabezado de la página
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Reporte INN - ' . $month_selected, 0, 1, 'C');
        $pdf->Ln(2);

        $html = '
        <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Personas por Atender</th>
                    <th class="description">Proteina Asignada</th>
                    <th class="description">Clap Asignados</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Personas Atendidas</th>
                    <th class="description">Proteina Despachada</th>
                    <th class="description">Clap Despachados</th>
                </tr>
                <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                    <th class="description">Porcentaje de Personas Atendidas</th>
                    <th class="description">Porcentaje de Proteina Despachada</th>
                    <th class="description">Porcentaje de Clap Despachados</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($inn_por_mes['personas_por_atender'], 0, ',', '.') . '</td>
                    <td>' . number_format($inn_por_mes['proteina_asignada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($inn_por_mes['clap_asignados'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($inn_carga['personas_atendidas'], 0, ',', '.') . '</td>
                    <td>' . number_format($inn_carga['proteina_despachada'], 2, ',', '.') . ' TON</td>
                    <td>' . number_format($inn_carga['clap_despachados'], 0, ',', '.') . '</td>
                </tr>
                <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                    <td>' . number_format($porcentaje_personas_atendidas, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_proteina_despachada, 2, ',', '.') . '%</td>
                    <td>' . number_format($porcentaje_clap_despachados, 2, ',', '.') . '%</td>
                </tr>
            </tbody>
        </table>
        ';

        $html_diff_inn_carga = '';
        if ($inn_por_mes['personas_por_atender'] > $inn_carga['personas_atendidas']) {
            $html_diff_inn_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($inn_por_mes['personas_por_atender'] - $inn_carga['personas_atendidas'], 0, ',', '.') . ' personas sin atender
            </h6>
            ';
        }
        if ($inn_por_mes['proteina_asignada'] > $inn_carga['proteina_despachada']) {
            $html_diff_inn_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($inn_por_mes['proteina_asignada'] - $inn_carga['proteina_despachada'], 2, ',', '.') . ' TON de proteina sin despachar
            </h6>
            ';
        }
        if ($inn_por_mes['clap_asignados'] > $inn_carga['clap_despachados']) {
            $html_diff_inn_carga .= '
            <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                Hay un déficit de ' . number_format($inn_por_mes['clap_asignados'] - $inn_carga['clap_despachados'], 0, ',', '.') . ' CLAP sin despachar
            </h6>
            ';
        }

        $html .= $html_diff_inn_carga;

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
                        <th class="description">Personas por Atender</th>
                        <th class="description">Proteina Asignada</th>
                        <th class="description">Clap Asignados</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Personas Atendidas</th>
                        <th class="description">Proteina Despachada</th>
                        <th class="description">Clap Despachados</th>
                    </tr>
                    <tr style="background-color: #dfdfdf; text-align: center; word-break: break-word; font-size: 7px;">
                        <th class="description">Porcentaje de Personas Atendidas</th>
                        <th class="description">Porcentaje de Proteina Despachada</th>
                        <th class="description">Porcentaje de Clap Despachados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['personas_por_atender'] . '</td>
                        <td>' . $municipio['proteina_asignada'] . ' TON</td>
                        <td>' . $municipio['clap_asignados'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['personas_atendidas'] . '</td>
                        <td>' . $municipio['proteina_despachada'] . ' TON</td>
                        <td>' . $municipio['clap_despachados'] . '</td>
                    </tr>
                    <tr style="text-align: center; word-break: break-word; font-size: 7px;">
                        <td>' . $municipio['porcentaje_personas_atendidas'] . '%</td>
                        <td>' . $municipio['porcentaje_proteina_despachada'] . '%</td>
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
            if ($municipio['diff_personas'] > 0) {
                $html_tablas_por_municipio .= '
                <h6 style="text-align: left; color: #a20000; font-size: 9px;">
                    Hay un déficit de ' . number_format($municipio['diff_personas'], 0, ',', '.') . ' personas sin atender
                </h6>
                ';
            }
        }

        $pdf->writeHTML($html_tablas_por_municipio, true, false, true, false, '');

        $pdf->Output('Reporte INN - ' . $month_selected . '.pdf', 'I');

    } catch (\Throwable $th) {
        
        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);

        http_response_code(400);
    }
}