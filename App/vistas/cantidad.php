<?php
//Inclusion de el usuario que le da click al boton en la variable $inventario

if (isset($_POST['user_updateFB'])) {
    $user_updateFB = $_POST['user_updateFB'];
    $date_updateFB = $_POST['date_updateFB'];
    $_SESSION['user_updateFB'] = $user_updateFB;
    $_SESSION['date_updateFB'] = $date_updateFB;
}

if (isset($_POST['user_updateLR'])) {
    $user_updateLR = $_POST['user_updateLR'];
    $date_updateLR = $_POST['date_updateLR'];
    $_SESSION['user_updateLR'] = $user_updateLR;
    $_SESSION['date_updateLR'] = $date_updateLR;
}

//Inicializacion del estado de sesion
if(!isset($_SESSION)){
        session_start();
    }
//Existen datos del usuario en el estado de sesion?

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
        
    
} else {
    echo 'volver a login';
  
    header("Location:".DOMAIN."/controlUsuarios/login");
}

//var_dump(DOMAIN);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Eventario </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">
    <link rel="stylesheet" href="<?php echo DOMAIN."/estilos.css"?>">
    <!-- Para los inconos -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  

    <!-- Accordion -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    
    <script>
           /*
        Util para eliminar item en vez de usuario
        $().ready(function() {
                        $('form').submit(function(e) {
                            var user = $(this).find('input:hidden').val();
                            var response = confirm("Desea eliminar usuario: " + user);
                            if ( !response) e.preventDefault(); 
                        });
                });

        */
        
        $().ready( function() {
            //Solicito la lista de items a la base de datos

            var termino = 'todo';
            //Recibo los items con sus cantidades
            
             <?php if ($location['location']== 'FrontBar'): ?> 
                 
                                  $.post('<?=DOMAIN?>/controlInventariosFB/obtenerItemsFB/<?=$usuario?>', { 'termino' : termino }, refrescar,'json').done(function( data, textStatus, jqXHR) {
                                          if (console && console.log) {
                                              //alert( "success ");
                                          console.log(data);
                                          }
                                      }).fail(function (jqXHR, textStatus, errorThrown) {
                                          if (console && console.log) {
                                              //alert("Error: " + textStatus);
                                              console.log(jqXHR);
                                              console.log(textStatus);
                                              //console.log(data);
                                              alert("Error: " + errorThrown);
                                          }   
                                      })
                                      .always(function() {
                                          //alert("finished");
                                      });
             <?php elseif ($location['location']== 'LiquorRoom'): ?>   

                                    $.post('<?=DOMAIN?>/controlInventariosLR/obtenerItemsLR/<?=$usuario?>', { 'termino' : termino }, refrescar,'json').done(function( data, textStatus, jqXHR) {
                                            if (console && console.log) {
                                                //alert( "success ");
                                              console.log(data);
                                            }
                                        }).fail(function (jqXHR, textStatus, errorThrown) {
                                            if (console && console.log) {
                                                //alert("Error: " + textStatus);
                                                alert("Error: " + errorThrown);
                                            }   
                                        })
                                        .always(function() {
                                            //alert("finished");
                                        });
               <?php endif ?> 
            
                    
        });
       
            //Crea la tabla con los datos recibidos
        function refrescar(info) {

           // info = jQuery.parseJSON( info );

          //  console.log(info);

                //Se ha devuelto una matriz?
                if (!$.isArray(info)) {
                    alert("Se produjo un error", ) 
                    return;
                }
           
            
            
            $(info).each( function( index, term) {

             // console.log(term.tipo);
                            //Para la tabla tipo be
                          //$(info).each( function( index, term) {
                      if (term.tipo == 'be') {

                                //Eliminar filas existentes
                                 // $('#tbl_be tbody tr').not(':first').remove();
            
                                  //Haciendo float las cantidades recibidas
                                  var cantidad_actual = parseFloat(term.cantidad_actual); 
                                  var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                  var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                  
                                  


                                if(cantidad_actual < cantidad_minima_dia) {
                                  color = 'red';
                                } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                  color = 'yellow';
                                } else if (cantidad_actual >= cantidad_minima_semana) {
                                  color = 'green';
                                }
                              

                                //Generacion de filas por cada item
                                $("#tbl_be tbody")
                                .append($('<tr>')
                                  .append($('<td>')
                                      .html(term.item))
                                  .append($('<td>')
                                          .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                  .append($('<td>')
                                      .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))  
                                      
                                );
                                //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                $("#tbl_be tr:last").remove();

                                }


                                //Para la tabla tipo li
                              //$(info).each( function( index, term) {
                          if (term.tipo == 'li') {

                                  //Eliminar filas existentes
                                  // $('#tbl_be tbody tr').not(':first').remove();

                                    //Haciendo float las cantidades recibidas
                                  var cantidad_actual = parseFloat(term.cantidad_actual); 
                                  var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                  var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                    //console.log(cantidad_actual);
                                    


                                  if(cantidad_actual < cantidad_minima_dia) {
                                    color = 'red';
                                  } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                    color = 'yellow';
                                  } else if (cantidad_actual >= cantidad_minima_semana) {
                                    color = 'green';
                                  }


                                  //Generacion de filas por cada item
                                  $("#tbl_li tbody")
                                  .append($('<tr>')
                                    .append($('<td>')
                                        .html(term.item))
                                    .append($('<td>')
                                            .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                    .append($('<td>')
                                        .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))        
                                  );
                                  //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                  $("#tbl_li tr:last").remove();

                                           }

              

                    //Para la tabla tipo mi

                    if (term.tipo == 'mi') {

                                      //Eliminar filas existentes
                                        //$('#tbl_mi tbody tr').not(':first').remove();
                                
                                        //Haciendo float las cantidades recibidas
                                        var cantidad_actual = parseFloat(term.cantidad_actual); 
                                        var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                        var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                        //console.log(cantidad_actual);
                                        


                                      if(cantidad_actual < cantidad_minima_dia) {
                                        color = 'red';
                                      } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                        color = 'yellow';
                                      } else if (cantidad_actual >= cantidad_minima_semana) {
                                        color = 'green';
                                      }



                                      //Generacion de filas por cada item
                                      $("#tbl_mi tbody")
                                      .append($('<tr>')
                                        .append($('<td>')
                                            .html(term.item))
                                        .append($('<td>')
                                                .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                        .append($('<td>')
                                            .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))        
                                      );
                                      //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                      $("#tbl_mi tr:last").remove();

                                      }

              //Para la tabla tipo vi

                                if (term.tipo == 'vi') {

                                  //Eliminar filas existentes
                                     // $('#tbl_vi tbody tr').not(':first').remove();
                            
                                      //Haciendo float las cantidades recibidas
                                      var cantidad_actual = parseFloat(term.cantidad_actual); 
                                      var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                      var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                    //console.log(cantidad_actual);
                                    
                                
                              
                                  if(cantidad_actual < cantidad_minima_dia) {
                                      color = 'red';
                                  } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                      color = 'yellow';
                                  } else if (cantidad_actual >= cantidad_minima_semana) {
                                      color = 'green';
                                  }

                                  
                                  //Generacion de filas por cada item
                                  $("#tbl_vi tbody")
                                  .append($('<tr>')
                                      .append($('<td>')
                                          .html(term.item))
                                      .append($('<td>')
                                              .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                      .append($('<td>')
                                          .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))        
                                  );
                                  //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                  $("#tbl_vi tr:last").remove();
                                
                                }

              //Para tipo ce

                              if (term.tipo == 'ce') {

                                        //Eliminar filas existentes
                                         // $('#tbl_ce tbody tr').not(':first').remove();
                                
                                          //Haciendo float las cantidades recibidas
                                          var cantidad_actual = parseFloat(term.cantidad_actual); 
                                          var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                          var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                          //console.log(cantidad_actual);
                                          


                                        if(cantidad_actual < cantidad_minima_dia) {
                                          color = 'red';
                                        } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                          color = 'yellow';
                                        } else if (cantidad_actual >= cantidad_minima_semana) {
                                          color = 'green';
                                        }


                                        //Generacion de filas por cada item
                                        $("#tbl_ce tbody")
                                        .append($('<tr>')
                                          .append($('<td>')
                                              .html(term.item))
                                          .append($('<td>')
                                                  .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                          .append($('<td>')
                                              .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))        
                                        );
                                        //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                        $("#tbl_ce tr:last").remove();

                                        }

              //Para tipo ex

                          if (term.tipo == 'ex') {

                                          //Eliminar filas existentes
                                          //  $('#tbl_ex tbody tr').not(':first').remove();
                                
                                            //Haciendo float las cantidades recibidas
                                            var cantidad_actual = parseFloat(term.cantidad_actual); 
                                            var cantidad_minima_dia = parseFloat(term.cantidad_minima_dia);
                                            var cantidad_minima_semana = parseFloat(term.cantidad_minima_semana);
                                            //console.log(cantidad_actual);
                                            


                                          if(cantidad_actual < cantidad_minima_dia) {
                                            color = 'red';
                                          } else if ( (cantidad_actual >= cantidad_minima_dia) && (cantidad_actual < (cantidad_minima_semana)) ) {
                                            color = 'yellow';
                                          } else if (cantidad_actual >= cantidad_minima_semana) {
                                            color = 'green';
                                          }


                                          //Generacion de filas por cada item
                                          $("#tbl_ex tbody")
                                          .append($('<tr>')
                                            .append($('<td>')
                                                .html(term.item))
                                            .append($('<td>')
                                                    .html('<span class="fa fa-glass" style="color: '+color+'"></span>'))
                                            .append($('<td>')
                                                .html('<input class="form-control quantity" min="0" step=".1" type="number" value="'+term.cantidad_actual+'" name="items['+term.idp+']">'))        
                                          );
                                          //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                                          $("#tbl_ex tr:last").remove();

                                          }
             
                
            });   
        }

        



    </script>
<body>
<!-- Nav Bar -->
<div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a href="<?=DOMAIN?>/controlTerminos/inicio" class="navbar-brand">
                    Eventario
                </a>
                <button class="navbar-toggler" data-target="#menu" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a href="<?=DOMAIN?>/controlTerminos/inicio" class="nav-link">Inicio</a></li>
                        <li class="navbar-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="desplegable">Inventario</a>
                            <div class="dropdown-menu"> 
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>"> Reporte</a>
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/historial?pagina=1&usuario=<?=$usuario?>"> Historial de Reporte</a>
                            </div>
                        </li>
                        <li class="navbar-item"><a href="<?=DOMAIN?>/controlTerminos/glosario" class="nav-link">Academia</a></li>
                        <li class="navbar-item"><a href="<?=DOMAIN?>/controlTerminos/contacto" class="nav-link">Contacto</a></li>
                    </ul>
                </div>
            </nav>
       </div>
       <div class="clearfix"></div>
<!-- /Nav Bar -->
  
<div class="table-responsive">
                <div class="container">
                          <br>
                          <h3><?= $location['location'] ?></h3> 
                      
                          <p class="text-justify text-right">
                              <a href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>">Volver a la ubicacion</a> /
                              <a href="<?=DOMAIN?>/controlTerminos/inicio">Volver al inicio</a> 
                          </p>

                          <?php if ($location['location']== 'FrontBar'): ?> 
                                    <!-- Envio datos del formulario al controlador/actualizar -->
                                        <form action="<?= DOMAIN?>/controlInventariosFB/actualizar" method='post' id='inventario'> 
                                              <!-- Envio el usuario logeado y la fecha de la modificacion-->
                                                  <input type="hidden" name="user_updateFB" value="<?php print($usuario)?>">
                                                  <input type="hidden" name="date_updateFB" value="<?php $lastupdated = date('Y-m-d G:i:s'); print($lastupdated)?>">


                      
                                                  <!-- Accordion -->
                                                  <div id="accordion">
                                                                            <div class="card"> <!-- Bebidas espirituosas -->
                                                                                      <div class="card-header" id="headingOne">
                                                                                        <h5 class="mb-0">
                                                                                          <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
                                                                                            Bebidas Espirituosas
                                                                                          </button>
                                                                                        </h5>
                                                                                      </div>

                                                                                      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                                                      <div class="card-body">
                                                                                          
                                                                                                                            <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                                                  <table class="table table-bordered table-hover" id="tbl_be"> 
                                                                                                                                            <tr>
                                                                                                                                                <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                                            </tr>
                                                                                                                                          <tbody>
                                                                                                                                              
                                                                                                                                          </tbody>
                                                                                                                                  </table>

                                                                                                    </div>  <!-- /card body -->
                                                                                      </div>  <!-- /collapse 1-->
                                                                            </div>  <!-- /card 1-->
                                                                            <div class="card"> <!-- card2 --> 
                                                                                          <div class="card-header" id="headingTwo">
                                                                                                <h5 class="mb-0">
                                                                                                  <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" type="button">
                                                                                                    Licores
                                                                                                  </button>
                                                                                                </h5>
                                                                                          </div>

                                                                                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                                                                    <div class="card-body">
                                                                                                                    <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                                    <table class="table table-bordered table-hover" id="tbl_li">
                                                                                                                                            
                                                                                                                                              
                                                                                                                                            <tr>
                                                                                                                                                <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                                            </tr>
                                                                                                                                            <tbody>
                                                                                                                                                
                                                                                                                                            </tbody>
                                                                                                                      </table>
                                                                                                        </div>  <!-- /card body -->
                                                                                          </div>  <!-- /collapse 1-->
                                                                            </div>  <!-- /card2-->


                                                                              <div class="card"> <!-- Mixers -->
                                                                                                <div class="card-header" id="headingThree">
                                                                                                  <h5 class="mb-0">
                                                                                                    <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" type="button">
                                                                                                    
                                                                                                    Mixers 
                                                                                                    </button>
                                                                                                  </h5>
                                                                                                </div>
                                                                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                                                                  <div class="card-body">
                                                                                                
                                                                                                  <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                        <table class="table table-bordered table-hover" id="tbl_mi">
                                                                                                      
                                                                                                        
                                                                                                            <tr>
                                                                                                                <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                            </tr>
                                                                                                            <tbody>
                                                                                                                
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        </div>  <!-- /card body -->
                                                                                                  </div>  <!-- /collapse 1-->
                                                                              </div>  <!-- /Mixers-->

                                                                              <div class="card"> <!-- Vinos -->

                                                                                            <div class="card-header" id="headingFour">
                                                                                              <h5 class="mb-0">
                                                                                                <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" type="button">
                                                                                                Vinos
                                                                                                </button>
                                                                                              </h5>
                                                                                            </div>
                                                                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">

                                                                                                        <div class="card-body">
                                                                                                              <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                                    <table class="table table-bordered table-hover" id="tbl_vi">
                                                                                                                  
                                                                                                                    
                                                                                                                        <tr>
                                                                                                                            <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                        </tr>
                                                                                                                        <tbody>
                                                                                                                            
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                        </div>  <!-- /card body -->
                                                                                              </div>  <!-- /collapse 4-->
                                                                              </div>  <!-- /Vinos-->


                                                                                  <div class="card"> <!-- Cervezas-->
                                                                                                <div class="card-header" id="headingFive">
                                                                                                  <h5 class="mb-0">
                                                                                                    <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" type="button">
                                                                                                      Cerveza
                                                                                                    </button>
                                                                                                  </h5>
                                                                                                </div>
                                                                                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                                                                                  <div class="card-body">
                                                                                                  
                                                                                      <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                            <table class="table table-bordered table-hover" id="tbl_ce">
                                                                                          
                                                                                            
                                                                                                <tr>
                                                                                                    <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                </tr>
                                                                                                <tbody>
                                                                                                    
                                                                                                </tbody>
                                                                                            </table>
                                                                                            </div>  <!-- /card body -->
                                                                                                  </div>  <!-- /collapse 1-->
                                                                                  </div>  <!-- /card2-->
                                                                                  <div class="card"> <!-- Extras -->
                                                                                                <div class="card-header" id="headingSix">
                                                                                                  <h5 class="mb-0">
                                                                                                    <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" type="button">
                                                                                                      Extras
                                                                                                    </button>
                                                                                                  </h5>
                                                                                                </div>
                                                                                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                                                                                            <div class="card-body">
                                                                  
                                                                                                        <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                              <table class="table table-bordered table-hover" id="tbl_ex">
                                                                                                            
                                                                                                              
                                                                                                                  <tr>
                                                                                                                      <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                  </tr>
                                                                                                                  <tbody>
                                                                                                                      
                                                                                                                  </tbody>
                                                                                                              </table>
                                                                                                              </div>  <!-- /card body -->
                                                                                                  </div>  <!-- /collapse 1-->
                                                                                    </div>  <!-- /card2-->

                                                                        <br>
                                                                              <!--Boton para enviar -->
                                                                              <div class="form-group text-justify text-center">
                                                                                        <input type="submit" class="btn btn-success" value="REGISTRAR" id="boton">
                                                                              </div>

                                                        </div> <!-- /Accordion -->
                                                                                                                
                                          </form>
                                                                                                                                                                                  
                          <?php elseif ($location['location']== 'LiquorRoom'): ?>   
                              <form action="<?= DOMAIN?>/controlInventariosLR/actualizar" method='post' id='inventario'> 
                                      <input type="hidden" name="user_updateLR" value="<?php print($usuario)?>">
                                      <input type="hidden" name="date_updateLR" value="<?php $lastupdated = date('Y-m-d G:i:s'); print($lastupdated)?>">

                                       <!-- Accordion -->
                                       <div id="accordion">
                                                                      <div class="card"> <!-- Bebidas espirituosas -->
                                                                                <div class="card-header" id="headingOne">
                                                                                  <h5 class="mb-0">
                                                                                    <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
                                                                                      Bebidas Espirituosas
                                                                                    </button>
                                                                                  </h5>
                                                                                </div>

                                                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                                                <div class="card-body">
                                                                                    
                                                                                                                      <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                                            <table class="table table-bordered table-hover" id="tbl_be"> 
                                                                                                                                      <tr>
                                                                                                                                          <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                                      </tr>
                                                                                                                                    <tbody>
                                                                                                                                        
                                                                                                                                    </tbody>
                                                                                                                            </table>

                                                                                              </div>  <!-- /card body -->
                                                                                </div>  <!-- /collapse 1-->
                                                                      </div>  <!-- /card 1-->
                                                                      <div class="card"> <!-- card2 --> 
                                                                                    <div class="card-header" id="headingTwo">
                                                                                          <h5 class="mb-0">
                                                                                            <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" type="button">
                                                                                              Licores
                                                                                            </button>
                                                                                          </h5>
                                                                                    </div>

                                                                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                                                              <div class="card-body">
                                                                                                              <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                              <table class="table table-bordered table-hover" id="tbl_li">
                                                                                                                                      
                                                                                                                                        
                                                                                                                                      <tr>
                                                                                                                                          <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                                      </tr>
                                                                                                                                      <tbody>
                                                                                                                                          
                                                                                                                                      </tbody>
                                                                                                                 </table>
                                                                                                  </div>  <!-- /card body -->
                                                                                    </div>  <!-- /collapse 1-->
                                                                      </div>  <!-- /card2-->


                                                                        <div class="card"> <!-- Mixers -->
                                                                                          <div class="card-header" id="headingThree">
                                                                                            <h5 class="mb-0">
                                                                                              <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" type="button">
                                                                                              
                                                                                              Mixers 
                                                                                              </button>
                                                                                            </h5>
                                                                                          </div>
                                                                                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                                                            <div class="card-body">
                                                                                          
                                                                                            <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                  <table class="table table-bordered table-hover" id="tbl_mi">
                                                                                                
                                                                                                  
                                                                                                      <tr>
                                                                                                          <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                      </tr>
                                                                                                      <tbody>
                                                                                                          
                                                                                                      </tbody>
                                                                                                  </table>
                                                                                                  </div>  <!-- /card body -->
                                                                                            </div>  <!-- /collapse 1-->
                                                                        </div>  <!-- /Mixers-->

                                                                        <div class="card"> <!-- Vinos -->

                                                                                      <div class="card-header" id="headingFour">
                                                                                        <h5 class="mb-0">
                                                                                          <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" type="button">
                                                                                          Vinos
                                                                                          </button>
                                                                                        </h5>
                                                                                      </div>
                                                                                      <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">

                                                                                                  <div class="card-body">
                                                                                                        <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                              <table class="table table-bordered table-hover" id="tbl_vi">
                                                                                                            
                                                                                                              
                                                                                                                  <tr>
                                                                                                                      <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                                  </tr>
                                                                                                                  <tbody>
                                                                                                                      
                                                                                                                  </tbody>
                                                                                                              </table>
                                                                                                  </div>  <!-- /card body -->
                                                                                        </div>  <!-- /collapse 4-->
                                                                        </div>  <!-- /Vinos-->


                                                                            <div class="card"> <!-- Cervezas-->
                                                                                          <div class="card-header" id="headingFive">
                                                                                            <h5 class="mb-0">
                                                                                              <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" type="button">
                                                                                                Cerveza
                                                                                              </button>
                                                                                            </h5>
                                                                                          </div>
                                                                                          <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                                                                            <div class="card-body">
                                                                                            
                                                                                <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                      <table class="table table-bordered table-hover" id="tbl_ce">
                                                                                    
                                                                                      
                                                                                          <tr>
                                                                                              <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                          </tr>
                                                                                          <tbody>
                                                                                              
                                                                                          </tbody>
                                                                                      </table>
                                                                                      </div>  <!-- /card body -->
                                                                                            </div>  <!-- /collapse 1-->
                                                                            </div>  <!-- /card2-->
                                                                            <div class="card"> <!-- Extras -->
                                                                                          <div class="card-header" id="headingSix">
                                                                                            <h5 class="mb-0">
                                                                                              <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" type="button">
                                                                                                Extras
                                                                                              </button>
                                                                                            </h5>
                                                                                          </div>
                                                                                          <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                                                                                      <div class="card-body">
                                                             
                                                                                                  <!-- Genero tabla a mostrar en el registros, con cada campo -->
                                                                                                        <table class="table table-bordered table-hover" id="tbl_ex">
                                                                                                      
                                                                                                        
                                                                                                            <tr>
                                                                                                                <th>Item </th><th>Estado</th><th>Cantidad actual</th>
                                                                                                            </tr>
                                                                                                            <tbody>
                                                                                                                
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        </div>  <!-- /card body -->
                                                                                            </div>  <!-- /collapse 1-->
                                                                              </div>  <!-- /card2-->
                                                      <br>
                                                                         <!--Boton para enviar -->
                                                                         <div class="form-group text-justify text-center">
                                                                                   <input type="submit" class="btn btn-success" value="REGISTRAR" id="boton">
                                                                        </div>

                                          </div> <!-- /Accordion -->
                                                                                                          
                                     </form>


                              
                                                                      <?php endif ?> 

                  </div>  <!-- /container -->                        
            </div>    <!-- /table-responsive -->   
             
   <div class="container">
            <!-- Dentro de container -->


                  <!-- Link PDF -->
             <p class="text-justify text-right">
                         <?php if ($location['location']== 'FrontBar'): ?>                                
                                      <a href="<?=DOMAIN?>/controlInventariosFB/PDFlast?usuario=<?=$usuario?>">Generar archivo PDF</a>   
                         <?php elseif ($location['location']== 'LiquorRoom'): ?>  
                                     <a href="<?=DOMAIN?>/controlInventariosLR/PDFlast?usuario=<?=$usuario?>">Generar archivo PDF</a> 
                          <?php endif ?>  
              </p>
      </div>
      <div class="container">
              <p class="text-justify text-left">
              <a href="<?=DOMAIN?>/controlInventariosFB/PDFlast">Parametrizar Eventario</a> <!-- Solo el admin Y en un boton!--> 
              </p>
            <!-- /Dentro de container -->
             </div>
           
    </div>
    <!-- Dentro de bdy-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>