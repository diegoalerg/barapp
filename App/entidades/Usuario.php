<?php
namespace App\Entidades;
defined("APPPATH") OR die("Accesss denied");

class Usuario { //Permite instanciar objetos que llevan los datos de cada usuario de la capa modelo
                //a la capa vista y viceversa a traves de la capa controlador;
   public $nombre;
   public $clave;
   public $administrador;
   public $activo;

    function __construct($_nombre, $_clave, $_administrador=0, $_activo=0) {
        $this->nombre= $_nombre;
        $this->clave= $_clave;
        $this->administrador= $_administrador;
        $this->activo= $_activo;
        
    }
}
?>