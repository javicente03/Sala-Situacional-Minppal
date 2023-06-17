<!-- <div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-inn">
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
                    
                    <form id='form' data-url="/admin/inn/assigned" data-method="post" data-action="fixed" data-redirect="/admin/users">
                        <input type="hidden" name="month_id" value="<?php echo $inn_por_mes['id_inn_por_mes']; ?>">
                        <div class="row" style="justify-content: center;">
                            <?php
                                foreach ($inn_por_municipio as $municipio) {
                            ?>
                                <div class="col col-12">
                                    <label for="" style="color: black; font-weight: bold;">
                                        <?php echo $municipio['name_municipio'] ?>
                                    </label>
                                    <div class="row">
                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Personas por atender
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="personas_<?php echo $municipio['id_inn_por_municipio']; ?>"
                                                name="personas_<?php echo $municipio['id_inn_por_municipio']; ?>"
                                                value="<?php echo $municipio['personas_por_atender']; ?>" min="0">
                                            </div>
                                        </div>
                                        
                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Proteina Asignada (Toneladas)
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="proteina_<?php echo $municipio['id_inn_por_municipio']; ?>"
                                                name="proteina_<?php echo $municipio['id_inn_por_municipio']; ?>"
                                                value="<?php echo $municipio['proteina_asignada']; ?>" min="0" step="0.01">
                                            </div>
                                        </div>

                                        <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Clap Asignados
                                                </label>
                                                <input class="form-control" placeholder="" type="number" id="clap_<?php echo $municipio['id_inn_por_municipio']; ?>" 
                                                name="clap_<?php echo $municipio['id_inn_por_municipio']; ?>"
                                                value="<?php echo $municipio['clap_asignados']; ?>" min="0">
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