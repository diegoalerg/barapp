<?php
define("DOMAIN", "https://eventarioapp.com/public"); //modificar para entrar con el dominio eventarioapp.com sftp://bitnami@15.237.38.153/opt/bitnami/apache/htdocs/public
define("JS_SCRIPTS", "https://eventarioapp.com/app/scripts"); //sftp://bitnami@15.237.38.153/opt/bitnami/apache/htdocs/app/scripts

///ejercicioscipsa/BarTool/public

//directorio del proyecto
define("PROJECTPATH", dirname(__DIR__));
//directorio app
define("APPPATH", PROJECTPATH . '/App');

//funcion de autocarga
function autoLoad_classes($class_name)
{
        $filename= PROJECTPATH . '/' . str_replace('\\', '/', $class_name) . '.php';
        if (is_file($filename)) {
            include_once $filename;
        }
}
spl_autoload_register('autoload_classes');
//creacion del objeto enrutador y ejecucion del controlador
$app = new \Core\App;
$app->render();
?>