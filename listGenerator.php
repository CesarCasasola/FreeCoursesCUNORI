<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">-->


<?php

$idCurso = filter_input(INPUT_POST, "idCurso", FILTER_VALIDATE_INT);

if ($idCurso) {

  $dbserver = '127.0.0.1';
  $dbuser = 'root';
  $password = 'dbn0w';
  $dbname = 'cursos_libres';

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);

  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{

    $docentes = $database->query("SELECT D.NOMBRE, D.APELLIDO FROM IMPARTIDO_POR I INNER JOIN DOCENTE D ON I.DPI_DOCENTE = D.DPI_DOCENTE WHERE I.IDCURSO=$idCurso");

    $cursInfo = $database->query("SELECT C.NOMBRE, C.DIA, C.HORAINICIO, C.HORAFIN, A.NOMBRE AS AREA FROM CURSO C INNER JOIN AREA A ON C.IDAREA=A.IDAREA WHERE C.IDCURSO=$idCurso");
    $nombreCurso='';
    $horario='';
    $dia='';
    $area='';
    while($regCurso  = $cursInfo->fetch_array( MYSQLI_BOTH)){
      $nombreCurso = $regCurso['NOMBRE'];
      $horario = substr($regCurso['HORAINICIO'], 0, 5).' - '.substr($regCurso['HORAFIN'], 0, 5);
      $dia = $regCurso['DIA'];
      $area = $regCurso['AREA'];
    }

    $estudiantes = $database->query("SELECT E.NOMBRE, E.SEGUNDONOMBRE, E.APELLIDO, E.SEGUNDOAPELLIDO, E.DPI_ESTUDIANTE, E.TELEFONO, E.CORREO, TIMESTAMPDIFF(YEAR, E.FECHANAC, CURDATE()) AS EDAD, E.SEXO, B.CONFIRMADA FROM CURSO_BOLETA C INNER JOIN  BOLETA_ASIGNACION B ON C.CODIGO=B.CODIGO INNER JOIN ESTUDIANTE E ON B.DPI_ESTUDIANTE=E.DPI_ESTUDIANTE WHERE C.IDCURSO=$idCurso ORDER BY E.APELLIDO ASC");

    $confirmados = $database->query("SELECT COUNT(E.NOMBRE) AS CONFIRMADOS FROM ESTUDIANTE E INNER JOIN BOLETA_ASIGNACION B ON E.DPI_ESTUDIANTE = B.DPI_ESTUDIANTE INNER JOIN CURSO_BOLETA C ON B.CODIGO = C.CODIGO WHERE C.IDCURSO =$idCurso AND B.CONFIRMADA=1");
    $numConfirmados = 5;
    while ($regConf = $confirmados->fetch_array( MYSQLI_BOTH )) {
      $numConfirmados = $regConf['CONFIRMADOS'];
    }

    $noConfirmados = $database->query("SELECT COUNT(E.NOMBRE) AS NOT_CONFIRMED FROM ESTUDIANTE E INNER JOIN BOLETA_ASIGNACION B ON E.DPI_ESTUDIANTE = B.DPI_ESTUDIANTE INNER JOIN CURSO_BOLETA C ON B.CODIGO = C.CODIGO WHERE C.IDCURSO =$idCurso AND B.CONFIRMADA=0");
    $numNoConfirmados = 8;
    while ($regNoConf = $noConfirmados->fetch_array( MYSQLI_BOTH )) {
      $numNoConfirmados = $regNoConf['NOT_CONFIRMED'];
    }


    $str = '<div class="well well-sm">
      <p><b>Curso: </b>'. $nombreCurso.' <br>
        <b>Área: </b>  '.$area.' <br>
        <b>Día: </b>'.$dia.'<br>
        <b>Horario: </b>'.$horario.'<br>  <b>';

        if (mysqli_num_rows($docentes)>1) {
          $str = $str. 'Docentes: ';
        }else {
          $str = $str. 'Docente: ';
        }
         $str = $str.'</b>';

       while ($regDoc = $docentes->fetch_array( MYSQLI_BOTH )) {
               $str = $str.'<div style="text-indent: 40pt;">';
               $str = $str.$regDoc['NOMBRE'].' '.$regDoc['APELLIDO'];
               $str = $str. '</div>';
       }
      $str = $str.'</p> </div> ';

      $str = $str.'<div>
                <form method="post" id="main-form" action="">
                    <input type="hidden" name="idCurso" value="'.$idCurso.'">

                    <div class="form-group">
                      <div class="col-sm-4">
                        <button type="submit" name="listaInscripcion" class="btn btn-primary center-block">
                          <span class="glyphicon glyphicon-th-list"></span>  Imprimir listado de Inscripción
                        </button>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-4">
                        <button type="submit" name="listaAsistencia" class="btn btn-success center-block">
                          <span class="glyphicon glyphicon-ok"></span>  Imprimir lista de Asistencia
                        </button>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-4">
                        <button type="submit" name="cartaCompromiso" class="btn btn-info center-block">
                          <span class="glyphicon glyphicon-file"></span>  Imprimir Cartas de Compromiso
                        </button>
                      </div>
                    </div>

                  </form> </div><br><br><br><br>';

      $str = $str.'<div>
            <h3 align="center">Estudiantes inscritos</h3>
            <ul class="list-group">
              <li class="list-group-item list-group-item-success">Confirmados. <span class="badge">'.$numConfirmados.'</span></li>
              <li class="list-group-item">No Confirmados. <span class="badge">'.$numNoConfirmados.'</span></li>
            </ul>

      			<table class="table table-active table-responsive table-bordered table-condensed table-striped" id="miTabla">

      					<thead>
      					<tr class="bg-primary">
                  <th>No.</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Correo</th>
                  <th>DPI</th>
                  <th>Edad</th>
                  <th>Sexo</th>
                </tr>
                </thead>
                <tbody>';

      $i = 1;
      while ($regEst = $estudiantes->fetch_array( MYSQLI_BOTH )) {

          if($regEst['CONFIRMADA']){
            $col = 'bg-success txt-success';
          }else {
            $col = 'txt-muted';
          }

          $str = $str.'<tr class="'.$color.'">
            <th>'.$i.'</th>
            <th>'.$regEst['NOMBRE'].' '.$regEst['SEGUNDONOMBRE'].' '.$regEst['APELLIDO'].' '.$regEst['SEGUNDOAPELLIDO'].'</th>
            <th>'.$regEst['TELEFONO'].'</th>
            <th>'.$regEst['CORREO'].'</th>
            <th>'.$regEst['DPI_ESTUDIANTE'].'</th>
            <th>'.$regEst['EDAD'].'</th>
            <th>'.$regEst['SEXO'].'</th>
          </tr>';

          $i++;
      }

      $str = $str.'</tbody> </table> </div>';
      echo $str;

  }
}
 ?>




  <!--  </div>


  </body>
</html>-->
