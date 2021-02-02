<?php
namespace App\Modelos;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\entidades\Registro;
use \App\interfaces\Crud;

class Registros implements Crud
{
    static function getAll()
    {
        $usuarios = array();
        try {
                $db= Database::instance();
                $sql = "SELECT * from historial ORDER BY fecha DESC";
                $query = $db->run($sql);
                //Bucle de obtencion de resultados
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Usuario por cada registro y agregado a matriz resultados
                        array_push($usuarios, new Registro($reg['ubicacion'],
                                                           $reg['fecha'],
                                                           $reg['usuario'],
                                                           $reg['archivo']));
                }
               // $total_registros = $query->rowCount();
                //var_dump($total_registros);
                //Cuento cuantos registros estoy enviando
               // $usuarios['rows']= count($usuarios);
                //var_dump($usuarios);
                return $usuarios;
        } catch(\PDOException $e) {
                PRINT "Error!: " . $e->getMessage();
        }
    }
    ///CREO COMO getAll pero para cada usuario
    static function getByUser($usuario)
    {
        $usuarios = array();
        try {
                $db= Database::instance();
                $sql = "SELECT * from historial WHERE usuario LIKE :usuario ORDER BY fecha DESC";
                $query = $db->run($sql, [':usuario' => $usuario]);
                //Bucle de obtencion de resultados
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Usuario por cada registro y agregado a matriz resultados
                        array_push($usuarios, new Registro($reg['usuario'],
                                                           $reg['ubicacion'],
                                                           $reg['fecha'],
                                                           $reg['archivo']));
                }
               // $total_registros = $query->rowCount();
                //var_dump($total_registros);
                //Cuento cuantos registros estoy enviando
               // $usuarios['rows']= count($usuarios);
                //var_dump($usuarios);
                return $usuarios;
        } catch(\PDOException $e) {
                PRINT "Error!: " . $e->getMessage();
        }
    }
    
    static function getById($id) {
        try {
                $db = Database::instance();
                $sql = "SELECT * from usuarios WHERE usuario LIKE :usuario";
                $query = $db->run($sql, [':usuario' => $id]);
                $reg = $query->fetch();
                return ( ($reg)?
                                //Retorno del objeto Usuario recuperado
                                new Usuario($reg['usuario'],
                                            $reg['clave'],
                                            $reg['administrador'],
                                            $reg['activo'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        }
    }
    //CREO UN GETBYClave PARA VERIFICAR QUE LA CLAVE COINCIDE
    static function getByClave($usuario,$clave) {
        try {
                $db = Database::instance();
                $sql = "SELECT * from usuarios WHERE clave LIKE :clave AND usuario LIKE :usuario";
                $query = $db->run($sql, [':clave' => $clave, ':usuario'=>$usuario]);
                $reg = $query->fetch();
                return ( ($reg)?
                                //Retorno del objeto Usuario recuperado
                                new Usuario($reg['usuario'],
                                            $reg['clave'],
                                            $reg['administrador'],
                                            $reg['activo'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        }
    }
    static function insert($user)
    {
        try {
                
                $db = Database::instance();
                $sql = "INSERT INTO historial( usuario, ubicacion, fecha, archivo) 
                        VALUES ( :usuario, :ubicacion, :fecha,:archivo)";
                $query = $db->run($sql, [  ':usuario' => $user->user_historial,
                                            ':ubicacion' => $user->location_historial,
                                            ':fecha' => $user->date_historial,
                                            ':archivo'=> $user->pdf_historial ]);
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function update($user)
    { //TUVE QUE CAMBIAR TIPO DE DATO DE ADMINISTRADOR Y ACTIVO EN LA BASE DE DATOS DE BIT A VARCHAR
        try {
            $db = Database::instance();
            $sql = "UPDATE usuarios SET clave = :clave,
                                        administrador = :admin,
                                        activo = :activo
                                        WHERE usuario = :usuario";
            $query = $db->run($sql, [':usuario' => $user->nombre,
                                        ':clave' => $user->clave,
                                        ':admin' => $user->administrador,
                                        ':activo' => $user->activo]);
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function delete($id)
    {
            try {
                    $db = Database::instance();
                    $sql = "DELETE FROM usuarios WHERE usuario = :usuario";
                    $query = $db->run($sql,[':usuario' => $id]);
            }
            catch(\PDOException $e)
            {
                print "Error!: " . $e->getMessage();
            }
    }
    //CREO PARA LA PAGINACION
    static function getByVariable($iniciar, $articulos_por_pagina, $usuario) {
        try {
                $registros_limit= array();
                $db = Database::instance();
                $sql = $sql= 'SELECT * from historial WHERE usuario LIKE :usuario ORDER BY fecha DESC LIMIT :iniciar, :narticulos';
                $query = $db->run_limit($sql,[':iniciar' => $iniciar, ':usuario' => $usuario, ':narticulos' => $articulos_por_pagina]);
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Usuario por cada registro y agregado a matriz resultados
                        array_push($registros_limit, new Registro($reg['usuario'],
                                                           $reg['ubicacion'],
                                                           $reg['fecha'],
                                                           $reg['archivo']));
                }
                return $registros_limit;
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        }
    }
    //OBTENGO LA ULTIMA MODIFICACION PARA EL FRONTBAR
    static function getLastFB($usuario) {
        try {
              
                $db = Database::instance();
                $sql = $sql= "SELECT * FROM historial WHERE (usuario LIKE :usuario) AND  (ubicacion= 'FrontBar') ORDER BY id DESC LIMIT 1";
                $query = $db->run($sql, [':usuario' => $usuario]);
                $reg = $query->fetch();
                return ( ($reg)?
                                //Retorno del objeto Usuario recuperado
                                new Registro($reg['usuario'],
                                            $reg['ubicacion'], 
                                            $reg['fecha'],
                                            $reg['archivo'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        } 
    }
    //OBTENGO LA ULTIMA MODIFICACION PARA EL LiquorRoom
    static function getLastLR($usuario) {
        try {
              
                $db = Database::instance();
                $sql = $sql= "SELECT * FROM historial WHERE (usuario LIKE :usuario) AND  (ubicacion= 'LiquorRoom') ORDER BY id DESC LIMIT 1";
                $query = $db->run($sql, [':usuario' => $usuario]);
                $reg = $query->fetch();
                return ( ($reg)?
                                //Retorno del objeto Usuario recuperado
                                new Registro($reg['usuario'],
                                            $reg['ubicacion'],
                                            $reg['fecha'],
                                            $reg['archivo'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        } 
    }
}
?>