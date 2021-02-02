<?php

//Inicializacion del estado de sesion
if(!isset($_SESSION)){
    session_start();
}
//Existen datos del usuario en el estado de sesion?

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    echo 'volver a login';
    var_dump(DOMAIN);
    header("Location:".DOMAIN."/controlUsuarios/login");
}

//var_dump($_SESSION);
//echo '<br>';
//var_dump($_POST);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title> Eventario </title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimun-scale=1.0">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <!--<script src="js/bootstrap.min.js"></script>-->
<link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">


<style>
    
    /* Imagen de fondo */
    .fondo-blur{
  position: relative;
  overflow: hidden;
}

.fondo-blur::before{
  content: '';
  display: block;
  background: inherit;
  position: absolute;
  width: 100%; height: 100%;
  left: 0; top: 0;
  filter: blur(15px);
  transform: scale(1.2,1.4);
}
</style>
</head>
<body>
    
<!-- Nav Bar -->
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a href="#" class="navbar-brand">
                    Eventario
                </a>
                <button class="navbar-toggler" data-target="#menu" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">Inicio</a></li>
                        <li class="navbar-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="desplegable">Inventario</a>
                            <div class="dropdown-menu"> 
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>"> Hacer Reporte</a>
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/historial?pagina=1&usuario=<?=$usuario?>"> Historial de Reportes</a>
                            </div>
                        </li>
                        <li class="navbar-item"><a href="<?=DOMAIN?>/controlTerminos/glosario" class="nav-link">Academia</a></li>
                        <li class="navbar-item"><a href="<?=DOMAIN?>/controlTerminos/contacto" class="nav-link">Contacto</a></li>
                    </ul>
                </div>
            </nav>
       </div>
       <div class="clearfix"></div>
<!-- /Nav Bar -->
<!-- Main, Login, Slogan -->
       <!-- Imangen Wine -->
   
<!-- /Imangen Wine -->
       <div class="container">
            <section class="main row">
                <article class="col-xs-12 col-sm-8 col-md-9">
                    <img src="<?php echo DOMAIN."/imagen2.jpg"?>" class="img-fluid" alt="Responsive image" class="fondo-blur" class="fondo-blur::before"  height="100%">
                </article>
                <aside class="col-xs-12 col-sm-4 col-md-3 text-right">
                        <p class="text-justify text-left"> Bienvenido <?php print($usuario); ?> <br> 
                        <a href="<?=DOMAIN?>//controlUsuarios/login">Cerrar sesion</a></p>
                        
                </aside>
            </section>
                     <!-- Aside 
                    <aside class="col-xs-12 col-sm-4 col-md-3 propia text-right">
                        <h2>ASIDE</h2>
                        <img src="imagen1.png" class="img-fluid" alt="Responsive image" height="15%">
                          <p class="text-justify text-right"> Bienvenido <? echo $usuario; ?> <br> 
                        <a href="<?=DOMAIN?>//controlUsuarios/login">Cerrar sesion</a></p>

                        <p class="lead"> <s>QUE BOLAS SUBRAYAO</s> <ins>Elegancia</ins><del>PERO SIN AMARILLO</del>  ipsum dolor sit amet consectetur adipisicing elit. Minus saepe officiis perspiciatis, quis expedita aliquid veniam vitae. At cum possimus quis odit sint veritatis, ipsa soluta voluptates aspernatur, ad similique.</p>
                    </aside>
            </section> -->
       </div>
       <div class="clearfix"></div>
<!-- Main, Login, Slogan -->
<!-- Footer -->
<footer >
    <div class="container">
        <H3>Make it simple</H3>
    </div>
    
</footer>
<!-- /Footer -->

    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>

