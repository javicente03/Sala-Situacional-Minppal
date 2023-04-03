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
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias saepe, et repellendus magni facilis esse laudantium quae sequi, necessitatibus cumque sit repudiandae nulla! Nam nulla, consequatur sequi sed iusto tempore iure numquam error provident maxime harum, deleniti et aliquid voluptate ipsa, sint architecto rem animi repudiandae dignissimos iste inventore accusantium ea? Voluptatem, asperiores? Eaque non libero, numquam dolore reprehenderit in doloribus. Voluptatibus quas quibusdam obcaecati quaerat cumque distinctio amet quasi. Sunt fugit soluta quos incidunt voluptatum unde dolore error explicabo, quod quibusdam repellat hic dolor doloribus rerum asperiores quasi. Praesentium ullam exercitationem itaque quia autem suscipit maiores minus omnis. Quibusdam.
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
                        <div class="item">
                            <h1>It’s all about <br />Promoting your Business</h1>
                            <div class="space-10"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                            <div class="space-50"></div>
                            <a href="https://www.youtube.com/watch?v=iaj8ktgL3BY" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
                        </div>
                        <div class="item">
                            <h1>It’s all about <br />Promoting your Business</h1>
                            <div class="space-10"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                            <div class="space-50"></div>
                            <a href="https://www.youtube.com/watch?v=iaj8ktgL3BY" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
                        </div>
                        <div class="item">
                            <h1>It’s all about <br />Promoting your Business</h1>
                            <div class="space-10"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                            <div class="space-50"></div>
                            <a href="https://www.youtube.com/watch?v=iaj8ktgL3BY" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
                        </div>
                        <div class="item">
                            <h1>It’s all about <br />Promoting your Business</h1>
                            <div class="space-10"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                            <div class="space-50"></div>
                            <a href="https://www.youtube.com/watch?v=iaj8ktgL3BY" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
                        </div>
                        <div class="item">
                            <h1>It’s all about <br />Promoting your Business</h1>
                            <div class="space-10"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                            <div class="space-50"></div>
                            <a href="https://www.youtube.com/watch?v=iaj8ktgL3BY" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="home_screen_slide">
                    <div class="single_screen_slide wow fadeInRight">
                        <div class="item"><img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/images/mercal_logo.webp' ?>" alt=""></div>
                        <div class="item"><img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/images/mercal_logo.webp' ?>" alt=""></div>
                        <div class="item"><img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/tpl2/images/screen/screen3.jpg' ?>" alt=""></div>
                        <div class="item"><img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/tpl2/images/screen/screen4.jpg' ?>" alt=""></div>
                        <div class="item"><img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/tpl2/images/screen/screen5.jpg' ?>" alt=""></div>
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
                <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli incididunt ut labore Lorem ipsum madolor sit amet.</p>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-md-6 wow fadeInUp">
                <div class="space-60"></div>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Sedeiusmod tempor inccsetetur aliquatraiy? </a></h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodas temporo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrd exercitation ullamco laboris nisi ut aliquip ex comodo consequat. Duis aute dolor in reprehenderit.</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Tempor inccsetetur aliquatraiy?</a></h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Lorem ipsum dolor amet, consectetur adipisicing ?</a></h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Lorem ipsum dolor amet, consectetur adipisicing ?</a></h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs hidden-sm col-md-5 col-md-offset-1 wow fadeInRight ">
                <img src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/public/tpl2/images/2mobile.png' ?>" alt="">
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