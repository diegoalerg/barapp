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
    <h1>NUEVO USUARIO</h1>
    <h2 style='background-color: #ff0000'><?= $error['mensaje']?></h2>
    <form action="<?= DOMAIN?>/controlUsuarios/insertar/" method='post'>
        Usuario: <input type="text" name="usuario" value='<?= $error['nombre']?>' >
        Clave: <input type="text" name="clave" value='<?= $error['clave']?>'><br>
        Administrador: <input type="checkbox" name="administrador" 
                                <?=(($error['administrador']==1)?'checked':'')?>> <br>
        Activo: <input type="checkbox" name='activo'
                                <?=(($error['activo']==1)?'checked':'')?>> <br>
        <input type="submit" value="registrar">
    </form>
    <a href="<?= DOMAIN?>/controlUsuarios/listar"> Volver a lista usuarios</a>
</body>
</html>