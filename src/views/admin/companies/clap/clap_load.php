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
                    <h6 class="title">Registrar nueva entrega de beneficio</h6>
                </div>
                <div class="ui-block-content">
                    <form id='form' data-url="/admin/clap/load" data-method="post" data-action="redirect" data-redirect="/admin/clap">
                        <input type="hidden" name="id_entrega" value="<?php echo $clap['id_clap_por_entrega']; ?>">
                        <div class="row">
                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">Municipio</label>
                                    <select class="form-select" id="municipio" name="municipio">
                                        <option value="0" disabled selected>Seleccione un municipio</option>
                                        <?php
                                            foreach ($municipios as $municipio) {
                                        ?>
                                            <option value="<?php echo $municipio['id_clap_por_municipio']; ?>"><?php echo $municipio['name_municipio']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Clap Entregados
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="cantidad"
                                    name="cantidad" min="0">
                                </div>
                            </div>

                            <div class="form-group label-floating">
                                <label class="control-label">
                                    Nota (Opcional)
                                </label>
                                <textarea class="form-control" placeholder="" id="nota" name="nota" rows="3"></textarea>
                            </div>

                            <div class="col col-12">
                                <div class="row" style="justify-content: center;">
                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                        <button class="btn btn-primary btn-lg full-width" type="submit">Guardar</button>
                                        <!-- Hacer una barra de progreso indefinida para esperar la respuesta del servidor -->
                                        <div class="loader"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>