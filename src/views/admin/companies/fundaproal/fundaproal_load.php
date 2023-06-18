<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-fundaproal">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>FUNDAPROAL</h1>
                    <p>
                        Registro de entregas
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
                    <h6 class="title">Registrar nueva entrega - <span style="text-transform: capitalize;"><?php echo $month_selected ?></span></h6>
                </div>
                <div class="ui-block-content">

                    <form id='form' data-url="/admin/fundaproal/load" data-method="post" data-action="fixed" data-redirect="/admin/fundaproal">
                        <input type="hidden" name="month_id" value="<?php echo $fundaproal_por_mes['id_fundaproal_por_mes']; ?>">
                        <div class="row">
                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">Municipio</label>
                                    <select class="form-select" id="municipio" name="municipio">
                                        <option value="0" disabled selected>Seleccione un municipio</option>
                                        <?php
                                            foreach ($fundaproal_por_municipio as $municipio) {
                                        ?>
                                            <option value="<?php echo $municipio['id_fundaproal_por_municipio']; ?>"><?php echo $municipio['name_municipio']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group date-time-picker label-floating">
									<label class="control-label">Fecha de entrega</label>
									<input name="fecha_entrega" value="<?php echo date('Y-m-d'); ?>"
                                    id="fecha_entrega" type="date">
								</div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Clap Entregados
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="clap"
                                    name="clap" min="0">
                                </div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Proteina Entregada (Kg)
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="proteina"
                                    name="proteina" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Fruta Entregada (Kg)
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="fruta"
                                    name="fruta" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Plan Papa Entregado
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="papa"
                                    name="papa" min="0">
                                </div>
                            </div>

                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Plan Paca Entregado
                                    </label>
                                    <input class="form-control" placeholder="" type="number" id="paca"
                                    name="paca" min="0">
                                </div>
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