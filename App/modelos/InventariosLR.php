<?php
namespace App\Modelos;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\entidades\Inventario;
use \App\interfaces\Crud;


//CLASE PARA INVENTARIO DEL LIQUOR ROOM--------------------------------------------------------------------------------------------------


class InventariosLR implements Crud
{
    static function getAll()
    {
        $inventarios = array();
        try {
                $db= Database::instance();
                $sql = "SELECT * from liquor_room";
                $query = $db->run($sql);
                //Bucle de obtencion de resultados
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto inventario por cada registro y agregado a matriz resultados
                        array_push($inventarios, new Inventario($reg['idp'],
                                                           $reg['item'],
                                                           $reg['cantidad_actual'],
                                                           $reg['cantidad_minima_dia'],
                                                           $reg['cantidad_minima_semana'],
                                                           $reg['tipo'],
                                                           $reg['precio'] ));
                }
                return $inventarios;
        } catch(\PDOException $e) {
                PRINT "Error!: " . $e->getMessage();
        }
    }
    
//     static function getById($inventario) { 
//         $inventarios = array();
        
//         try {
//                 // HE PROBADO MAS DE 3 MANERAS DE HACERLO

//                 $db = Database::instance();
//                 $sql = "SELECT id, item, cantidad_actual, cantidad_minima_dia, cantidad_minima_semana FROM liquor_room WHERE item LIKE :item";
//                 $query = $db->run($sql, [':item' =>"%$item%"]);
//                 //$reg = $query->fetchAll();
                
//                 while ( $reg = $query->fetch() ) {
//                         //Creacion de objeto Termino por cada registro y agregado a matriz resultados
//                         array_push($inventarios, new Inventario($reg['id'],
//                                                             $reg['item'],
//                                                             $reg['cantidad_actual'],
//                                                             $reg['cantidad_minima_dia'],
//                                                             $reg['cantidad_minima_semana']));
//                 }
//                 //var_dump($inventarios);
//                 return $inventarios;
       
             
//         } catch(\PDOException $e) {
                        
//                     print "Error!: " . $e->getMessage();
//         }
//     }
static function getById($usuario) { //MODIFICADO TIPO HOME.PHP DEL EJERCICIO AJAX. DUDA DE COMO FUNCIONA EL $.POST() CON MVC
        $inventarios = array();
        
        try {
                // HE PROBADO MAS DE 3 MANERAS DE HACERLO

                $db = Database::instance();
                $sql = "SELECT * from liquor_room WHERE usuario LIKE :usuario";
                $query = $db->run($sql, [':usuario' =>"$usuario"]);
                //$reg = $query->fetchAll();
                
                while ( $reg = $query->fetch() ) {
                        //Creacion de objeto Inventario por cada registro y agregado a matriz resultados
                        array_push($inventarios, new Inventario($reg['idp'],
                                                            $reg['usuario'],
                                                            $reg['item'],
                                                            $reg['cantidad_actual'],
                                                            $reg['cantidad_minima_dia'],
                                                            $reg['cantidad_minima_semana'],
                                                            $reg['precio'],
                                                            $reg['tipo']));
                }
                //var_dump($inventarios);
                return $inventarios;
                

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

    static function insert($item) //CAMBIAR AGREGAR CON UN BOTON DESDE LA VISTA
    {
        try {
                $db = Database::instance();
                $sql = "INSERT INTO liquor_room( item, cantidad_actual, cantidad_minima_dia, cantidad_minima_semana ) 
                        VALUES ( :item, :cantidad_actual, cantidad_minima_dia, cantidad_minima_semana)";
                $query = $db->run($sql, [ ':item' => $item,
                                            ':cantidad_actual' => $cantidad_actual,
                                            ':cantidad_minima_dia' => $cantidad_minima_dia,
                                            ':cantidad_minima_semana' => $cantidad_minima_semana]);
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function update($user) //FRONTBAR O ALMACEN
    { 
        try {
            //DEBO DECIDIR SI TRABAJO CON LA VARIABLE O CON EL OBJETO $USER!!!!!!!!!!!!!!!!!!!!!!!
            $db = Database::instance();
            $sql = "UPDATE liquor_room SET cantidad_actual = :cantidad_actual WHERE idp = :id";
            //foreach ($$user as $key => $value) {
                $query = $db->run($sql, [':id' => $user->idp,
                ':cantidad_actual' => $user->cantidad_actual ]);
            //}
        } catch(\PDOException $e) {
                print "Error!: " . $e->getMessage();
        }
    }

    static function delete($id) //TRABAJO CON EL ID
    {
            try {
                    $db = Database::instance();
                    $sql = "DELETE FROM liquor_room WHERE id = :id";
                    $query = $db->run($sql, [':id' => $id]);
            }
            catch(\PDOException $e)
            {
                print "Error!: " . $e->getMessage();
            }
    }
}
?>