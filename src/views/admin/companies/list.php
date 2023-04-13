<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-bg1">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>Administrador de Empresas</h1>
                    <p>
                        Módulo para administrar las empresas registradas en el sistema.
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
                        <h6 class="title">Lista de Empresas</h6>
                    </div>
                </div>

                <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="ui-block" style="overflow: scroll, scrollbar-width: thin, overflow-y: hidden">
                        <table class="event-item-table">
                            <thead>
                                <tr class="headers-table">
                                    <th class="description">ID</th>
                                    <th class="description">Nombre</th>
                                    <th class="description">Misión</th>
                                    <th class="description">Visión</th>
                                    <th class="description">Logo</th>
                                    <th class="description">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Imprimir los usuarios -->
                                <?php 
                                    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                                    foreach ($companies as $company) { 
                                    ?>
                                    <tr class="event-item" key={index}>
                                        <td class="upcoming">
                                            #<?php echo $company['id_company'] ?>
                                        </td>
                                        <td class="author">
                                            <div class="event-author inline-items">
                                                <div class="author-date">
                                                    <a class="author-name h6"><b><?php echo $company['name_company'] ?></b></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="description">
                                            <p class="description"><?php echo $company['mision_company'] ?></p>
                                        </td>
                                        <td class="description">
                                            <p class="description"><?php echo $company['vision_company'] ?></p>
                                        </td>
                                        <td class="description tdImgCenter">
                                            <ul class="widget w-last-photo js-zoom-gallery" style="display: flex; justify-content: center; width: 50px">
                                                <!-- <li> -->
                                                    <a href="<?php echo $url_domain.$company['logo_company'] ?>" class="js-zoom-gallery-item">
                                                        <img loading="lazy" src="<?php echo $url_domain.$company['logo_company'] ?>"
                                                         alt="photo">
                                                    </a>
                                                <!-- </li> -->
                                            </ul>
                                        </td>
                                        <td class="add-event" style="text-align: center">
                                            <a href="/admin/companies/edit/<?php echo $company['id_company'] ?>" class="btn btn-primary btn-sm" title="Editar Usuario" target="_blank">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <!-- Imprimir mensaje de no hay usuarios -->
                                <?php if ($total <= 0) { ?>
                                    <tr class="event-item">
                                        <td class="upcoming" colspan="6">
                                            <div class="date-event">
                                                <span class="day">No hay empresas registradas</span>
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