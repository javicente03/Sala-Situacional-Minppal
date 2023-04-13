<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-bg1">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>Administrador de Usuarios</h1>
                    <p>
                        Módulo para registrar nuevos usuarios y asignar roles de acceso.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
    <?php
        include_once 'src/blocks/menu/admin/users/block_menu_users.php';
    ?>


        <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="row">

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block ui-block-title ui-block-title-small containerFilters">
                        <h6 class="title">Lista de Usuarios</h6>
                    </div>
                </div>

                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <fieldset class="form-group label-floating is-select">
                        <label class="control-label">Filtrar por Rol</label>
                        <select class="form-select" id="filterRole" onchange="filterRole()">
                            <option value="all" <?php echo $filter_role == 'all' ? 'selected' : ''; ?>>Todos</option>
                            <option value="admin" <?php echo $filter_role == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="reader" <?php echo $filter_role == 'reader' ? 'selected' : ''; ?>>Lector</option>
                        </select>
                    </fieldset>
                </div>

                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <fieldset class="form-group label-floating is-select">
                        <label class="control-label">Filtrar por Estado</label>
                        <select class="form-select" id="filterStatus" onchange="filterStatus()">
                            <option value="all" <?php echo $filter_status == 'all' ? 'selected' : ''; ?>>Todos</option>
                            <option value="1" <?php echo $filter_status == '1' ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo $filter_status == '0' ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </fieldset>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll, scrollbar-width: thin, overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="upcoming">Fecha de Registro</th>
                                    <th class="author">Nombre</th>
                                    <th class="description">Correo Electrónico</th>
                                    <th class="description">Rol</th>
                                    <th class="description">Estado</th>
                                    <th class="description">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Imprimir los usuarios -->
                                <?php 
                                    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                                    foreach ($users as $user) { 
                                        // formatear fecha de registro
                                        $day_register = strftime("%d", strtotime($user['createdAt_user']));
                                        $month_year_register = strftime("%B", strtotime($user['createdAt_user'])).' de '.strftime("%Y", strtotime($user['createdAt_user']));

                                        // formatear rol de usuario
                                        $role_user = $user['role_user'] == 'admin' ? 'Administrador' : 'Lector';
                                        $class_role_user = $user['role_user'] == 'admin' ? 'text-primary' : 'text-warning';

                                        // formatear estado de usuario
                                        $status_user = $user['active_user'] == 1 ? 'Activo' : 'Inactivo';
                                        $class_status_user = $user['active_user'] == 1 ? 'text-success' : 'text-danger';
                                    ?>
                                    <tr class="event-item" key={index}>
                                        <td class="upcoming">
                                            <div class="date-event">
                                                <svg class="olymp-small-calendar-icon"><use href="#olymp-small-calendar-icon"></use></svg>
                                                <span class="day">
                                                    <?php 
                                                        echo $day_register;
                                                    ?>
                                                </span>
                                                <span class="month">
                                                    <?php 
                                                        echo $month_year_register;
                                                    ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $user['name_user'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="description">
                                            <p class="description"><?php echo $user['email_user'] ?></p>
                                        </td>
                                        <td class="description">
                                            <p class="description <?php echo $class_role_user ?>"><?php echo $role_user ?></p>
                                        </td>
                                        <td class="description">
                                            <p class="description <?php echo $class_status_user ?>"><?php echo $status_user ?></p>
                                        </td>
                                        <td class="add-event" style="text-align: center">
                                            <a href="/admin/users/edit/<?php echo $user['id_user'] ?>" class="btn btn-primary btn-sm" title="Editar Usuario" target="_blank">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <!-- Imprimir mensaje de no hay usuarios -->
                                <?php if ($total <= 0) { ?>
                                    <tr class="event-item">
                                        <td class="upcoming" colspan="9">
                                            <div class="date-event">
                                                <span class="day">No hay Usuarios</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total > 0)
                        include_once 'src/blocks/pagination/block_pagination.php'; 
                    ?>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // obtener filtros ya aplicados
    let filters = new URLSearchParams(window.location.search);

    // filtrar usuarios por rol
    function filterRole() {
        // agregar filtro de rol a los ya aplicados
        let roleFilter = document.getElementById('filterRole').value;
        filters.set('role', roleFilter);

        // actualizar la URL con los filtros aplicados
        window.location.search = filters.toString();
    }

    // filtrar usuarios por estado
    function filterStatus() {
        // agregar filtro de estado a los ya aplicados
        let statusFilter = document.getElementById('filterStatus').value;
        filters.set('status', statusFilter);

        // actualizar la URL con los filtros aplicados
        window.location.search = filters.toString();
    }

</script>