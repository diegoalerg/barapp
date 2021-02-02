<?php
if (isset($data)) {

    if (!isset($idpdf)){
        $idpdf = 0;
    } else {
            $idpdf++;
    }


   // global $data;
    //var_dump($data);
   // var_dump($data["items"][0]->item);
    require('fpdf/fpdf.php');

    class PDF extends FPDF
    {
    
    //Cabecera de página
       function Header()
       {
        //Logo
       // $this->Image("leon.jpg" , 10 ,8, 35 , 38 , "JPG" ,"http://www.mipagina.com");
        //Arial bold 15
        $this->SetFont('Arial','B',15);
        //Movernos a la derecha
        $this->Cell(80);
        //Título
        $this->Cell(60,10,'Estado del Inventario',1,0,'C');
        //Salto de línea
        $this->Ln(20);
          
       }
       
       //Pie de página
       function Footer()
       {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
       }

       //Tabla simple
       function TablaSimple($header,$data)
       {
       // global $data;
        //var_dump($items);
        //Cabecera
       // foreach($header as $col)
       
        $this->Cell(100,7,"Item",1,0,'C',0);
        //$this->Ln();

        $this->Cell(30,7,"Estado",1);
        //$this->Ln();

        $this->Cell(55,7,"Cantidad Actual",1);
        $this->Ln();

        //CUERPO DE LA TABLA
       // $reportSubtitle = 

       // $reportSubtitle = iconv('UTF-8', 'windows-1252', $reportSubtitle);

       // $data["items"][$i]->cantidad_minima_dia
        
        for ($i=0; $i < count($data["items"]); $i++) { 
            //PRIMERA COLUMNA
            $this->Cell(100,7,$data["items"][$i]->item ,1);

            //SEGUNDA COLUMNA
              //Genero el indicador de color

              if($data["items"][$i]->cantidad_actual < $data["items"][$i]->cantidad_minima_dia) {
                $this->SetFillColor(255,0,0);
                $this->Cell(30,7,'',1,0,'C',1);
            } else if (($data["items"][$i]->cantidad_actual >= $data["items"][$i]->cantidad_minima_dia) && ($data["items"][$i]->cantidad_actual < $data["items"][$i]->cantidad_minima_semana) ) {
                 $this->SetFillColor(252,255,51);
                 $this->Cell(30,7,'',1,0,'C',1);
            } else if ($data["items"][$i]->cantidad_actual >= $data["items"][$i]->cantidad_minima_semana) {
                 $this->SetFillColor(0,255,0);
                 $this->Cell(30,7,'',1,0,'C',1);
            }

            //$this->SetFillColor(252,255,51);
            //$this->Cell(30,5,'hola',1,0,'C',1);

            //TERCERA COLUMNA
            $this->Cell(55,7,$data["items"][$i]->cantidad_actual,1,0,'C',0);
            $this->Ln();
        }
        /*
          $this->Cell(60,5,$data["items"][0]->item ,1);
          $this->Cell(60,5,"hola2",1);
          $this->Cell(60,5,"hola3",1);
          
          $this->Ln();
          $this->Cell(60,5,"linea ",1);
          $this->Cell(60,5,"linea 2",1);
          $this->Cell(60,5,"linea 3",1);
      
          $this->Ln();
          $this->Cell(60,5,"hola",1);
          $this->Cell(60,5,"hola2",1);
          $this->Cell(60,5,"hola3",1);
          */
       }
      
    }
    
    $pdf=new PDF();
    //Títulos de las columnas
    $header=array('Item','Estado','Cantidad Actual');
    $pdf->AliasNbPages();
    //Primera página
    $pdf->AddPage();
    $pdf->SetY(65);
    //$pdf->AddPage();
    $pdf->TablaSimple($header,$data);
    //Segunda página
    //$pdf->AddPage();
    //$pdf->SetY(65);
    //$pdf->TablaColores($header);
    $pdf->Output(); //NO QUEREMOS MOSTRARLO
    //$pdf->Output('/opt/lampp/htdocs/ejercicioscipsa/BarTool/registros/test/'.$idpdf.'.pdf','F'); //LO ALMACENA EN EL SERVIDOR EN LA RUTA INDICADA
} else {
    echo 'No hay info';
}



?>