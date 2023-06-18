<!-- <div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-fundaproal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>CNAE</h1>
                    <p>
                        Módulo para administrar CNAE 
                    </p>
                    <h5 style="text-transform: capitalize;"
                    ><?php //echo $month_selected ?></h5>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="container" style="margin-top: 100px;">
    <div class="row">
    <?php
        include_once 'src/blocks/menu/admin/companies/block_menu_companies.php';
    ?>

        <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">Modificar recursos asignados a los municipios - <span style="text-transform: capitalize;"><?php echo $month_selected ?></span></h6>
                </div>
                <div class="ui-block-content">
                    
                    <form id='form' data-url="/admin/fundaproal/assigned" data-method="post" data-action="fixed" data-redirect="/admin/users">
                        <input type="hidden" name="month_id" value="<?php echo $fundaproal_por_mes['id_fundaproal_por_mes']; ?>">
                        <div class="row" style="justify-content: center;">
                            <?php
                                foreach ($fundaproal_por_municipio as $municipio) {
                            ?>
                                <div class="col col-12">
                                    <label for="" style="color: black; font-weight: bold;">
                                        <?php echo $municipio['name_municipio'] ?>
                                    </label>
                                    <div class="row">
                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Cantidad de Casas de Alimentación
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="casas_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="casas_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['cantidad_casas_alimentacion']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    CEMR
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="cemr_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="cemr_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['cemr']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Cantidad de Misioneros
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="misioneros_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="misioneros_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['cantidad_misioneros']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Cantidad de Madres Elaboradoras
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="madres_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="madres_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['cantidad_madres_elab']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Cantidad de Padres Elaboradores
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="padres_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="padres_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['cantidad_padres_elab']; ?>" min="0">
                                            </div>
                                        </div>
                                        
                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Proteina Asignada (Toneladas)
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="proteina_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="proteina_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['proteina_asignada']; ?>" min="0" step="0.01">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Fruta Asignada (Toneladas)
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="fruta_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="fruta_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['fruta_asignada']; ?>" min="0" step="0.01">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Clap Asignados
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="clap_<?php echo $municipio['id_fundaproal_por_municipio']; ?>" 
                                                name="clap_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['clap_asignados']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Plan Papa Asignado
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="papa_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="papa_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['plan_papa_asignado']; ?>" min="0">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Plan Paca Asignado
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="paca_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                name="paca_<?php echo $municipio['id_fundaproal_por_municipio']; ?>"
                                                value="<?php echo $municipio['plan_paca_asignado']; ?>" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
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