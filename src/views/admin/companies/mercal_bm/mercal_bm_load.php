<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-mercal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>MERCAL - Base de Misiones</h1>
                    <p>
                        Nueva Entrega
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
                                <h6 class="title">Mercal - Base de Misiones - Nueva Entrega</h6>
                            </div>
                            <div class="ui-block-content">
                                <form id='form' data-url="/admin/mercal-bm/load" data-method="post" data-action="fixed" data-redirect="/admin/mercal-bm">
                                    <div class="row">
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label">Bases de Misiones</label>
                                                <select class="form-select" id="id_mision" name="id_mision">
                                                    <option value="0" disabled selected>Seleccione una misión</option>
                                                    <?php
                                                        foreach ($misiones as $mision) {
                                                    ?>
                                                        <option value="<?php echo $mision['id_base_de_mision']; ?>"><?php echo $mision['name_municipio'] . ' - ' . $mision['name_parroquia'] . ' - ' . $mision['name_mision']; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label">Fecha de recepción</label>
                                                <input name="fecha" value="<?php echo date('Y-m-d') ?>"
                                                id="fecha" type="date">
                                            </div>
                                        </div>

                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Proteína entregada (Kg)
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="proteina"
                                                name="proteina" min="0" step="0.01" value="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Claps Entregados
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="clap"
                                                name="clap" min="0" step="1" value="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                                            <button class="btn btn-primary btn-lg full-width" type="submit">Registrar</button>
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
    </div>
</div>