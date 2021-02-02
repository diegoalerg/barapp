<?php
namespace App\Controladores;
defined("APPPATH") OR die("Access denied");
use \Core\View;
use \App\modelos\Usuarios;
use \App\entidades\Usuario;
use \App\modelos\Terminos;//Glosario
use \App\entidades\Termino;//Glosario
use \App\entidades\Registro;//Historial
use \App\modelos\Registros;//Historial

//var_dump($_POST);
class ControlTerminos {
    /**
     * Solicitud de listado de todos los Terminos 
     * URL: controladorTerminos
     */
    function inicio() 
    {
        $users = Usuarios::getAll();
        View::set("users", $users);
        View::render("inicio");
    }
   
    
    function login() {
        View::set("error", [
                            'mensaje'=> '',
                            'nombre'=> '',
                            'clave'=> '' ]);
        View::render("login");
    }
    
    /**
     * Solicitud par autentificar que el termino y la clave agregados estan en la base de datos
     */
    
    function autentificar() {
        $nombre = filter_input(INPUT_POST, "nombre");
        $clave = filter_input(INPUT_POST,"clave");
        //Comprobacion de ususario existente?
        $termino_existente =Usuarios::getById($nombre);
        $clave_existente = Usuarios::getByClave($nombre,$clave);
        if ($termino_existente == NULL || $clave_existente == NULL) {
            //termino no existe DEBO VOLVER A MOSTRAR EL FORMULARIO CON MENSAJE DE ERROR
            //termino NO existe->ERROR.
                View::set("error", [
                    'mensaje'=> " Usuario o Clave desconocido",
                    'nombre' => $nombre,
                    'clave' => $clave ]);
                View::render("login");
        } else {
            //termino existe, almaceno el objeto app/entidades/termino resultante en la sesion
            //y muestro lista de Terminos
            $termino = new Usuario($nombre,$clave);
            $_SESSION['usuario'] = $nombre;
            $this->inicio();
        }
    }
    
    
    function actualizar() {
            $input_termino = filter_input(INPUT_POST, "termino");
            $input_descripcion = filter_input(INPUT_POST, "descripcion");
            $termino = new Termino($id, $termino, $descripcion);
            Terminos::update($termino);
            //$this->listar();
    }
    /**
     * Solicitud de eliminacion de termino con el nombre indicado mediante POST
     * URL: controladorTerminos/eliminar
     */
    /*                                                  SPB!!! UTIL PARA ELIMINAR DESDE LA APP!
    function eliminar() {
        $termino = filter_input(INPUT_POST,"termino");
        Terminos::delete($termino);
        $this->listar();
    }
    /**
     * Solicitud de insercion de termino con los datos enviados mediante POST y se muestre lista actualziada de Terminos
     * En caso de termino con nombre ya exitente, se muestra formulario con mensaje de error
     * URL: controladorTerminos/insertar
     */
    /*                                              SPB!!! UTIL PARA INSERTAR DESDE LA APP
    function insertar() {
        $termino = filter_input(INPUT_POST, "termino");
        $descripcion = filter_input(INPUT_POST,"descripcion");
        //Comprobacion de termino existente?
        $termino_existente =Terminos::getById($nombre);
        if ($termino_existente == NULL) {
            //termino no existe
            $nuevo_termino= new Termino($nombre, $clave, $administrador, $activo);
            Terminos::insert($nuevo_termino);
            $this->listar();
        } else {
            //termino ya existe->ERROR.
            View::set("error", [
                                'mensaje'=> "termino $nombre ya existe",
                                'termino' => $termino,
                                'descripcion' => $descripcion]);
            View::render("nuevo");
        }
    }
    
    /**
     * Genero la vista de contacto.php
     */
    function contacto() {

        View::render("contacto");

    
    }

    /**
     * Solicitud de terminos a la base de datos
     * Generando un JSON
     */
    function obtenerTerminos($usuario)
    {
        header('Content-Type: application/json; charset=utf-8');
        $termino = filter_input(INPUT_POST, "termino");
        //$usuario = filter_input(INPUT_POST, "usuario");

        //$GLOBALS['a'] = $termino;
         //var_dump($usuario);
         //var_dump($termino);
        //global $termino;

        $users = Terminos::getBytwo($termino,$usuario);

       // $nro_registros = count($users);
        
        //$_SESSION['nro_registros'] = $nro_registros;
        //Global $nro_registros;
        //$users['nro_registros'] = count($users);

        $respuesta = json_encode($users);
        
        echo $respuesta;
      
    }
    /**
     * Genero la vista de glosario.php
     */
    function glosario() {
        
        //var_dump($termino);
        //$this->obtenerTerminos();
      //  var_dump($_SESSION['nro_registros']);
      //$nro_registros = $_SESSION['nro_registros'];

      //View::set("numero_registros", $nro_registros);
        

        View::render("glosario");

    
    }
    /**
     * Genero la vista de glosario de todo el glosario desglozado
     */
    function glosarioCompleto() {
        
        
        $usuario = $_GET['usuario'];
       
     $lista_terminos = Terminos::getByUser($usuario);

     //$lista_terminos = json_encode($lista_terminos);
       
     $nro_registros = count($lista_terminos);

     View::set("terminos", [
        'lista_terminos'=> $lista_terminos,
        'nro_terminos'=> $nro_registros]);

      
        

        View::render("glosarioCompleto");

    
    }
    /**
     * Genero el Json donde estan todos los terminos con sus conceptos
     */
    function ObtenerglosarioCompleto() {
        header('Content-Type: application/json; charset=utf-8');
        $lista_terminos = Terminos::getAll();

        $respuesta = json_encode($lista_terminos);

        echo $respuesta;
   
       }
    /**
     * Solicitud de terminos a la base de datos PARA LA PAGINACION
     * Generando un JSON con los terminos de acuerdo a la busqueda
     */
    function obtenerTerminosLimit($usuario)
    {
       
        header('Content-Type: application/json; charset=utf-8');
       // $nro_registros = $_SESSION['nro_registros'];
        $articulos_por_pagina = filter_input(INPUT_POST, "articulos_por_pagina");
        $iniciar = filter_input(INPUT_POST, "iniciar");
        //$articulos_por_pagina = filter_input(INPUT_POST, "articulos_por_pagina");

        $users = Terminos::getByVariable($iniciar, $articulos_por_pagina,$usuario);
        
        $respuesta = json_encode($users);
        
        echo $respuesta;
        //return $respuesta;
        //var_dump($respuesta);
        //$this->glosario($respuesta);
    }
        /**
     * Solicitud de terminos a la base de datos
     * Generando un JSON
     */
    function obtenerHistorial()
    {
       
        header('Content-Type: application/json; charset=utf-8');
        $termino = filter_input(INPUT_POST, "termino");

        $users = Registros::getALL();
        
        $respuesta = json_encode($users);
        
        echo $respuesta;
        //return $respuesta;
        //var_dump($respuesta);
        //$this->glosario($respuesta);
    }
     /**
     * Solicitud de terminos a la base de datos PARA LA PAGINACION
     * Generando un JSON
     */
    function obtenerHistorialLimit($usuario)
    {
       
        header('Content-Type: application/json; charset=utf-8');
        $termino = filter_input(INPUT_POST, "termino");
        $articulos_por_pagina = filter_input(INPUT_POST, "articulos_por_pagina");

        $users = Registros::getByVariable($termino, $articulos_por_pagina, $usuario);
        
        $respuesta = json_encode($users);
        
        echo $respuesta;
        //return $respuesta;
        //var_dump($respuesta);
        //$this->glosario($respuesta);
    }
    /**
     * Solicitud de terminos a la base de datos PARA LA PAGINACION
     * Generando un JSON
     */
    function email()
    {
        $nombre = filter_input(INPUT_POST, "nombre");
        $email = filter_input(INPUT_POST, "email");
        $mensaje = filter_input(INPUT_POST, "mensaje");
        $numero = filter_input(INPUT_POST, "numero");

        View::set("mail_contacto", [
            'mensaje'=>$mensaje,
            'nombre'=>$nombre,
            'email'=>$email,
            'numero'=>$numero ]);

        View::render("contacto");

     
    }
  
}
?>