<?php
namespace Core;
session_start();//PARA VERIFICAR EL INICIO DE SESION
defined("APPPATH") OR die("Accesss denied");
class App {
        private $_controller;
        private $_method = "index";
        private $_params = [];

        function getController() {
                return $this->_controller;
        }
        function getMethod(){
            return $this->_method;
        }
        function getParams() {
                return $this->_params;
        }

        const NAMESPACE_CONTROLLERS = "\App\controladores\\";
        const CONTROLLERS_PATH = "../App/controladores/";
        //[obtenemos la configuracion de la app] @return [array] [array con la config]

        static function getConfig() {
            return parse_ini_file(APPPATH . '/config/config.ini');
        }
        
        //[parseamos la url en trozos] @return [type] [description]

        function parseUrl() {
                if (isset($_GET["url"])) {
                        return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
                }
        }

        function __construct() { //El constructor obtiene el url y lo descompone
            //obtenemos la url parseada
            $url = $this->parseUrl();
            //controlador y accion por defecto
            if ($url == null) {
                $url[0] = "controlUsuarios";
                $url[1] = "login";
            }

           
            //comprobamos que exista el archivo en el directorio controllers
            if (file_exists(self::CONTROLLERS_PATH.ucfirst($url[0]) . ".php"))
             {
                //nombre del archivo a llamar
                $this->_controller = ucfirst($url[0]);
                //eliminamos el controlador de url, asi solo nos quedaran el metodo
                unset($url[0]);
            } else {
                    include APPPATH . "/vistas/errores/404.php";
                    exit;
            }
            
            //obtenemos la clase con su espacio de nombres
            $fullClass = self::NAMESPACE_CONTROLLERS.$this->_controller;

            //asociamos la instancia a $this->_controller
            $this->_controller = new $fullClass;
            

            //so exoste el segundo segmento comprobamos que el metodo exista en esa clase
           
            if (isset($url[1])) {
                    //aqui tenemos el metodo
                    
                    $this->_method = $url[1];
                  
                    if (method_exists($this->_controller, $url[1])) { 
                                //eliminamos el metodo de url asi solo quedan los parametros del metodo
                            unset($url[1]);
                            } else {
                    throw new \Exception("Controlador: {$fullClass} Metodo: {$this->_method} Desconocido", 1);
                            }
            }
            //asociamos el resto de segmentos a $this->_params para pasarlis al metodo llamado.
            $this->_params = $url ? array_values($url) : [];

             //Existen datos del usuario en el estado de sesion?
                if (isset($_SESSION['usuario'])) {
                        $usuario = $_SESSION['usuario'];
                } else {
                        $url[0] = "controlUsuarios";
                        $url[1] = "login";
                        //header('Location: acceso.php');

                }
        }
        //render lanzamos le controllador/metodo que se ha llamado con los parametros
        function render() {
               
                
            call_user_func_array([$this->_controller, $this->_method], $this->_params);
        }
       
        

}
?>