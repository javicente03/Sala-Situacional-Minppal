<div class="main-header stunning-header" style="background-color: #2929ffd4;">
    <div class="content-bg-wrap stunning-header-bg1">
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h1>Administrador de Usuarios</h1>
                    <p>
                        Módulo para registrar nuevos usuarios y asignar roles de acceso.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
    <?php
        include_once 'src/blocks/menu/admin/users/block_menu_users.php';
    ?>


    <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
        <div class="ui-block">
            <div class="ui-block-title">
                <h6 class="title">Editar Usuario - <?php echo $user['name_user']; ?></h6>
            </div>
            <div class="ui-block-content">
                
                <form id='form' data-url="/admin/users/edit" data-method="post" data-action="redirect" data-redirect="/admin/users">
                    <input type="hidden" name="id" value="<?php echo $user['id_user']; ?>">
                    <div class="row" style="justify-content: center;">
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre y Apellido</label>
                                <input class="form-control" placeholder="" type="text" id="name" name="name" value="<?php echo $user['name_user']; ?>">
                            </div>
                        </div>
                
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Correo Electrónico</label>
                                <input class="form-control" placeholder="" type="email" id="email" name="email" value="<?php echo $user['email_user']; ?>">
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Contraseña</label>
                                <input class="form-control" placeholder="" type="password" id="password" name="password">
                                <button class="visibility-button" type="button" id="togglePassword" style="outline: none">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label">Rol de Usuario</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="reader" <?php echo $user['role_user'] == 'reader' ? 'selected' : ''; ?>>Lector</option>
                                    <option value="admin" <?php echo $user['role_user'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="description-toggle">
                                <div class="description-toggle-content">
                                    <div class="h6">Estado del Usuario (Activo / Inactivo)</div>
                                </div>
                
                                <div class="togglebutton">
                                    <label>
                                        <input type="checkbox" name="status" id="status" <?php echo $user['active_user'] == 1 ? 'checked' : ''; ?> value="1">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <button class="btn btn-primary btn-lg full-width" type="submit">Crear Usuario</button>
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

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        let icon = togglePassword.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>