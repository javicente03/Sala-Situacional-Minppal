<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-mercal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>MERCAL - Base de Misiones</h1>
                    <p>
                        Modificacion de las misiones
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
                    <div class="ui-block">
                        <div class="ui-block-title">
                            <h6 class="title">Edicion: <?php echo $mision['name_municipio'] . ' - ' . $mision['name_parroquia'] . ' - ' . $mision['name_mision']; ?></h6>
                        </div>
                        <div class="ui-block-content">
                            <form id='form' data-url="/admin/mercal-bm/edit" data-method="post" data-action="redirect" data-redirect="/admin/mercal-bm">
                                <input type="hidden" name="id_mision" value="<?php echo $mision['id_base_de_mision']; ?>">
                                <div class="row">
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Cantidad de Familias
                                            </label>
                                            <input class="form-control" placeholder="" type="number" id="familias"
                                            name="familias" min="0" step="1" value="<?php echo $mision['cantidad_familias']; ?>">
                                        </div>
                                    </div>

                                    <div class="col col-lg-9 col-md-6 col-sm-12 col-12 m-auto">
                                        <button class="btn btn-primary btn-lg full-width" type="submit">Modificar</button>
                                        <!-- Hacer una barra de progreso indefinida para esperar la respuesta del servidor -->
                                        <div class="loader"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div>
</div>