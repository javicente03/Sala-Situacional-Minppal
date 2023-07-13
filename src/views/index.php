<!--Header-Area-->
<header class="blue-bg relative fix" id="home">
    <div class="section-bg overlay-bg angle-bg ripple header-background">
        <div class="parallax-image">
            <img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/images/falcon.png' ?>" alt="">
        </div>
    </div>
    <!--Mainmenu-->
    <nav class="navbar navbar-default mainmenu-area navbar-fixed-top" data-spy="affix" data-offset-top="60">
        <div class="container">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" class="navbar-toggle" data-target="#mainmenu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">
                    <!--<img src="images/logo.png" alt="">-->
                    <h2 class="text-white logo-text">MINPPAL</h2>
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                <ul class="nav navbar-nav">
                    <li><a href="#home">Inicio</a></li>
                    <li><a href="#about">Acerca de</a></li>
                    <li><a href="#companys">Empresas</a></li>
                    <li><a href="#faq">Preguntas Frecuentes</a></li>
                    <?php
                        if (isset($_SESSION['user'])) {
                            echo '<li><a href="/session">Ingresar</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!--Mainmenu/-->
    <div class="space-100"></div>
    <div class="space-20 hidden-xs"></div>
    <!--Header-Text-->
    <div class="container text-white">
        <div class="row text-center">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="space-40"></div>
                <!-- <div class="space-100"></div> -->
                <h1>Ministerio del Poder Popular Para la Alimentación<br> <h3>Sala Situacional</h3></h1>

                <?php
                    if (isset($_SESSION['user'])) {
                        echo '<h3 class="text-white">Bienvenido ' . $_SESSION['user']. '</h3>';
                    } else {
                    ?>
                        <form id='form' data-url="/auth/login" data-method="post" data-action="redirect" data-redirect="/session">
                            <input type="email" class="form-control inputPrincipal" placeholder="Ingrese su correo electrónico" name="email" id="email">
                                <div class="space-10"></div>
                            <div class='containerDual inputPrincipal'>
                                <input type="password" class="form-control inputPrincipal inputPassword" placeholder="Ingrese su contraseña" name="password" id="password">
                                <button class='visibility' type="button" id="visibilityPassword">
                                    <span class="ti-eye"></span>
                                </button>
                            </div>
                            <div class="space-10"></div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block btnPrincipal">Ingresar</button>
                            <!-- Hacer una barra de progreso indefinida para esperar la respuesta del servidor -->
                            <div class="loader"></div>
                        </form>
                    <?php
                    } ?>

                <div class="space-100"></div>
            </div>
        </div>
        <div class="space-80"></div>
    </div>
    <!--Header-Text/-->
</header>

<!--Question-section-->
<section class="fix" id="about">
    <div class="space-80"></div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 text-center">
                <h3 class="titleShadow">
                Acerca del Ministerio del Poder Popular Para la Alimentación</h3>
                <p style="text-align: justify;">
                    Ministerio encargado de velar que se cumpla el derecho constitucional a la alimentación, por cuanto dicta las políticas en esta materia y verifica que las mismas se cumplan para garantizar a toda la población el acceso a los alimentos de la canasta alimentaria a precios justos y de excelente calidad, así como, dirige la política exterior y participación en las negociaciones internacionales en materia de alimentos.
                    <br><h5 style="margin-top: 20px;">
                    MISIÓN </h5>
                    Garantizar el acceso de los alimentos a la población a través de la regulación, formulación, seguimiento y evaluación de políticas en materia de comercio, industria, mercadeo y distribución de alimentos; recepción, almacenamiento, depósito, conservación, transporte, distribución, entrega, colocación, calidad y consumo; inspección, vigilancia, fiscalización y sanción sobre actividades de almacenamiento agrícola y sus actividades conexas administración, operación y explotación de silos, frigoríficos, almacenes y depósitos agrícolas propiedad del Estado; regulación y expedición de permisos, autorizaciones, licencias, certificados y demás tramites y actos necesarios en materia de exportación e importación en el sector de alimentos y alimentación.
                    Así como, dirigir la política exterior y participación en las negociaciones internacionales en materia de alimentos y alimentación; promoción de estrategias para equilibrar la oferta y demanda de los circuitos agroalimentarios; regulación de los productos alimenticios, completando los ciclos de producción y comercialización, concertación, análisis y la fijación de precios y tarifas de productos y servicios alimenticios; políticas de financiamiento en el sector de producción y comercio de alimento; políticas para la adquisición, instalación y administración de maquinarias y equipos necesarios para la producción y comercialización de alimentos, en coordinación con los órganos competentes; a fin de mejorar la calidad de vida y lograr la seguridad alimentaria de la nación, en el marco del modelo productivo socialista.
                    <br><h5 style="margin-top: 20px;">
                    VISIÓN </h5>
                    Ser el órgano de la Administración Pública rector y coordinador de la política alimentaria, capaz de impulsar la seguridad y soberanía alimentaria a toda la población, en articulación con los órganos competentes y el sector productivo, con predominio de la producción nacional, basado en el modelo social productivo eficiente, socialista, humanista y endógeno; con la participación masiva de la comunidad, en el marco de los principios y valores de la revolución bolivariana.

                </p>
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>

<header class="blue-bg relative fix" id="companys">
    <div class="section-bg overlay-bg dewo ripple header-blue"></div>
    <!--Header-Text-->
    <div class="container text-white">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="space-100"></div>
                <div class="home_screen_slide_main">
                    <div class="home_text_slide">
                        <?php foreach ($companies as $company) { ?>
                            <div class="item">
                                <h1>
                                    <?php echo $company['name_company']; ?>
                                </h1>
                                <div class="space-10"></div>
                                <h3>Misión</h3>
                                <p>
                                    <?php echo $company['mision_company']; ?>
                                </p>
                                <div class="space-50"></div>
                                <h3>Visión</h3>
                                <p>
                                    <?php echo $company['vision_company']; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="home_screen_slide">
                    <div class="single_screen_slide wow fadeInRight">
                        <?php foreach ($companies as $company) { ?>
                            <div class="item">
                                <img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/'.$company['logo_company']; ?>" alt="logo">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="home_screen_nav hidden-xs hidden-sm">
                    <span class="ti-angle-left testi_prev"></span>
                    <span class="ti-angle-right testi_next"></span>
                </div>
            </div>
        </div>
        <div class="space-80"></div>
    </div>
</header>
    <!--Header-Text/-->


<!--Question-section/-->

<!--Header-Area/-->

<!--Question-section-->
<section class="fix" id="faq">
    <div class="space-80"></div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                <h3 class="text-uppercase">Preguntas Frecuentes</h3>
                <p>Aquí encontrarás algunas dudas recurrentes respecto al sistema.</p>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-md-6 wow fadeInUp">
                <div class="space-60"></div>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">¿Cómo puedo crear un nuevo usuario?</a></h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">Para esto necesitas permisos de administrador, una vez inicies sesión, debes dirigirte al modulo <b>Administración de Usuarios</b>,
                            podrás ver el listado y en el menú del lado izquierdo encontras la opcion <b>Crear</b>. Una vez en la pantalla de creación, completa los datos solicitados
                            y presiona el botón <b>Crear Usuario</b>
                        </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">¿Qué diferencias hay en entre el usuario Administrador y Lector?</a></h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                El usuario <b>Administrador</b> tiene acceso a todas las funcionalidades del sistema, incluyendo la carga de información y administración de usuarios.
                                El usuario <b>Lector</b> solo tiene acceso a la visualización de la información, no puede cargar información ni administrar usuarios.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">¿Cuántas empresas adscritas se manejan en el sistema?</a></h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                5 empresas adscritas al Ministerio del Poder Popular para la Alimentación.
                                INN, CNAE, CLAP, FUNDAPROAL y MERCAL.
                                Sin embargo MERCAL cuenta con dos modulos a disposición, donde se administra la información relacionada a 
                                los <b>Programas Sociales</b> y las <b>Bases de Misiones</b>. 
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">¿Cómo se carga información a cada módulo?</a></h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                Cada módulo guarda diferentes datos, sin embargo el flujo de carga es similar para todos.
                                Debes dirigirte al módulo que deseas cargar información.
                                Para CNAE, INN y FUNDAPROAL, la data es separada de manera mensual automaticamente, solo debes configurar los valores asignados a cada mes por municipio.
                                Para CLAP, debes iniciar una nueva entrega estableciendo las fechas y los costos del mismo.
                                Para Mercal Programas Sociales, la información se registra a modo de entrada y salida de mercancía por cada programa, esta es separada mediante periodos de tiempo,
                                establecidos a gusto del usuario.
                                Para Mercal Base de Misiones, se registran las entregas realizadas a cada base de misiones, separadas por periodos de tiempo establecidos a gusto del usuario.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs hidden-sm col-md-5 col-md-offset-1 wow fadeInRight ">
                <img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/images/Modulo de vista de INN.png' ?>" alt="">
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>
<!--Question-section/-->

<!--Footer-area-->
<footer class="black-bg">
    <div class="container">
        <div class="row text-white wow fadeIn">
            <div class="col-xs-12 text-center">
                
                <div class="space-20"></div>
                <p>© 2023 <a href="https://themeforest.net/user/themectg">Minppal - Sala Situacional</a> Todos los derechos reservados.</p>
            </div>
        </div>
        <div class="space-20"></div>
    </div>
</footer>
<!-- Footer End -->

<?php
include_once 'src/blocks/footerLanding.php';
?>

<script>
    $(document).ready(function(){
        $('#visibilityPassword').click(function(){
            if($('.inputPassword').attr('type') == 'password'){
                $('.inputPassword').attr('type', 'text');
            }else{
                $('.inputPassword').attr('type', 'password');
            }
        });
    });
</script>