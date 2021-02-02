<?php
namespace Core;
defined("APPPATH") OR die("Access denied");
use \Core\App;

class Database //Unica clase que establece contacto directo con la base de datos
{
    private $_dbUser;
    private $_dbPassword;
    private $_dbHost;
    protected $_dbName;

    private $_connection;
    /*
        @desc instancia de la base de datos
        @var $_instance
        @access private
    */
    private static $_instance;
    /*
        instance singleton
        @return object class dtabase
    */
    static function instance()
    {
            if (!isset(self::$_instance)) {
                    $class = __CLASS__;
                    self::$_instance = new $class;
            }
            return self::$_instance;
    }
    private function __construct()
    {
            try {
                        //load from config/config.ini
                        $config = App::getConfig();
                        $this->_dbHost = $config["host"];
                        $this->_dbUser = $config["user"];
                        $this->_dbPassword = $config["password"];
                        $this->_dbName = $config["database"];
                        $this->_connection = new \PDO('mysql:host='.$this->_dbHost.'; dbname='.$this->_dbName, $this->_dbUser, $this->_dbPassword);
                        $this->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        $this->_connection->exec("SET CHARACTER SET utf8");

            } catch (\PDOException $e) {
                    print "Error!: " . $e->getMessage();
                    die();
            }
    }
    /*
    run
    @param type sql description
    @param aray args parametros de sustitucion
    @return PDOStatement
    */

    function run($sql, $args = [])
    {
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute($args);
        //Retorno de objeto PDOStatement
        return $stmt;
    }

    //RUN LIMIT
    function run_limit($sql, $args)
    {
        $this->_connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        /*
        $stmt = $this->_connection->prepare($sql);
        $stmt->bindParam(1, $iniciar, PDO::PARAM_INT);
        $stmt->bindParam(2, $registros_por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
        */
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute($args);
        //Retorno de objeto PDOStatement
        return $stmt;
    }
    /*
    @param unknown $method
    @param unknown $args
    @return mixed
    */
    static function __callStatic($method, $args)
    {
            //Ejecuta el metodo invocando los arguentos sobre el objeto pdo
            return call_user_func_array(array($this->_connection, $method), $args);
    }
}
?>