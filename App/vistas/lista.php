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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="<?= JS_SCRIPTS?>/jquery-3.0.0.min.js"></script>
        <script>
                $().ready(function() {
                        $('form').submit(function(e) {
                            var user = $(this).find('input:hidden').val();
                            var response = confirm("Desea eliminar usuario: " + user);
                            if ( !response) e.preventDefault(); 
                        });
                });
        </script>
</head>
<body>
        <h1>LISTADO DE USUARIOS</h1>
        <a href="<?=DOMAIN?>/controlUsuarios/cerrarsesion">Cerrar sesion</a> <br>
        <a href="<?=DOMAIN?>/controlUsuarios/nuevo">Insertar nuevo usuario</a> <br>
        <table border='1' class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Clave</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {?>
                    <tr>
                        <td><a href="<?= DOMAIN?>/controlUsuarios/ver/<?=$user->nombre?>"><?=$user->nombre ?>
                        </a></td>
                        <td><?= $user->clave ?> </td>
                        <td>
                                <form action="<?=DOMAIN?>/ControlUsuarios/eliminar" method='post'>
                                        <input type="hidden" name='usuario' value='<?=$user->nombre?>'>
                                        <input type="submit" value='Eliminar'>
                                </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
        </table>
    
</body>
</html>