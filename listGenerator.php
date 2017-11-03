<?php

  $idCurso = 5;

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
      $horario = $regCurso['HORAINICIO'].' - '.$regCurso['HORAFIN'];
      $dia = $regCurso['DIA'];
      $area = $regCurso['AREA'];
    }
    $estudiantes = $database->query("SELECT E.NOMBRE, E.SEGUNDONOMBRE, E.APELLIDO, E.SEGUNDOAPELLIDO, E.DPI_ESTUDIANTE, E.TELEFONO, E.CORREO, E.FECHANAC, E.SEXO, B.CONFIRMADA FROM CURSO_BOLETA C INNER JOIN  BOLETA_ASIGNACION B ON C.CODIGO=B.CODIGO INNER JOIN ESTUDIANTE E ON B.DPI_ESTUDIANTE=E.DPI_ESTUDIANTE WHERE C.IDCURSO=$idCurso ORDER BY E.APELLIDO ASC");

  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->

		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="well well-sm">
        <p><b>Curso: </b> <?php echo $nombreCurso; ?><br>
          <b>Área: </b> <?php echo $area; ?> <br>
          <b>Horario </b> <?php echo $horario; ?><br>
          <b>Día:</b> <?php echo $dia; ?><br>
          <b><?php
          if (mysqli_num_rows($docentes)>1) {
            echo 'Docentes: ';
          }else {
            echo 'Docente: ';
          }
           ?></b><br>

             <?php
             while ($regDoc = $docentes->fetch_array( MYSQLI_BOTH )) {
                 echo '<div style="text-indent: 40pt;">';
                 echo $regDoc['NOMBRE'].' '.$regDoc['APELLIDO'];
                 echo '</div>';
             }
              ?>
        </p>
      </div>

      

    </div>


  </body>
</html>
