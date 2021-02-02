<?php
namespace App\Controladores;
defined("APPPATH") OR die("Access denied");
use \Core\View;
use \App\modelos\Usuarios;
use \App\entidades\Usuario;
use \App\modelos\Terminos;
use \App\entidades\Termino;
use \App\modelos\InventariosFB;
use \App\entidades\Inventario;
use \App\entidades\Registro;
use \App\modelos\Registros;

//var_dump($_POST);
class ControlInventariosFB {
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
    function listar() //borrar
    {
        $users = Terminos::getAll();
        View::set("users", $users);
        View::render("listar");
    }
    
    /**
     * Solicitud de visualizacion de formulario de edicion
     * del termino con el nombre indicaado
     * URL: controladorTerminos/ver/<nombre>
     */
    function ver( $nombre) //borrar
    {
        $user = Terminos::getById($nombre);
        View::set("user", $user);
        View::render("detalle");
    }
    /**
     * Solicitud de visualizacion de formulario de alta de termino
     * URL: controladorTerminos/nuevo
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
     * Solicitud par autentificar que el termino y la clave agregados estan en la base de datos
     */
    
    function autentificar() {
        $nombre = filter_input(INPUT_POST, "nombre");
        $clave = filter_input(INPUT_POST,"clave");
        //Comprobacion de ususario existente?
        $termino_existente =Usuarios::getById($nombre);
        $clave_existente = Usuarios::getByClave($nombre,$clave);
        if ($termino_existente == NULL || $clave_existente == NULL) { //termino no existe DEBO VOLVER A MOSTRAR EL FORMULARIO CON MENSAJE DE ERROR
            //termino NO existe->ERROR.
            
                View::set("error", [
                    'mensaje'=> "termino o clave desconocido",
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
    
    /**
     * Elimina la sesion del termino y muestra el formulario de inicio de sesion mediante la plantilla login
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
     * Solicitud de actualizacion de CANTIDADES DE ITEMS por los datos enviados mediante post
     * Y muestra al termino lista actualizada de ITEMS
     * URL: controladorTerminos/actualizar
     */
    function actualizar() {
           // var_dump($_POST);
           
            //PUEDO CREAR QUE ME RECIBA EL USER LOCATION FECHA Y PDF Y ME INVOQUE EL MODELO QUE INSERTE LOS DATOS QUE LE PASO A LA BASE DE DATOS
            //HISTORIAL 
                $user_historial = $_POST['user_updateFB'];
                $location_historial = $_SESSION['location'];
                $date_historial = $_POST['date_updateFB'];
                $id = uniqid();
                $pdf_historial = $id; //A este valor debo indicarle agregarle el ID

              

                $registro_historial = new Registro($user_historial,$location_historial,$date_historial, $pdf_historial);
                Registros::insert($registro_historial);
           
            //Recibo items cantidades actuales nuevas desde desde vista
            $id_cantidades = $_POST['items'];
            $items_cantidades_actuales = filter_input(INPUT_POST, "items"); //NO FUNCIONA EL FILTER¡¡
            //var_dump($id_cantidades);

           //Consulta en la base de datos y actualizacion de cantidades de items 
           
            foreach ($id_cantidades as $key => $value) {
               // var_dump($id_cantidades);
                $inventario = new Inventario($key,null,null,$value,null,null,null,null);
//               var_dump($inventario);
                InventariosFB::update($inventario);
            }
               // $termino = new Termino($id, $termino, $descripcion);
               $location = $_SESSION['location'];
               //var_dump($location);
                $this->cantidad($location);
                //CREO EL ARCHIVO PDF EN EL SERVIDOR Y SU RUTA ES AGREGADA A LA BASE DE DATOS

                //  CREO EL ARCHIVO PDF Y LO CREA EN EL DIRECTORIO///////////////////// //INTENTAR ELIMINAR
                // if (isset($_POST['pdf_updateFB'])) {
                //     if (!isset($idpdf)){
                //         $idpdf = 0;
                //     } else {
                //             $idpdf++;
                //     }
                // }
                $this->PDFact($id,$user_historial);
           //$this->PDF(0);


          // $this->PDFmuestra($idpdf);
    }
    /**
     * Genera el pdf de la ultima actualizacion
     * Desde la vista el link Generar archivo PDF
     */
    function PDFlast()
    {
        $usuario= $_GET['usuario'];
        $items = InventariosFB::getById($usuario);
        $test = 'test'; //Mantengo el test para futuras mejoras como fecha o usuario 


       // var_dump($items);

       View::set("data", [
        'items'=> $items,
        'test'=>$test]);
        View::render("pdflast");

        //Crear el archivo pdf en un fichero en el servidor para la tabla de ultimas modificaciones.

     
    }
     /**
     * Crea el archivo en la carpeta registros
     * 
     */
    function PDFact($id,$user_historial)
    {
        //$usuario = $_GET['usuario'];
        $items = InventariosFB::getById($user_historial);
        $test = 'test'; //Mantengo el test para futuras mejoras como fecha o usuario 


       // var_dump($items);

       View::set("data", [
        'items'=> $items,
        'test'=>$test,
        'id'=>$id]);
        View::render("pdfact"); //EL IDPDF NO DEJA NUNCA DE SER CERO

        //Crear el archivo pdf en un fichero en el servidor para la tabla de ultimas modificaciones.

     
    }
     /**
     * Genera el pdf desde la vista de historial
     */
    function PDFmuestra($idpdf) //LE PASO LA FECHA PARA EL NOMBRE DESDE ACTUALIZAR()
    {
        //echo 'hola';
        //var_dump($idpdf);
        $usuario = $_GET['usuario'];
        
        $items = InventariosFB::getById($usuario);
        $test = 'test'; //Mantengo el test para futuras mejoras como fecha o usuario 
        //Obtengo la fecha (id) para la busqueda

       // var_dump($items);
        //$id = urlencode($idpdf);
       View::set("data", [
        'items'=> $items,
        'id'=> $idpdf, //Creo que es mejor un id
        'test'=>$test]);
        View::render("pdfregistro");

        //Crear el archivo pdf en un fichero en el servidor para la tabla de ultimas modificaciones.

     
    }
    /**
     * Solicitud de eliminacion de termino con el nombre indicado mediante POST
     * URL: controladorTerminos/eliminar
     */
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
     * Genero la vista de glosario.php
     */
    function glosario() {

        View::render("glosario");

    
    }
    /**
     * Solicitud de terminos a la base de datos
     * Generando un JSON
     */
    function obtenerTerminos()
    {
        header('Content-Type: application/json; charset=utf-8');
        $termino = filter_input(INPUT_POST, "termino");

        $users = Terminos::getById($termino);

        $respuesta = json_encode($users);
        
        echo $respuesta;
    }
    /**
     * Agregar metodo para mostrar ubicacion.php y cantidades.php
     */
    function ubicacion() {


        $usuario = $_GET['usuario'];
        //Obtengo las ultimas modificaciones de los reportes

        $modificacionFB = Registros::getLastFB($usuario);
        $modificacionLR = Registros::getLastLR($usuario);

       
        
        View::set("modificacion", [
            'FB'=> $modificacionFB,
            'LR' => $modificacionLR]);

        View::render("ubicacion");

    
    }
    function cantidad($location) {
       // var_dump($location);
       $_SESSION['location']= $location;
        //global $location;
       // $items = InventariosFB::getAll();

        //View::set("items", $items);
        View::set("location", [
            'location'=> $location]);
        

        View::render("cantidad");

    
    }
    function obtenerItemsFB($usuario)
    {
        header('Content-Type: application/json; charset=utf-8');
        //$termino = filter_input(INPUT_POST, "termino");
        // echo 'test';
        // var_dump('test1');

        $users = InventariosFB::getById($usuario);

        $respuesta = json_encode($users);

        
        echo $respuesta;
    }
    function obtenerItemsLR()
    {
        header('Content-Type: application/json; charset=utf-8');
        //$termino = filter_input(INPUT_POST, "termino");

        $users = InventariosLR::getAll();

        $respuesta = json_encode($users);
        
        echo $respuesta;
    }
     /**
     * Agregar metodo para mostrar ubicacion.php y cantidades.php
     */
    function historial() {

        $usuario = $_GET['usuario'];

        $users = Registros::getByUser($usuario);

        $numero_registros = count($users);

        //var_dump($numero_registros);
        View::set("numero_registros", $numero_registros);

        View::render("historial");

    
    }
      
}
?>