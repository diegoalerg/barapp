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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Eventario </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo DOMAIN."/css/bootstrap.min.css"?>">
    <link rel="stylesheet" href="<?php echo DOMAIN."/estilos.css"?>">
    <!-- CDN PAGINACION -->
    <link rel="stylesheet" href="cdn.datatables.net/plug-ins/1.10.21/pagination/input.js">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
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
            //Funcion que me envia el input a la base de datos glosario

            //Genero la consulta al controlador
            $("form").on("submit", function( event ) {
               event.preventDefault();
                //Validacion de campos. No deben estar vacios
                if (!$("input[name='termino']").val()) {
                    alert("Buscador vacio"); return; }
                    //Asignacion a un variable  de los campos de texto del formulario
                    var termino = $("input[name='termino']").val();
                    

                   
                    
                    //Envio de termino mediante post Y Obtencion actuales

                    

                    
                 
                  $.post('<?=DOMAIN?>/controlTerminos/obtenerTerminos/<?=$usuario?>', { 'termino' : termino }, refrescar,'json').done(function( data, textStatus, jqXHR) {
                        if (console && console.log) {
                            //alert( "success ");
                           console.log(data);
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        if (console && console.log) {
                            //alert("Error: " + textStatus);
                            alert("Error: " + errorThrown);
                            console.log(jqXHR);
                        }   
                    })
                    .always(function() {
                        //alert("finished");
                    });

                    

                
           })
            //Limpieza de campos
            $("input[name='termino']").val('');

            //Paginacion
            $('#tbl_usuario').DataTable();
            $('.dataTables_length').addClass('bs-select');
                    
        });
       
      
        function refrescar(info) {
          
          
                //Se ha devuelto una matriz?
                if (!$.isArray(info)) {
                    alert("Se produjo un error", ) 
                    return;
                }
            //Eliminar filas existentes
            $('#tbl_usuario tbody tr').not(':first').remove();
            //Generacion de filas por cada usuario
            $(info).each( function( index, term) {
                $("#tbl_usuario tbody")
                .append($('<tr>')
                    .append($('<td>')
                        .html(term.termino) )
                    .append($('<td>')
                        .html(term.descripcion))       
                );
                //SE ME GENERA UNA DOBLE TABLA POR ENDE APLICO ESTO
                $("#tbl_usuario tr:last").remove();
            });   
        }

    </script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.21/pagination/input.js"></script>
    
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
                                <a class="dropdown-item" href="<?=DOMAIN?>/controlInventariosFB/ubicacion?usuario=<?=$usuario?>"> Hacer Reporte</a>
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
<br>
    <div class="table-responsive">
            <div class="container">
                <h3>Glosario</h3>
              
                <div>
                    <form action="<?= DOMAIN?>/controlTerminos/glosario" method='post'>
                        <div class="form-group">
                        <p class="text-justify text-right">
                             <a href="<?=DOMAIN?>/controlTerminos/glosarioCompleto?pagina=1&usuario=<?=$usuario?>">Ver todo</a>
                        </p>
                            Concepto: <input type="text" class="form-control" name="termino"> 
                            
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="OBTENER" id="boton">
                        </div>
                    </form>
                </div>
                <div>
                    <table id="tbl_usuario" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <tr>
                            <th>Término</th><th>Descripción</th>
                        </tr>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>  
            </div>
    </div>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo DOMAIN.'/js/jquery.js'?>"> </script>
    <script src="<?php echo DOMAIN.'/js/bootstrap.min.js'?>"> </script> 
</body>
</html>