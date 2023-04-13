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
        <div class="ui-block">
            <div class="ui-block-title">
                <h6 class="title">Editar Empresa <?php echo $company['name_company']; ?></h6>
            </div>
            <div class="ui-block-content">
                
                <form id='form-fichero' data-url="/admin/companies/edit" data-method="post" data-action="fixed" data-redirect="/admin/companies">
                    <input type="hidden" name="id" value="<?php echo $company['id_company']; ?>">
                    <div class="row" style="justify-content: center;">
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de la Empresa</label>
                                <input class="form-control" placeholder="" type="text" id="name" name="name" value="<?php echo $company['name_company']; ?>">
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Misión de la Empresa</label>
                                <textarea class="form-control" placeholder="" type="text" id="mision" name="mision"><?php echo trim($company['mision_company']); ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Visión de la Empresa</label>
                                <textarea class="form-control" placeholder="" type="text" id="vision" name="vision"><?php echo trim($company['vision_company']); ?>
                                </textarea>
                            </div>
                        </div>

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