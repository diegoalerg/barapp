<?php
namespace App\Controladores;
defined("APPPATH") OR die("Access denied");
use \Core\View;
use \App\modelos\Usuarios;
use \App\entidades\Usuario;

class ControlUsuarios {
    /**
     * Solicitud de listado de todos los usuarios 
     * URL: controladorusuarios
     */
    function listar()
    {
        $users = Usuarios::getAll();
        View::set("users", $users);
        View::render("lista");
    }
    /**
     * Solicitud de visualizacion de formulario de edicion
     * del usuario con el nombre indicaado
     * URL: controladorusuarios/ver/<nombre>
     */
    function ver( $nombre)
    {
        $user = Usuarios::getById($nombre);
        View::set("user", $user);
        View::render("detalle");
    }
    /**
     * Solicitud de visualizacion de formulario de alta de usuario
     * URL: controladorusuarios/nuevo
     */
    function nuevo() {
        View::set("error", [
                            'mensaje'=>'',
                            'nombre'=>'',
                            'clave'=>'',
                            'administrador'=>0,
                            'activo' =>0 ]);
        View::render("nuevo");
    }
      /**
     * NUEVOS METODOS PARA EL EJERCICIO y la plantilla login
     * Muestra el formulario de inicio mediante la plantilla login
     */
    function login() {
        View::set("error", [
                            'mensaje'=> '',
                            'nombre'=> '',
                            'clave'=> '' ]);
        View::render("login");
    }
    /**
     * Solicitud par autentificar que el usuario y la clave agregados estan en la base de datos
     */
    function autentificar() {
        $nombre = filter_input(INPUT_POST, "nombre");
        $clave = filter_input(INPUT_POST,"clave");
        //Comprobacion de ususario existente?
        $usuario_existente =Usuarios::getById($nombre);
        $clave_existente = Usuarios::getByClave($clave);
        if ($usuario_existente == NULL || $clave_existente == NULL) {
            //Usuario no existe DEBO VOLVER A MOSTRAR EL FORMULARIO CON MENSAJE DE ERROR
            //Usuario NO existe->ERROR.
                View::set("error", [
                    'mensaje'=> "Usuario o clave desconocido",
                    'nombre' => $nombre,
                    'clave' => $clave ]);
                View::render("login");
        } else {
            //Usuario existe, almaceno el objeto app/entidades/usuario resultante en la sesion
            //y muestro lista de usuarios
            $usuario = new Usuario($nombre,$clave);
            $_SESSION['usuario'] = $usuario;
            $this->listar();
        }
    }
    /**
     * Elimina la sesion del usuario y muestra el formulario de inicio de sesion mediante la plantilla login
     */
    function cerrarsesion() {
           //session_destroy();
            View::set("error", [
                'mensaje'=> '',
                'nombre'=> '',
                'clave'=> '' ]);
            View::render("login");
    }
    /**
     * Solicitud de actualizacion de usuario por los datos enviados mediante post
     * Y muestra al usuario lista actualizada de usuarios
     * URL: controladorusuarios/actualizar
     */
    function actualizar() {
            $nombre = filter_input(INPUT_POST, "usuario");
            $clave = filter_input(INPUT_POST, "clave");
            $administrador = isset($_POST['administrador'])?1:0;
            $activo = isset($_POST['activo'])?1:0;
            $usuario = new Usuario($nombre, $clave, $administrador, $activo);
            Usuarios::update($usuario);
            $this->listar();
    }
    /**
     * Solicitud de eliminacion de usuario con el nombre indicado mediante POST
     * URL: controladorusuarios/eliminar
     */
    function eliminar() {
        $nombre = filter_input(INPUT_POST,"usuario");
        Usuarios::delete($nombre);
        $this->listar();
    }
    /**
     * Solicitud de insercion de usuario con los datos enviados mediante POST y se muestre lista actualziada de usuarios
     * En caso de usuario con nombre ya exitente, se muestra formulario con mensaje de error
     * URL: controladorusuarios/insertar
     */
    function insertar() {
        $nombre = filter_input(INPUT_POST, "usuario");
        $clave = filter_input(INPUT_POST,"clave");
        $administrador = isset($_POST['administrador'])?1:0;
        $activo = isset($_POST['activo'])?1:0;
        //Comprobacion de ususario existente?
        $usuario_existente =Usuarios::getById($nombre);
        if ($usuario_existente == NULL) {
            //Usuario no existe
            $nuevo_usuario= new Usuario($nombre, $clave, $administrador, $activo);
            Usuarios::insert($nuevo_usuario);
            $this->listar();
        } else {
            //Usuario ya existe->ERROR.
            View::set("error", [
                                'mensaje'=> "Usuario $nombre ya existe",
                                'nombre' => $nombre,
                                'clave' => $clave,
                                'administrador' => $administrador,
                                'activo' => $activo]);
            View::render("nuevo");
        }
    }
}
?>