<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-cnae">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>CNAE</h1>
                    <p>
                        Módulo para administrar CNAE
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
                        <h6 class="title" >Data de la Corporación Nacional de Alimentación Escolar</h6>
                    </div>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll, scrollbar-width: thin, overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="description">Mes</th>
                                    <th class="description">Instituciones</th>
                                    <th class="description">Matricula</th>
                                    <th class="description">Proteina Asignada</th>
                                    <th class="description">Fruta Asignada</th>
                                    <th class="description">Clap Asignados</th>
                                    <th class="description">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                                    foreach ($cnae_por_mes as $cnae) {
                                        $fecha_inicio = new DateTime($cnae['fecha_inicio_cnae_por_mes']);
                                        $fecha_fin = new DateTime($cnae['fecha_fin_cnae_por_mes']);
                                        $fecha_inicio = $fecha_inicio->format('d/m/Y');
                                        $fecha_fin = $fecha_fin->format('d/m/Y');

                                        // Obtener el mes: Mayo 2021 en español
                                        $mes = strftime("%B %Y", strtotime($cnae['fecha_inicio_cnae_por_mes']));
                                ?>
                                    <tr class="event-item">
                                        <td class="upcoming" style="text-transform: capitalize;">
                                            <?php echo $mes ?>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($cnae['instituciones_cnae_por_mes'], 0, ',', '.') ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($cnae['matricula_cnae_por_mes'], 0, ',', '.') ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- TONELADAS -->
                                                    <a class="author-name h6"><b><?php echo number_format($cnae['proteina_asignada_cnae_por_mes'], 2, ',', '.') ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo number_format($cnae['fruta_asignada_cnae_por_mes'], 2, ',', '.') ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo number_format($cnae['clap_asignados_cnae_por_mes'], 0, ',', '.') ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="add-event" style="text-align: center">
                                            <a href="/admin/cnae/<?php echo $cnae['id_cnae_por_mes'] ?>"
                                            class="btn btn-primary btn-sm" title="Ver detalle" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/admin/companies/edit" class="btn btn-primary btn-sm" title="Modificar indices" target="_blank">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            
            </div>
        </div>

    </div>
</div>