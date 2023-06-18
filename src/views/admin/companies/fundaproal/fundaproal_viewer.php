<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-fundaproal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>FUNDAPROAL</h1>
                    <p>
                        Módulo para administrar FUNDAPROAL
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
                        <h6 class="title" >Data de la Fundación Programa de Alimentos Estratégicos</h6>
                    </div>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll; scrollbar-width: thin; overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="description">Mes</th>
                                    <th class="description">Acciones</th>
                                    <th class="description">Cantidad de casas de alimentación</th>
                                    <th class="description">CEMR</th>
                                    <th class="description">Misioneros</th>
                                    <th class="description">Madres elaboradoras</th>
                                    <th class="description">Padres elaboradores</th>
                                    <th class="description">Proteina Asignada</th>
                                    <th class="description">Proteina Despachada</th>
                                    <th class="description">Fruta Asignada</th>
                                    <th class="description">Fruta Despachada</th>
                                    <th class="description">Clap Asignados</th>
                                    <th class="description">Clap Despachados</th>
                                    <th class="description">Plan Papa Asignado</th>
                                    <th class="description">Plan Papa Despachado</th>
                                    <th class="description">Plan Paca Asignado</th>
                                    <th class="description">Plan Paca Despachado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                                    foreach ($data_return as $fundaproal) {
                                        $fecha_inicio = new DateTime($fundaproal['fecha_inicio_fundaproal_por_mes']);
                                        $fecha_fin = new DateTime($fundaproal['fecha_fin_fundaproal_por_mes']);
                                        $fecha_inicio = $fecha_inicio->format('d/m/Y');
                                        $fecha_fin = $fecha_fin->format('d/m/Y');

                                        // Obtener el mes: Mayo 2021 en español
                                        $mes = strftime("%B %Y", strtotime($fundaproal['fecha_inicio_fundaproal_por_mes']));
                                ?>
                                    <tr class="event-item">
                                        <td class="upcoming" style="text-transform: capitalize;">
                                            <?php echo $mes ?>
                                        </td>
                                        <td class="add-event td-actions">
                                            <a href="/admin/fundaproal/<?php echo $fundaproal['id_fundaproal_por_mes'] ?>"
                                            class="btn btn-primary btn-sm" title="Ver detalle" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/admin/fundaproal/assigned/<?php echo $fundaproal['id_fundaproal_por_mes'] ?>" class="btn btn-primary btn-sm" title="Modificar indices" target="_blank">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/fundaproal/load/<?php echo $fundaproal['id_fundaproal_por_mes'] ?>" class="btn btn-primary btn-sm" title="Subir entrega" target="_blank">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                            <a href="/admin/fundaproal/month-export/<?php echo $fundaproal['id_fundaproal_por_mes'] ?>" class="btn btn-primary btn-sm" title="Exportar Pdf" target="_blank">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['cantidad_casas_alimentacion'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['cemr'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['cantidad_misioneros'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['cantidad_madres_elab'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- TONELADAS -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['cantidad_padres_elab'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- TONELADAS -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['proteina_asignada'] ?> TON</b></a><br>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- TONELADAS -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['proteina_despachada'] ?> TON</b></a><br>
                                                    <a class="author-name h6"><b>(<?php echo $fundaproal['porcentaje_proteina_despachada'] ?>%)</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['fruta_asignada'] ?> TON</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['fruta_despachada'] ?> TON</b></a><br>
                                                    <a class="author-name h6"><b>(<?php echo $fundaproal['porcentaje_fruta_despachada'] ?>%)</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['clap_asignados'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['clap_despachados'] ?></b></a><br>
                                                    <a class="author-name h6"><b>(<?php echo $fundaproal['porcentaje_clap_despachados'] ?>%)</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['plan_papa_asignado'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <!-- Que acepte decimales -->
                                                    <a class="author-name h6"><b><?php echo $fundaproal['plan_papa_despachado'] ?></b></a><br>
                                                    <a class="author-name h6"><b>(<?php echo $fundaproal['porcentaje_plan_papa_despachado'] ?>%)</b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <!-- Que acepte decimales -->
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['plan_paca_asignado'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <!-- Que acepte decimales -->
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $fundaproal['plan_paca_despachado'] ?></b></a><br>
                                                    <a class="author-name h6"><b>(<?php echo $fundaproal['porcentaje_plan_paca_despachado'] ?>%)</b></a>
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