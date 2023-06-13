<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-clap">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>CLAP</h1>
                    <p>
                        Nueva Jornada de Entregas
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
                    <h6 class="title">Iniciar nueva jornada de entrega</h6>
                </div>
                <div class="ui-block-content">
                    <form id='form' data-url="/admin/clap/create" data-method="post" data-action="redirect" data-redirect="/admin/clap/custom/" data-lastid="1">
                        <div class="row">
                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">Desde</label>
									<input name="desde"
                                    id="desde" type="date">
                                </div>
                            </div>
                            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">Hasta</label>
									<input name="hasta"
                                    id="hasta" type="date">
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