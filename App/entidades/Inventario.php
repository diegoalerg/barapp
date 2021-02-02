<?php
namespace App\Entidades;
defined("APPPATH") OR die("Accesss denied");

class Inventario { //Permite instanciar objetos que llevan los datos de cada item de la capa modelo
                //a la capa vista y viceversa a traves de la capa controlador;
   public $idp;
   public $usuario;
   public $item;
   public $cantidad_actual;
   public $cantidad_minima_dia;
   public $cantidad_minima_semana;
   public $tipo;
   public $precio;
   
        //Los hago null porque solo tomo id y cantidad actual   /wut?
    function __construct( $_idp, $_usuario=null, $_item=null, $_cantidad_actual, $_cantidad_minima_dia=null, $_cantidad_minima_semana=null,$_precio=null,$_tipo=null) {
        
        $this->idp= $_idp;
        $this->usuario= $_usuario;
        $this->item= $_item;
        $this->cantidad_actual= $_cantidad_actual;
        $this->cantidad_minima_dia= $_cantidad_minima_dia;
        $this->cantidad_minima_semana= $_cantidad_minima_semana;
        $this->precio= $_precio;
        $this->tipo= $_tipo;
       
        
    }
}
?>