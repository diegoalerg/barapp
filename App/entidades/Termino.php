<?php
namespace App\Entidades;
defined("APPPATH") OR die("Accesss denied");

class Termino { //Permite instanciar objetos que llevan los datos de cada usuario de la capa modelo
                //a la capa vista y viceversa a traves de la capa controlador;
   public $id;
   public $usuario;
   public $termino;
   public $descripcion;
   public $multimedia;
   

    function __construct( $_id=null,$_usuario=null, $_termino, $_descripcion, $_multimedia=null) {
 
        $this->id= $_id;            
        $this->usuario= $_usuario;
        $this->termino= $_termino;
        $this->descripcion= $_descripcion;
        $this->multimedia= $_multimedia;
        
    }
}
?>