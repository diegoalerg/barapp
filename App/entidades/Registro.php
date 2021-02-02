<?php
namespace App\Entidades;
defined("APPPATH") OR die("Accesss denied");

class Registro { //Permite instanciar objetos que llevan los datos de cada registro de la capa modelo
                //a la capa vista y viceversa a traves de la capa controlador;
   public $id;
   public $user_historial;
   public $location_historial;
   public $date_historial;
   public $pdf_historial;
   
        //Los hago null porque solo tomo id y cantidad actual
    function __construct(  $_user_historial, $_location_historial, $_date_historial, $_pdf_historial) {
        
        $this->user_historial= $_user_historial;
        $this->location_historial= $_location_historial;
        $this->date_historial= $_date_historial;
        $this->pdf_historial = $_pdf_historial;
        
    }
}
?>