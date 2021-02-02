<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

class View
{
        /**
         * var
         */
        protected static $data;

        const VIEWS_PATH = "../App/vistas/";

        const EXTENSION_TEMPLATES = "php";

        /**
         * Proyecta la pagina con el fichero de plantilla indicado y los datos reistrados de previo
         * @param [String] [template name]
         * @return [html] 
         */
        static function render($template)
        {
            if (!file_exists(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES))
            {
                    throw new \Exception("Error: El archivo " . self::VIEWS_PATH . $template . "." . 
                                        self::EXTENSION_TEMPLATES . "no existe", 1);
            }
            ob_start();
            if ( self::$data != NULL ) extract(self::$data);
            include(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);
            $str = ob_get_contents();
            ob_end_clean();
            echo $str;  
        }

        static function set($name, $value)
        {
            self::$data[$name] = $value;
        }
}
?>