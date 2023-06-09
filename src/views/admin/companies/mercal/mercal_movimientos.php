<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-mercal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>MERCAL - Programas Sociales</h1>
                    <p>
                       <?php echo $programa['programa']; ?>
                    </p>
                    <p>
                    <?php echo date('d/m/Y', strtotime($start)) . ' - ' . date('d/m/Y', strtotime($end)); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
    <?php
        include_once 'src/blocks/menu/admin/companies/block_menu_companies.php';
    ?>
        <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="row">

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block ui-block-title ui-block-title-small containerFilters">
                        <h6 class="title" >Data de Mercado de Alimentos</h6>
                    </div>
                    <div class="ui-block ui-block-title ui-block-title-small containerFilters">
                        <div class="row" style="display:flex; flex-wrap: wrap">
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12">
                                <input type="date" name="start" id="start" value="<?php echo $start; ?>" onchange="filterStart()">
                            </div>
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12">
                                <input type="date" name="end" id="end" value="<?php echo $end; ?>" onchange="filterEnd()">
                            </div>
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12">
                                <fieldset class="form-group label-floating is-select">
                                    <label class="control-label">Filtrar por tipo</label>
                                    <select class="form-select" id="filterType" onchange="filterType()">
                                        <option value="all" <?php echo $filter_type == 'all' ? 'selected' : ''; ?>>Todos</option>
                                        <option value="recepcion" <?php echo $filter_type == 'recepcion' ? 'selected' : ''; ?>>Recepcionados</option>
                                        <option value="despacho" <?php echo $filter_type == 'despacho' ? 'selected' : ''; ?>>Despachados</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col col-xl-12">

                            </div>
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12 mt-1">
                                <a href="/admin/mercal/in" class="btn btn-primary btn-lg-2 btn-sm-2 full-width">
                                    Nueva recepción
                                </a>
                            </div>
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12 mt-1">
                                <a href="/admin/mercal/out" class="btn btn-primary btn-lg-2 btn-sm-2 full-width">
                                    Nueva despacho
                                </a>
                            </div>
                            <div class="col col-xl-3 col-lg-4 col-sm-5 col-sm-12 mt-1">
                                <a href="/admin/mercal/export-pdf/<?php echo $programa['id_mercal_stock_programas']; ?>?start=<?php echo $start; ?>&end=<?php echo $end; ?>&filter_type=<?php echo $filter_type; ?>"
                                    class="btn btn-primary btn-lg-2 btn-sm-2 full-width" target="_blank">
                                    Exportar PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll; scrollbar-width: thin; overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="description">Tipo</th>
                                    <th class="description">Cantidad de Proteína</th>
                                    <th class="description">Cantidad de Bolsas</th>
                                    <th class="description">Fecha</th>
                                    <th class="description">Registrado el</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($movimientos as $movimiento) {
                                ?>
                                    <tr class="event-item">
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <?php if ($movimiento['type'] == 'recepcion') { ?>
                                                        <a class="author-name h6" style="background-color: #001640;color: white; padding: 5px; border-radius: 5px;"
                                                        ><b>Recepción</b></a>
                                                    <?php } else { ?>
                                                        <a class="author-name h6" style="background-color: #750000;color: white; padding: 5px; border-radius: 5px;"
                                                        ><b>Despacho</b></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($movimiento['cantidad_proteina'], 2, ',', '.'); ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($movimiento['cantidad_bolsas'], 0, ',', '.'); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo date('d/m/Y', strtotime($movimiento['fecha'])); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo date('d/m/Y', strtotime($movimiento['createdAt'])); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    }

                                    if ($total == 0) {
                                        echo '<tr><td colspan="5" style="text-align: center;">No hay movimientos en el rango de fechas seleccionado</td></tr>';
                                    }
                                ?>

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

    // filtrar por start (fecha de inicio)
    function filterStart() {
        // agregar filtro de rol a los ya aplicados
        let roleFilter = document.getElementById('start').value;
        filters.set('start', roleFilter);

        // actualizar la URL con los filtros aplicados
        window.location.search = filters.toString();
    }

    // filtrar por end (fecha de fin)
    function filterEnd() {
        // agregar filtro de rol a los ya aplicados
        let roleFilter = document.getElementById('end').value;
        filters.set('end', roleFilter);

        // actualizar la URL con los filtros aplicados
        window.location.search = filters.toString();
    }

    // filtrar por type (tipo de movimiento)
    function filterType() {
        // agregar filtro de rol a los ya aplicados
        let roleFilter = document.getElementById('filterType').value;
        filters.set('filter_type', roleFilter);

        // actualizar la URL con los filtros aplicados
        window.location.search = filters.toString();
    }
</script>