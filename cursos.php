<?php
$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

$database = new mysqli($dbserver, $dbuser, $password, $dbname);

if($database->connect_errno) {
  die("No se pudo conectar a la base de datos");
}else{
  $docOptions = '';
  $areaOptions = '';

  $docentes="SELECT NOMBRE, APELLIDO, DPI_DOCENTE FROM DOCENTE order by APELLIDO ASC, NOMBRE ASC";
  $queryDocentes= $database->query($docentes);

  while($registroDocente  = $queryDocentes->fetch_array( MYSQLI_BOTH)){
    $docOptions = $docOptions.'<option value="'.$registroDocente['DPI_DOCENTE'].'">'.$registroDocente['NOMBRE'].' '.$registroDocente['APELLIDO'].'</option>';
  }

  $areas="SELECT IDAREA, NOMBRE FROM AREA order by NOMBRE ASC";
  $queryAreas= $database->query($areas);

  while($registroArea  = $queryAreas->fetch_array( MYSQLI_BOTH)){
    $areaOptions = $areaOptions.' <option value="'.$registroArea['IDAREA'].'">'.$registroArea['NOMBRE'].'</option>';
  }
}
 ?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->

		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.clockinput.min.css">
    <link href="css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">


</head>

<body>
<div class="container">
<div>
  <h1 align="center">Administración de Cursos</h1>
</div>

<form method="post" id="main-form" action="insDocente.php">
  <fieldset>
  <legend>Agregar Curso</legend>

  <div class="form-group">
    <label for="nombre">Nombre del curso:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="50" oninvalid="this.setCustomValidity('Ingrese correctamente el nombre del curso. ')" oninput="setCustomValidity('')">
  </div><br>


  <div class="form-group">
    <label class="control-label col-sm-1" for="area">Área:</label>
    <div class="col-sm-5">
      <select class="form-control pick" id="area" name="area" required oninvalid="this.setCustomValidity('Seleccione el área a la que pertenece el curso.')" oninput="setCustomValidity('')">
        <?php echo $areaOptions; ?>
      </select>
    </div>

    <label class="control-label col-sm-2" for="cupo">Cupo Límite:</label>
    <div class="col-sm-4">
      <input type="number" class="form-control" id="cupo" name="cupo" required  oninvalid="this.setCustomValidity('Ingrese correctamente el cupo del curso.')" oninput="setCustomValidity('')">
    </div>

  </div><br><br>


  <div class="form-group">
    <label for="docentes[]">Docente(s):</label>
    <select class="form-control pick" id="docente" name="docentes[]" multiple="multiple" required oninvalid="this.setCustomValidity('Seleccione el o los docentes que impartirán el curso.')" oninput="setCustomValidity('')">
      <?php echo $docOptions; ?>
    </select>
  </div><br>



  <div class="form-group">
    <div class="checkbox col-sm-4">
      <label class="checkbox-inline"> <input type="checkbox" id="necesitaP" name="necesitaP" value="1"> <b>Necesita prerrequisito.</b> </label>
    </div>

    <label class="control-label col-sm-2" for="req">Descripción de prerrequisitos:</label>
      <div class="col-sm-6">
        <textarea class="form-control" id="req" name="req" cols="100" rows="2"></textarea>
      </div>
  </div><br><br>


  <div class="form-group">
    <br><br><label class="control-label col-sm-1" for="dia">Día:</label>
    <div class="col-sm-3">
      <select class="form-control pick" id="dia" name="dia" required oninvalid="this.setCustomValidity('Seleccione el día en que se impartirá regularmente el curso.')" oninput="setCustomValidity('')">
        <option value="Domingo">Domingo</option>
        <option value="Lunes">Lunes</option>
        <option value="Martes">Martes</option>
        <option value="Miércoles">Miércoles</option>
        <option value="Jueves">Jueves</option>
        <option value="Viernes">Viernes</option>
        <option value="Sábado">Sábado</option>
      </select>
    </div>

    <label class="control-label col-sm-1" for="hora1">Hora inicio:</label>
    <div class="col-sm-3">
      <input class="clock" type="time" name="hora1" id="hora1" value="">
    </div>

    <label class="control-label col-sm-1" for="hora2">Hora fin:</label>
    <div class="col-sm-3">
      <input class="clock" type="time" name="hora2" id="hora2">
    </div>
  </div><br><br><br><br><br><br><br>

  <br><br><h5 align="center"><b>Fechas de las clases:</b></h5>

  <div class="form-group">
    <div class="col-sm-2">
    <label>Clase 1 <input type="text" class="form-control date" id="fecha1" name="fecha1" size="8" required></label>
    </div>

    <div class="col-sm-2">
    <label>Clase 2 <input type="text" class="form-control date" id="fecha2" name="fecha2" size="8" required></label>
    </div>

    <div class="col-sm-2">
    <label>Clase 3 <input type="text" class="form-control date" id="fecha3" name="fecha3" size="8" required></label>
    </div>

    <div class="col-sm-2">
    <label>Clase 4 <input type="text" class="form-control date" id="fecha4" name="fecha4" size="8" required></label>
    </div>

    <div class="col-sm-2">
    <label>Clase 5 [Opcional] <input type="text" class="form-control date" id="fecha5" name="fecha5" size="8" ></label>
    </div>

    <div class="col-sm-2">
    <label>Clase 6 [Opcional] <input type="text" class="form-control date" id="fecha6" name="fecha5" size="6" ></label>
    </div>

  </div><br><br>

<br><div class="form-group">
  <div class="col-sm-offset-6 col-sm-10">
    <input type="submit" name="insert" value="Aceptar" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form>


<div style="overflow-x:auto;">
			<table class="table table-active table-responsive table-bordered table-condensed table-striped" id="miTabla">

					<thead>
					<tr class="info">
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>DPI</th>
            <th>Profesión</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Experiencia Laboral</th>
            <th>Competencias</th>
            <th>Opciones</th>
          </tr>
          </thead>
          <tbody>
            <?php
              $dbserver = '127.0.0.1';
              $dbuser = 'root';
              $password = 'dbn0w';
              $dbname = 'cursos_libres';

              $database = new mysqli($dbserver, $dbuser, $password, $dbname);

              if($database->connect_errno) {
                die("No se pudo conectar a la base de datos");
              }else{
                $docentes="SELECT * FROM DOCENTE order by APELLIDO ASC, NOMBRE ASC";
                $queryDocentes= $database->query($docentes);

                while($registroDocente  = $queryDocentes->fetch_array( MYSQLI_BOTH)){
                  echo '<tr id="line-'.$registroDocente['DPI_DOCENTE'].'">
                  <td>'.$registroDocente['NOMBRE'].'</td>
                  <td>'.$registroDocente['APELLIDO'].'</td>
                  <td>'.$registroDocente['DPI_DOCENTE'].'</td>
                  <td>'.$registroDocente['PROFESION'].'</td>
                  <td>'.$registroDocente['TELEFONO'].'</td>
                  <td>'.$registroDocente['CORREO'].'</td>
                  <td><button class="btn btn-success" data-toggle="modal" data-target="#experiencia-'.$registroDocente['DPI_DOCENTE'].'">Experiencia</button>

                  <div class="modal fade" id="experiencia-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="experienciaLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="experienciaLabel-'.$registroDocente['DPI_DOCENTE'].'">Experiencia del docente: '.$registroDocente['NOMBRE'].'  '.$registroDocente['APELLIDO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Experiencia Laboral:
                            <textarea class="form-control" cols="50" rows="4" name="exp" maxlength="200">'.$registroDocente['EXPERIENCIALABORAL'].'</textarea>
                            </label>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editExperiencia" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>	</td>

                  <td><button class="btn btn-info" data-toggle="modal" data-target="#competencias-'.$registroDocente['DPI_DOCENTE'].'">Competencias</button>

                  <div class="modal fade" id="competencias-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="competenciasLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="competenciasLabel-'.$registroDocente['DPI_DOCENTE'].'">Competencias del docente: '.$registroDocente['NOMBRE'].'  '.$registroDocente['APELLIDO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Competencias:
                            <textarea class="form-control" cols="50" rows="4" name="competencias" maxlength="200">'.$registroDocente['COMPETENCIAS'].'</textarea>
                            </label>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editCompetencias" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div></td>

                  <td><button class="btn btn-warning" data-toggle="modal" data-target="#edit-'.$registroDocente['DPI_DOCENTE'].'">Editar</button>

                  <div class="modal fade" id="edit-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="editLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="editLabel-'.$registroDocente['DPI_DOCENTE'].'">Editar</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Nombre: </label><input class="form-control" required  name="nombre" id="nombre-'.$registroDocente['DPI_DOCENTE'].'" maxlength="15" oninvalid="this.setCustomValidity(\"Ingrese correctamente el nombre.\")" value="'.$registroDocente['NOMBRE'].'"/></br>
                            <label class"control-label col-sm-2">Apellido: </label><input class="form-control" required  name="apellido" id="apellido-'.$registroDocente['DPI_DOCENTE'].'" maxlength="15" oninvalid="this.setCustomValidity("Ingrese correctamente el apellido.")" value="'.$registroDocente['APELLIDO'].'"/></br>
                            <label class"control-label col-sm-2">DPI: </label><input type="number" class="form-control" required  name="dpi" id="dpi-'.$registroDocente['DPI_DOCENTE'].'" min="1000000000000" max="9999999999999"  oninvalid="this.setCustomValidity("Ingrese correctamente los 13 dígitos del CUI.")"  value="'.$registroDocente['DPI_DOCENTE'].'"/></br>
                            <label class"control-label col-sm-2">Correo: </label><input type="email" class="form-control" required  name="mail" id="mail-'.$registroDocente['DPI_DOCENTE'].'" maxlength="25" required oninvalid="this.setCustomValidity("Ingrese correctamente el correo electrónico.")" value="'.$registroDocente['CORREO'].'"/></br>
                            <label class"control-label col-sm-2">Teléfono: </label><input type="number" class="form-control" required  name="tel" id="tel-'.$registroDocente['DPI_DOCENTE'].'" min="1000000" max="99999999" oninvalid="this.setCustomValidity("Ingrese correctamente los 8 dígitos del número de teléfono.")" value="'.$registroDocente['TELEFONO'].'"/></br>
                            <label class"control-label col-sm-2">Profesión: </label><input class="form-control" required  name="profesion" id="profesion-'.$registroDocente['DPI_DOCENTE'].'" maxlength="25" oninvalid="this.setCustomValidity("Ingrese correctamente la profesion.")" value="'.$registroDocente['PROFESION'].'"/></br>
                          </div>
                          <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <input type="submit" name="edit" value="Actualizar" class="btn btn-primary"/>
                        </div>
                        </form>
                        </div>
                        </div>
                        </div>
                </td>';

                }
                mysqli_close($database);
              }
            ?>
          </tbody>
      </table>


    <script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery.clockinput.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>

</div>
</body>

<script type="text/javascript">
     $(document).ready(function(){
      $('#miTabla').dataTable();
      $('#hora1').clockInput();
      $('#hora2').clockInput();
      $('.pick').select2();
    });

    $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function () {
    $(".date").datepicker();
    });

</script>
</html>
