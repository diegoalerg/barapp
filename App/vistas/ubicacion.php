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
  
    header("Location:".DOMAIN."/controlUsuarios/login");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Eventario </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">
    <link rel="stylesheet" href="<?php echo DOMAIN."/estilos.css"?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
    <!--<script src="bootstrap.bundle.min.js/ bootstrap.bundle.js"></script>-->
    <script>

    </script>
    
<body>
<!-- Nav Bar -->
<div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a href="<?=DOMAIN?>/controlTerminos/inicio" class="navbar-brand">
                    Eventario
                </a>
                <button class="navbar-toggler" data-target="#menu" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a href="<?=DOMAIN?>/controlTerminos/inicio" class="nav-link">Inicio</a></li>
                        <li class="navbar-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="desplegable">Inventario</a>
                            <div class="dropdown-menu"> 
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>"> Reporte</a>
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/historial?pagina=1&usuario=<?=$usuario?>"> Historial de Reporte</a>
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
    <div class="table-responsive">
            <div class="container">
                <br>
                <form action="" method="post">
                        <!-- Lista desplegable para seleccionar la ubicacion FALTA DEFINIR COMO ENVIO LA UBICACION SELECCIONADA PARA MOSTRARLA EN CANTIDAD-->
                            <div class="dropdown show">
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <h> Seleccione la ubicacion </h>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/cantidad/FrontBar">FrontBar</a>
                                            <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosLR/cantidad/LiquorRoom">LiquorRoom</a>
                                            
                                        </div>
                            </div>
                        <!-- / Lista desplegable para seleccionar la ubicacion-->
                        <p class="text-justify text-right">
                                <a href="<?=DOMAIN?>/controlTerminos/inicio">Volver al inicio</a>
                         </p>
                
                </form>
            
                <div>
                    <table class="table table-bordered table-hover" id="tbl_usuario">
                        <tr>
                            <th>Ubicacion</th><th>Ultima modificacion</th><th>Realizada por</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td> <a class="" href="<?=DOMAIN?>/controlInventariosFB/cantidad/FrontBar">FrontBar</a></td><td> <?php echo $modificacion['FB']->date_historial  ?> </td>
                                                                                                                                    <td><?php  echo $modificacion['FB']->user_historial  ?></td>
                            </tr>
                            <tr>
                                <td> <a class="" href="<?=DOMAIN?>/controlInventariosLR/cantidad/LiquorRoom">LiquorRoom</a></td><td> <?php echo $modificacion['LR']->date_historial ?>  </td>
                                                                                                                                <td> <?php echo $modificacion['LR']->user_historial ?> </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>  
            </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>