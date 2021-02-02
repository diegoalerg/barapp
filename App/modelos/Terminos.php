<?php
namespace App\Modelos;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\entidades\Termino;
use \App\interfaces\Crud;

class Terminos implements Crud
{
    static function getAll()
    {
        $terminos = array();
        try {
                $db= Database::instance();
                $sql = "SELECT * from glosario";
                $query = $db->run($sql);
                //Bucle de obtencion de resultados
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Termino por cada registro y agregado a matriz resultados
                        array_push($terminos, new Termino(  $reg['id'],
                                                                $reg['usuario'],
                                                                $reg['termino'], 
                                                                $reg['descripcion'],
                                                                $reg['multimedia']));
                }
                return $terminos;
        } catch(\PDOException $e) {
                PRINT "Error!: " . $e->getMessage();
        }
    }
    //CREO UN GETALLL PERO BY USER
    static function getByUser($usuario)
    {
        $terminos = array();
        try {
                $db= Database::instance();
                $sql = "SELECT * from glosario WHERE usuario LIKE :usuario";
                $query = $db->run($sql, [':usuario' =>"$usuario"]);
                //Bucle de obtencion de resultados
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Termino por cada registro y agregado a matriz resultados
                        array_push($terminos, new Termino( $reg['id'],
                                                        $reg['usuario'], 
                                                        $reg['termino'],
                                                        $reg['descripcion'],
                                                        $reg['multimedia']));

                                                           

                }
                return $terminos;
        } catch(\PDOException $e) {
                PRINT "Error!: " . $e->getMessage();
        }
    }
    
    static function getById($termino) { //MODIFICADO TIPO HOME.PHP DEL EJERCICIO AJAX. DUDA DE COMO FUNCIONA EL $.POST() CON MVC
        $terminos = array();
        
        try {
                // HE PROBADO MAS DE 3 MANERAS DE HACERLO

                $db = Database::instance();
                $sql = "SELECT termino, descripcion FROM glosario WHERE termino LIKE :termino AND usuario LIKE :usuario";
                $query = $db->run($sql, [':termino' =>"%$termino%"]);
                //$reg = $query->fetchAll();
                
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Termino por cada registro y agregado a matriz resultados
                        array_push($terminos, new Termino( $reg['termino'],
                                                           $reg['descripcion']));
                }
                //var_dump($terminos);
                return $terminos;
                

               // return $reg;
                
                
                /*
                return ( ($reg)?
                                //Retorno del objeto Termino recuperado
                               new Termino( $reg['termino'],
                                            $reg['descripcion'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
                                            */
             
        } catch(\PDOException $e) {
                        
                    print "Error!: " . $e->getMessage();
        }
    }
    //CREO PARA BUSCAR LOS TERMINOS DE ACUERDO AL USUARIO EN LA BASE DE DATOS
    static function getBytwo($termino,$usuario) { //MODIFICADO TIPO HOME.PHP DEL EJERCICIO AJAX. DUDA DE COMO FUNCIONA EL $.POST() CON MVC
        $terminos = array();
        
        try {
                // HE PROBADO MAS DE 3 MANERAS DE HACERLO

                $db = Database::instance();
                $sql = "SELECT * FROM glosario WHERE termino LIKE :termino AND usuario LIKE :usuario";
                $query = $db->run($sql, [':termino' =>"%$termino%", ':usuario' =>$usuario]);
                //$reg = $query->fetchAll();
                
                while ( $reg = $query->fetch() ) {
                        //var_dump($reg);
                        //Creacion de objeto Termino por cada registro y agregado a matriz resultados
                        array_push($terminos, new Termino(
                                                        $reg['id'],
                                                        $reg['usuario'],
                                                        $reg['termino'], 
                                                        $reg['descripcion'],
                                                        $reg['multimedia']));
                }
                //var_dump($terminos);
                return $terminos;
                

               // return $reg;
                
                
                /*
                return ( ($reg)?
                                //Retorno del objeto Termino recuperado
                               new Termino( $reg['termino'],
                                            $reg['descripcion'])
                                            //Retorno NULL si no se recupero ningun registro
                                            :NULL );
                                            */
             
        } catch(\PDOException $e) {
                        
                    print "Error!: " . $e->getMessage();
        }
    }
    //CREO UN GETBYClave PARA VERIFICAR QUE LA CLAVE COINCIDE
    /*
    static function getByClave($clave) {
        try {
                $db = Database::instance();
                $sql = "SELECT * from usuarios WHERE clave LIKE :clave";
                $query = $db->run($sql, [':clave' => $clave]);
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
    */
    static function insert($user) //CAMBIAR
    {
        try {
                $db = Database::instance();
                $sql = "INSERT INTO glosario( termino, descripcion ) 
                        VALUES ( :termino, :descripcion)";
                $query = $db->run($sql, [ ':termino' => $termino,
                                            ':descripcion' => $descripcion]);
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function update($user)
    { //TUVE QUE CAMBIAR TIPO DE DATO DE ADMINISTRADOR Y ACTIVO EN LA BASE DE DATOS DE BIT A VARCHAR
        try {
            //DEBO DECIDIR SI TRABAJO CON LA VARIABLE O CON EL OBJETO $USER!!!!!!!!!!!!!!!!!!!!!!!
            $db = Database::instance();
            $sql = "UPDATE glosario SET descripcion = :descripcion
                                        WHERE termino = :termino";
            $query = $db->run($sql, [':termino' => $user->termino,
                                        ':descripcion' => $user->descripcion]);
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function delete($id) //TRABAJO CON EL ID
    {
            try {
                    $db = Database::instance();
                    $sql = "DELETE FROM glosario WHERE id = :id";
                    $query = $db->run($sql, [':id' => $id]);
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
                $sql = $sql= 'SELECT * from glosario WHERE usuario LIKE :usuario LIMIT :iniciar, :narticulos';
                $query = $db->run_limit($sql,[':iniciar' => $iniciar, ':narticulos' => $articulos_por_pagina, ':usuario' => $usuario]);
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Usuario por cada registro y agregado a matriz resultados
                        array_push($registros_limit, new Termino( $reg['id'],
                                                        $reg['usuario'], 
                                                        $reg['termino'],
                                                        $reg['descripcion'],
                                                        $reg['multimedia']));

                }
                return $registros_limit;
        } catch(\PDOException $e) {
                    print "Error!: " . $e->getMessage();
        }
    }
}
?>