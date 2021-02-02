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
</head>
<body>
    <h1>DETALLE USUARIO <?= $user->nombre ?></h1>
    <form action="<?= DOMAIN?>/controlUsuarios/actualizar/" method='post'>
        <input type="hidden" name='usuario' value='<?=$user->nombre?>'>
        Clave: <input type="text" name="clave" value='<?= $user->clave?>'> <br>
        Administrador: <input type="checkbox" name='administrador'
                                <?= (($user->administrador==1)?'checked':'') ?>><br>
        Activo: <input type="checkbox" name='activo'
                    <?= (($user->activo==1)?'checked':'') ?>><br>
        <input type="submit" value='modificar'>
    </form>
    <a href="<?= DOMAIN?>/controlUsuarios/listar"> Volver a lista usuarios</a>
</body>
</html>