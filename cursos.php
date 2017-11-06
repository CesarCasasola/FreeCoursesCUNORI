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

  while($registroCurso  = $queryDocentes->fetch_array( MYSQLI_BOTH)){
    $docOptions = $docOptions.'<option value="'.$registroCurso['DPI_DOCENTE'].'">'.$registroCurso['NOMBRE'].' '.$registroCurso['APELLIDO'].'</option>';
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
    <title>Cursos</title>
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
    <script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery.clockinput.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript">
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    </script>


</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

      <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="#">Cursos Libres</a>
     </div>

      <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrar
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="areas.php">Áreas</a></li>
            <li><a href="agendaDocentes.php">Docentes</a></li>
            <li class="active"><a href="cursos.php">Cursos</a></li>
          </ul>
        </li>
        <li><a href="listados.php">Generar Listados</a></li>
        <li><a href="editarPrograma.php">Editar Programa</a></li>
        <li><a href="crearPrograma.php">Crear Nuevo Programa</a></li>
      </ul>
    </div>

  </div>
  </nav><br><br>

<div class="container">
<div>
  <h1 align="center">Administración de Cursos</h1><br>
</div>

<form method="post" id="main-form" action="insCurso.php">
  <fieldset>
  <legend>Agregar Curso</legend>

  <div class="form-group">
    <label for="nombre">Nombre del curso:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="80" oninvalid="this.setCustomValidity('Ingrese correctamente el nombre del curso. ')" oninput="setCustomValidity('')">
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
      <label class="checkbox-inline"> <input type="checkbox" id="necesitaP" name="necesitaP" value="1" onchange="habilitaP(this)"> <b>Necesita prerrequisito.</b> </label>
    </div>

    <label class="control-label col-sm-2" for="req">Descripción de prerrequisitos:</label>
      <div class="col-sm-6">
        <textarea class="form-control" id="req" name="req" cols="100" rows="2" disabled></textarea>
      </div>
  </div><br><br>


  <div class="form-group">
    <br><br><label class="control-label col-sm-1" for="dia">Día:</label>
    <div class="col-sm-3">
      <select class="form-control pick" id="dia" name="dia" required oninvalid="this.setCustomValidity('Seleccione el día en que se impartirá regularmente el curso.')" oninput="setCustomValidity('')">
        <option value="Domingo">Domingo</option>
        <option value="Lunes">Lunes</option>
        <option value="Martes">Martes</option>
        <option value="Miercoles">Miércoles</option>
        <option value="Jueves">Jueves</option>
        <option value="Viernes">Viernes</option>
        <option value="Sabado">Sábado</option>
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
    <label>Clase 6 [Opcional] <input type="text" class="form-control date" id="fecha6" name="fecha6" size="8" ></label>
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
            <th>Área</th>
            <th>Cupo</th>
            <th>Día</th>
            <th>Horario</th>
            <th>Docente(s)</th>
            <th>Prerrequisitos</th>
            <th>Fechas</th>
            <th>Editar</th>
          </tr>
          </thead>
          <tbody>
            <?php


            function cambiaf_a_esp($fecha){//funcion para cambiar fecha a formato dd-mm-YYYY
              $date = substr($fecha, 8, 2);
              $date = $date.'-'.substr($fecha, 5, 2);
              $date = $date.'-'.substr($fecha, 0, 4);
              return $date;
            }


              $dbserver = '127.0.0.1';
              $dbuser = 'root';
              $password = 'dbn0w';
              $dbname = 'cursos_libres';

              $database = new mysqli($dbserver, $dbuser, $password, $dbname);

              if($database->connect_errno) {
                die("No se pudo conectar a la base de datos");
              }else{
                $programaActivo = 0;
                $query="SELECT IDPROGRAMA FROM PROGRAMA WHERE ESTADO=1";
                $queryPrograma= $database->query($query);

                while($programa  = $queryPrograma->fetch_array( MYSQLI_BOTH)){
                  $programaActivo = $programa['IDPROGRAMA'];
                }

                $cursos="SELECT C.IDCURSO, C.IDPROGRAMA, A.NOMBRE AS NOMBRE_AREA, C.NOMBRE AS NOMBRE_CURSO, C.CUPO_LIMITE, C.DIA, C.IDAREA, C.HORAINICIO, C.HORAFIN, C.NECESITAPRERREQUISITOS, C.PRERREQUISITOS  FROM CURSO C INNER JOIN AREA A ON C.IDAREA=A.IDAREA WHERE IDPROGRAMA=".$programaActivo." order by C.NOMBRE ASC";
                $queryCursos= $database->query($cursos);

                while($registroCurso  = $queryCursos->fetch_array( MYSQLI_BOTH)){



                  //creacion del elemento para editar y ver docentes
                  $docOptions2 = $docOptions;
                  $qDoc = $database->query("SELECT D.NOMBRE, D.APELLIDO, D.DPI_DOCENTE FROM DOCENTE D INNER JOIN IMPARTIDO_POR I ON D.DPI_DOCENTE = I.DPI_DOCENTE WHERE I.IDCURSO = ".$registroCurso['IDCURSO']."");
                  while ($docCur = $qDoc->fetch_array( MYSQLI_BOTH )) {
                      $docOptions2 = $docOptions2.'<option value="'.$docCur['DPI_DOCENTE'].'" selected>'.$docCur['NOMBRE'].' '.$docCur['APELLIDO'].'</option>';
                  }

                  //creacion de elementos para ver y editar PRERREQUISITOS
                  $codEditaPre = '';
                  $colorBtn = '';
                  if ($registroCurso['NECESITAPRERREQUISITOS']) {
                    $codEditaPre = '<div class="modal-body form-group">
                                <div class="checkbox">
                                  <label> <input type="checkbox" id="necesitaP" name="necesitaP" value="1" onchange="habilitaPEdicion(this, '.$registroCurso['IDCURSO'].')" checked> <b>Necesita prerrequisito.</b> </label>
                                </div><br><br>

                                <label class="control-label" for="req">Descripción:</label><br>
                                  <div class="col-sm-2">
                                    <textarea class="form-control" id="reqEd-'.$registroCurso['IDCURSO'].'" name="reqEd" cols="50" rows="4">'.$registroCurso['PRERREQUISITOS'].'</textarea>
                                  </div>
                              </div>';
                      $colorBtn = "btn-primary";
                  }else {
                    $codEditaPre = '<div class="modal-body form-group">
                                <div class="checkbox">
                                  <label> <input type="checkbox" id="necesitaP" name="necesitaP" value="1" onchange="habilitaPEdicion(this, '.$registroCurso['IDCURSO'].')"> <b>Necesita prerrequisito.</b> </label>
                                </div><br><br>

                                <label class="control-label" for="req">Descripción:</label><br>
                                  <div class="col-sm-2">
                                    <textarea class="form-control" id="reqEd-'.$registroCurso['IDCURSO'].'" name="reqEd" cols="50" rows="4" disabled></textarea>
                                  </div>
                              </div>';
                      $colorBtn = 'btn-default';
                  }

                  //creacion de elemento para ver y editar fechas
                  $i=1;
                  $codEditaFechas = '';
                  $qFechas = $database->query("SELECT FECHA FROM FECHAS_CURSO WHERE IDCURSO = ".$registroCurso['IDCURSO']." ORDER BY FECHA");
                  while ($regFecha = $qFechas->fetch_array( MYSQLI_BOTH )) {
                      if ($i <= 4) {//fechas minimas obligatorias
                        $codEditaFechas = $codEditaFechas.'<div class="modal-body form-group">';
                        $codEditaFechas = $codEditaFechas.'<label>Clase '.$i.'  <input type="date" class="form-control" id="fecha-'.$i.'-'.$registroCurso['IDCURSO'].'" name="fecha'.$i.'" size="8" value="'.$regFecha['FECHA'].'" required></label>
                        </div><br>';
                      }else {
                        $codEditaFechas = $codEditaFechas.'<div class="modal-body form-group">';
                        $codEditaFechas = $codEditaFechas.'<label>Clase '.$i.' [Opcional]<input type="date" class="form-control" id="fecha-'.$i.'-'.$registroCurso['IDCURSO'].'" name="fecha'.$i.'" size="8" value="'.$regFecha['FECHA'].'"></label>
                        </div><br>';
                      }
                      $i++;
                  }

                  while ($i <= 6) {//si en la BD hay menos de 6 fechas, se debe agregar opcionales sin datos
                    $codEditaFechas = $codEditaFechas.'<div class="modal-body form-group">
                    <label>Clase '.$i.' [Opcional]<input type="date" class="form-control" id="fecha-'.$i.'-'.$registroCurso['IDCURSO'].'" name="fecha'.$i.'" size="8"></label>
                    </div><br>';
                    $i++;
                  }

                  $codEditaFechas = $codEditaFechas.' </div>';


                  echo '<tr id="line-'.$registroCurso['IDCURSO'].'">
                  <td>'.$registroCurso['NOMBRE_CURSO'].'</td>
                  <td>'.$registroCurso['NOMBRE_AREA'].'</td>
                  <td>'.$registroCurso['CUPO_LIMITE'].'</td>
                  <td>'.$registroCurso['DIA'].'</td>
                  <td>'.substr($registroCurso['HORAINICIO'], 0, 5).'-'.substr($registroCurso['HORAFIN'], 0, 5).'</td>

                  <td><button class="btn btn-success center-block" data-toggle="modal" data-target="#docentes-'.$registroCurso['IDCURSO'].'">Docente(s)</button>

                  <div class="modal fade" id="docentes-'.$registroCurso['IDCURSO'].'" tabindex="-1" role="dialog" aria-hidden="true"
                  aria-labelledby="docentesLabel-'.$registroCurso['IDCURSO'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="docentesLabel-'.$registroCurso['IDCURSO'].'">Docente(s) del curso: '.$registroCurso['NOMBRE_CURSO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upCurso.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroCurso['IDCURSO'].'"/>
                            <div class="form-group">
                              <label for="docentes[]">Docente(s):</label>
                              <select class="form-control pick col-sm-4" id="docente" name="docentes[]" multiple="multiple" style="width : 100%;" required>
                                '.$docOptions2.'
                              </select>
                            </div><br>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editDocentes" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>	</td>


                  <td><button class="btn '.$colorBtn.' center-block" data-toggle="modal" data-target="#prerrequisitos-'.$registroCurso['IDCURSO'].'">Prerrequisitos</button>

                  <div class="modal fade" id="prerrequisitos-'.$registroCurso['IDCURSO'].'" tabindex="-1" role="dialog"
                  aria-labelledby="prerrequisitosLabel-'.$registroCurso['IDCURSO'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="prerrequisitosLabel-'.$registroCurso['IDCURSO'].'">Prerrequisitos del curso: '.$registroCurso['NOMBRE_CURSO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upCurso.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroCurso['IDCURSO'].'"/>
                            '.$codEditaPre.'
                            <br><br><div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editPre" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div></td>


                  <td><button class="btn btn-info center-block" data-toggle="modal" data-target="#fechas-'.$registroCurso['IDCURSO'].'">Fechas</button>

                  <div class="modal fade" id="fechas-'.$registroCurso['IDCURSO'].'" tabindex="-1" role="dialog"
                  aria-labelledby="fechasLabel-'.$registroCurso['IDCURSO'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="fechasLabel-'.$registroCurso['IDCURSO'].'">Fechas del curso: '.$registroCurso['NOMBRE_CURSO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upCurso.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroCurso['IDCURSO'].'"/>
                            <h5 align="center">El formato de fecha es: mes - día - año <h5>
                            '.$codEditaFechas.'
                            <br><br><div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editFechas" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div></td>



                  <td><button class="btn btn-warning center-block" data-toggle="modal" data-target="#edit-'.$registroCurso['IDCURSO'].'">Editar</button>

                  <div class="modal fade" id="edit-'.$registroCurso['IDCURSO'].'" tabindex="-1" role="dialog"
                  aria-labelledby="editLabel-'.$registroCurso['IDCURSO'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="editLabel-'.$registroCurso['IDCURSO'].'">Editar</h4>
                        </div>
                        <form method="POST" action="upCurso.php">
                          <div class="modal-body">
                          <input type="hidden" name="id" value="'.$registroCurso['IDCURSO'].'"/>

                            <div class="form-group">
                            <label for=""nombre-'.$registroCurso['IDCURSO'].'"">Nombre:</label></br>
                            <input class="form-control center-block" required  name="nombre" id="nombre-'.$registroCurso['IDCURSO'].'" maxlength="80" oninvalid="this.setCustomValidity(\"Ingrese correctamente el nombre.\")" value="'.$registroCurso['NOMBRE_CURSO'].'">
                            </div><br><br>


                            <div class="form-group">
                            <label for=""area-'.$registroCurso['IDCURSO'].'"">Área:</label></br>
                            <select class="form-control pick" required  name="area" id="area-'.$registroCurso['IDCURSO'].'" style="width: 100%;" required>
                            <option value="'.$registroCurso['IDAREA'].'" selected>'.$registroCurso['NOMBRE_AREA'].'</option>
                            '.$areaOptions.'
                            </select>
                            </div><br><br>

                            <div class="form-group">
                            <label for=""cupo-'.$registroCurso['IDCURSO'].'"">Cupo:</label></br>
                            <input type="number" class="form-control" required  name="cupo" id="cupo-'.$registroCurso['IDCURSO'].'" value="'.$registroCurso['CUPO_LIMITE'].'">
                            </div><br><br>

                            <div class="form-group">
                            <label for=""dia-'.$registroCurso['IDCURSO'].'"">Día:</label></br>
                            <select class="form-control pick" required  name="dia" id="dia-'.$registroCurso['IDCURSO'].'" style="width: 100%;" required>
                            <option value="'.$registroCurso['DIA'].'" selected>'.$registroCurso['DIA'].'</option>
                            <option value="Domingo">Domingo</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miercoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sabado">Sábado</option>
                            </select>
                            </div><br><br>

                            <div class="form-group">
                            <label for=""hora1-'.$registroCurso['IDCURSO'].'"">Hora inicio:</label></br>
                            <input type="time" class="form-control" required  name="hora1" id="hora1-'.$registroCurso['IDCURSO'].'" value="'.$registroCurso['HORAINICIO'].'">
                            </div><br><br>

                            <div class="form-group">
                            <label for=""hora2-'.$registroCurso['IDCURSO'].'"">Hora fin:</label></br>
                            <input type="time" class="form-control" required  name="hora2" id="hora2-'.$registroCurso['IDCURSO'].'" value="'.$registroCurso['HORAFIN'].'">
                            </div><br><br>
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




</div>
</body>

<script type="text/javascript">
     $(document).ready(function(){
      $('#miTabla').dataTable();
      $('#hora1').clockInput();
      $('#hora2').clockInput();
      $('.pick').select2({
        maximumSelectionLength: 4,
      });
      $(".date").datepicker();

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

    function habilitaP(checkboxElem){
      if (checkboxElem.checked) {
            document.getElementById('req').disabled=false;
      }else{
            document.getElementById('req').value ="";
            document.getElementById('req').disabled=true;
      }
    }

    function habilitaPEdicion(checkboxElem, i){
      if (checkboxElem.checked) {
            document.getElementById('reqEd-'+i).disabled=false;
      }else{
            //document.getElementById('reqEd-'+i).value ="";
            document.getElementById('reqEd-'+i).disabled=true;
      }
    }

</script>
</html>
