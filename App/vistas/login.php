<?php
session_destroy();
session_start();
//var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimun-scale=1.0">
    <link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
        <div class="container">
            <div class="col-sm-12 mt-9">

                    <h1>AUTENTIFICACION</h1>
                    <br>
                    <h2 style= 'background-color: #ff0000'><?= $error['mensaje'] ?></h2>
                    <form action="<?= DOMAIN?>/controlTerminos/autentificar" method='post'>
                        Usuario: <input type="text" name='nombre' value='<?= $error['nombre'] ?>'>
                        <br>
                        <br>
                        Clave: <input type="password" name="clave" value='<?= $error['clave'] ?>'><br>
                        <br>
                        <div class="form-group">
                            <input type="submit" value='registrar' class="btn btn-info">
                        </div>
                    </form>
            </div>
         </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>