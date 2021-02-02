<?php
$destino ='diegorodriguezgalindez@gmail.com';
$nombre = $_POST['nombre'];
$numero = $_POST['numero'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

$contenido = "Nombre: ". $nombre . "\nCorreo: ". $email ."\nTelefono: ". $numero ."\nMensaje: " . $mensaje;

mail($destino, "Contacto", $contenido);

header("Location:".DOMAIN."/controlTerminos/contacto");


?>