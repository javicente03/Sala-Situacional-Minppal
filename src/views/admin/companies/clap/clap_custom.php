<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-clap">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>CLAP</h1>
                    <p>
                        <?php echo date('d/m/Y', strtotime($clap['fecha_inicio_entrega'])) . ' - ' . date('d/m/Y', strtotime($clap['fecha_fin_entrega'])); ?>
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
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">Customización de entrega CLAP por municipio</h6>
                </div>
                <div class="ui-block-content">
                    <form id='form' data-url="/admin/clap/custom" data-method="post" data-action="fixed" data-redirect="/admin/clap">
                        <input type="hidden" name="id_clap_por_entrega" id="id_clap_por_entrega" value="<?php echo $clap['id_clap_por_entrega'] ?>">
                        <div class="row">
                            <?php
                                foreach ($municipios as $municipio) {
                            ?>
                            <div class="col col-12">
                                <label for="" style="color: black; font-weight: bold;">
                                    <?php echo $municipio['name_municipio'] ?>
                                </label>
                                <div class="row">
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label">Fecha de cobro</label>
                                            <input name="fechacobro_<?php echo $municipio['id_clap_por_municipio'] ?>" value="<?php echo $municipio['fecha_cobro'] ?>"
                                            id="fechacobro_<?php echo $municipio['id_clap_por_municipio'] ?>" type="date">
                                        </div>
                                    </div>
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label">Fecha de despacho</label>
                                            <input name="fechadespacho_<?php echo $municipio['id_clap_por_municipio'] ?>" value="<?php echo $municipio['fecha_despacho'] ?>"
                                            id="fechadespacho_<?php echo $municipio['id_clap_por_municipio'] ?>" type="date">
                                        </div>
                                    </div>
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label">Precio</label>
                                            <input name="precio_<?php echo $municipio['id_clap_por_municipio'] ?>" value="<?php echo $municipio['precio'] ?>"
                                            id="precio_<?php echo $municipio['id_clap_por_municipio'] ?>" type="number" step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label">Comercializadora</label>
                                            <input name="comercializadora_<?php echo $municipio['id_clap_por_municipio'] ?>" value="<?php echo $municipio['comercializadora'] ?>"
                                            id="comercializadora_<?php echo $municipio['id_clap_por_municipio'] ?>" type="text" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                                <button class="btn btn-primary btn-lg full-width" type="submit">Guardar Cambios</button>
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