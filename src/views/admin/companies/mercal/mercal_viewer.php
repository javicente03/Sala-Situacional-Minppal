<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-mercal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>MERCAL</h1>
                    <p>
                        Módulo para administrar MERCAL
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
                                <a href="/admin/mercal/export-pdf?start=<?php echo $start; ?>&end=<?php echo $end; ?>" target="_blank"
                                class="btn btn-primary btn-lg-2 btn-sm-2 full-width">
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
                                    <th class="description">Acciones</th>
                                    <th class="description">Programa</th>
                                    <th class="description">Stock Proteina</th>
                                    <th class="description">Stock Bolsas</th>
                                    <th class="description">Proteina Recepcionada</th>
                                    <th class="description">Proteina Despachada</th>
                                    <th class="description">Bolsas Recepcionadas</th>
                                    <th class="description">Bolsas Despachadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($data_return as $programa) {
                                ?>
                                    <tr class="event-item">
                                        <td class="add-event td-actions">
                                            <a href="/admin/mercal/program/<?php echo $programa['id_mercal_stock_programas']; ?>"
                                            class="btn btn-primary btn-sm" title="Ver detalle" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $programa['programa']; ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['stock_proteina'], 2, ',', '.'); ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['stock_bolsas'], 0, ',', '.'); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['proteina_recepcionada'], 2, ',', '.'); ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['proteina_despachada'], 2, ',', '.'); ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['bolsas_recepcionadas'], 0, ',', '.'); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($programa['bolsas_despachadas'], 0, ',', '.'); ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
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
</script>