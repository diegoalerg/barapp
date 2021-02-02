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
//ENVIO DE CORREO

if (isset($mail_contacto)) {
   
    $destino ='diegorodriguezgalindez@gmail.com';
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    $contenido = "Nombre: ". $nombre . "\nCorreo: ". $email ."\nTelefono: ". $numero ."\nMensaje: " . $mensaje;

    

    mail($destino, "Contacto", $contenido);

    

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
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>"> Hacer Reporte</a>
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
    <div class="container">
        <div class="col-md-6 mt-3 p-3 mb-2 bg-white text-dark">

        <h3>Pagina de contacto</h3>
        <p>¿Tiene alguna pregunta o consulta general? Rellene el siguiente formulario y nuestro equipo se pondrá en contacto.</p>
                <fieldset>

                    <form action="<?=DOMAIN?>/controlTerminos/email" method="post">
                    <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="" placeholder="Nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                            <label for="correo">Correo electronico</label>
                            <input type="email" class="form-control" id="" aria-describedby="" placeholder="Correo Electronico" name="email" required> 
                    </div>

                    <div class="form-group">
                            <label for="numero">Número de contacto</label>
                            <input type="text" class="form-control" id="" placeholder="Numero de contacto" name="numero" required>
                    </div>

                    <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea class="form-control" id="" rows="3" name="mensaje" required></textarea>
                    </div>
                       
                       
                        <button type="submit" class="btn btn-primary" >Enviar</button>
                    </form>

                </fieldset>

        </div>

            
    </div>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>