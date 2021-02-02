<?php
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

//Paginacion////////////////
if (!$_GET) {
    header('Location:'.DOMAIN.'/controlInventariosFB/historial?pagina=1');
}

$articulos_por_pagina = 8;

/**
 * DEBO CREAR UNA CONSULTA CON LIMIT https://www.youtube.com/watch?v=tRUg2fSLRJo min 6 HAGO LA CONSULTA EN EL MODELO
 */


//var_dump($numero_registros);
//echo $numero_registros;

$paginas = $numero_registros/$articulos_por_pagina;

$paginas = ceil($paginas);



$iniciar = (intval($_GET['pagina'])-1)*$articulos_por_pagina;




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Eventario </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">
    <link rel="stylesheet" href="<?php echo DOMAIN."/estilos.css"?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
    <script src="bootstrap.bundle.min.js/ bootstrap.bundle.js"></script>
    <script>

$().ready( function() {
            //Funcion que me envia el input a la base de datos glosario

            //Genero la consulta al controlador

            var termino = <?php echo $iniciar; ?>
            
            var articulos_por_pagina = <?php echo $articulos_por_pagina; ?>

                //console.log(termino)
                  $.post('<?=DOMAIN?>/controlTerminos/obtenerHistorialLimit/<?php print($usuario);?>', { 'termino' : termino, 'articulos_por_pagina' : articulos_por_pagina }, refrescar,'json').done(function( data, textStatus, jqXHR) {
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
                
            
          

            //Paginacion
            $('#tbl_usuario').DataTable();
            $('.dataTables_length').addClass('bs-select');
                    
        });
       
      
        function refrescar(info) {

           // info = jQuery.parseJSON( info );

            //console.log(info);

                //Se ha devuelto una matriz?
                if (!$.isArray(info)) {
                    alert("Se produjo un error", ) 
                    return;
                }

                //Necesito crear la ruta  /ejerciciocipsa/BarTool/public + /controlInventariosFB/PDF cambiar por /historial/
                //sudo chmod -R 777 /Users/macbookname/.bitnami/stackman/machines/xampp/volumes/root/htdocs/ejerciciocipsa/BarTool/registros
                
            //Eliminar filas existentes
            $('#tbl_usuario tbody tr').not(':first').remove();
            //Generacion de filas por cada usuario
            $(info).each( function( index, term) {
                console.log(term.pdf_historial)
                $("#tbl_usuario tbody")
                .append($('<tr>')
                    .append($('<td>')
                        .html(term.location_historial) )
                    .append($('<td>')
                        .html(term.date_historial)) 
                    .append($('<td>')
                        .html(term.user_historial)) 
                    .append($('<td>')
                        .html('<a href="<?=DOMAIN?>/controlInventariosFB/PDFmuestra/'+term.pdf_historial+'.pdf?usuario=<?php print($usuario)?>">Ver archivo PDF</a>'))   //Como le paso la fecha?
                );
                //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                $("#tbl_usuario tr:last").remove();
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
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/historial?pagina=1"> Historial de Reporte</a>
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
                <h4>Historial de modificaciones</h4>
            
                <div>
                    <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" id="tbl_usuario">
                        <tr>
                            <th>Ubicacion</th><th>Fecha de modificacion</th><th>Realizada por</th><th>Archivo</th>
                        </tr>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>  
                <!-- Paginacion -->
                <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item
                                    <?php echo intval($_GET['pagina'])<=1 ? 'disabled' : '' ?>
                                    "><a href="<?= DOMAIN?>/controlInventariosFB/historial?pagina=<?php print(intval($_GET['pagina']) - 1).'&usuario='.$usuario?>" class="page-link" >Anterior</a></li>

                                    <?php for ($i=0; $i < $paginas ; $i++): ?>
                                    <li class="page-item <?php print(intval($_GET['pagina'])== $i+1 ? 'active' : '')  ?>">
                                    <a href="<?=DOMAIN?>/controlInventariosFB/historial?pagina=<?php print( $i +1 ).'&usuario='.$usuario?>" class="page-link"><?php print($i +1)  ?></a>
                                    </li>
                                    <?php endfor ?>
                       

                                    <li class="page-item <?php print(intval($_GET['pagina'])>=$paginas? 'disabled' : '' ) ?>
                                    "><a href="<?= DOMAIN?>/controlInventariosFB/historial?pagina=<?php print(intval($_GET['pagina']) + 1).'&usuario='.$usuario  ?>" class="page-link">Siguiente</a></li>

                                </ul>
                </nav>
                <!-- Paginacion -->
            </div>
    </div>
    <script>
    $(document).ready(function () {
  $('#tbl_usuario').DataTable();
  $('.table').addClass('bs-select');
});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>