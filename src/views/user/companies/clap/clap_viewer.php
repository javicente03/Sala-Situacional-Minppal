<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-clap">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>CLAP</h1>
                    <p>
                        Módulo para administrar CLAP
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
    <?php
        include_once 'src/blocks/menu/user/companies/block_menu_companies.php';
    ?>
        <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="row">

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block ui-block-title ui-block-title-small containerFilters">
                        <h6 class="title" >Data de los Comités Locales de Abastecimiento y Producción (CLAP)</h6>
                        
                    </div>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll; scrollbar-width: thin; overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="description">ID</th>
                                    <th class="description">Acciones</th>
                                    <th class="description">Desde</th>
                                    <th class="description">Hasta</th>
                                    <th class="description">Beneficios Entregados</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($claps as $clap) {
                                ?>
                                    <tr class="event-item">
                                        <td class="upcoming" style="text-transform: capitalize;">
                                            #<?php echo $clap['id_clap_por_entrega'] ?>
                                        </td>
                                        <td class="add-event td-actions">
                                            
                                            <a href="/admin/clap/export/<?php echo $clap['id_clap_por_entrega'] ?>" class="btn btn-primary btn-sm" title="Exportar Pdf" target="_blank">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo date("d/m/Y", strtotime($clap['fecha_inicio_entrega'])) ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo date("d/m/Y", strtotime($clap['fecha_fin_entrega'])) ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php 
                                                        if ($clap['beneficios_entregados'] == null) {
                                                            echo "0";
                                                        } else {
                                                            echo Number_format($clap['beneficios_entregados'], 0, ',', '.');
                                                        }
                                                    ?></b></a>
                                                </div>
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