<?php

function cambiaf_a_mysql($fecha){//funcion para cambiar fecha a formato YYYY-mm-dd
  $date = substr($fecha, 6, 4);
  $date = $date.'-'.substr($fecha, 3, 2);
  $date = $date.'-'.substr($fecha, 0, 2);
  return $date;
}

function cambiaf_a_esp($fecha){//para cambiar fecha a formato dd-mm-YYYY
  $date = substr($fecha, 8, 2);
  $date = $date.'-'.substr($fecha, 5, 2);
  $date = $date.'-'.substr($fecha, 0, 4);
  return $date;
}

  if(isset($_POST['insert'])){
    require('include/Conn.inc.php');	


    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $area = filter_input(INPUT_POST, "area", FILTER_VALIDATE_INT);
    $cupo = filter_input(INPUT_POST, "cupo", FILTER_VALIDATE_INT);
    $docentes = $_POST['docentes'];
    $necesitaP = filter_input(INPUT_POST, "necesitaP", FILTER_VALIDATE_INT);
    $prerrequisitos = filter_input(INPUT_POST, "req", FILTER_SANITIZE_STRING);
    $dia = filter_input(INPUT_POST, "dia", FILTER_SANITIZE_STRING);
    $hora1 = filter_input(INPUT_POST, "hora1", FILTER_SANITIZE_STRING);
    $hora2 = filter_input(INPUT_POST, "hora2", FILTER_SANITIZE_STRING);
    $fechas[0] = filter_input(INPUT_POST, "fecha1", FILTER_SANITIZE_STRING);
    $fechas[1] = filter_input(INPUT_POST, "fecha2", FILTER_SANITIZE_STRING);
    $fechas[2] = filter_input(INPUT_POST, "fecha3", FILTER_SANITIZE_STRING);
    $fechas[3] = filter_input(INPUT_POST, "fecha4", FILTER_SANITIZE_STRING);
    $fechas[4] = filter_input(INPUT_POST, "fecha5", FILTER_SANITIZE_STRING);
    $fechas[5] = filter_input(INPUT_POST, "fecha6", FILTER_SANITIZE_STRING);

    foreach ($fechas as $date) {
      if ($date) {
        $date = cambiaf_a_mysql($date);
        echo $date.'<br>';
      }
    }


    echo $nombre.'<br>'.$area.'<br>'.$cupo.'<br>';

    foreach ($docentes as $docente) {
      echo $docente.'<br>';
    }

    if ($necesitaP) {
      echo $necesitaP.'<br>'.$prerrequisitos.'<br>';
    }else {
      echo '0<br>';
    }

    echo $dia.'<br>'.$hora1.'<br>'.$hora2;




    $database = new mysqli($dbserver, $dbuser, $password, $dbname);

    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{
      //consulta a la BD por el programa activo
      $programaActivo = 0;
      $query="SELECT IDPROGRAMA FROM PROGRAMA WHERE ESTADO=1";
      $queryPrograma= $database->query($query);

      while($programa  = $queryPrograma->fetch_array( MYSQLI_BOTH)){
        $programaActivo = $programa['IDPROGRAMA'];
      }
      echo '<br>'.$programaActivo.'<br>';

      if ($necesitaP) {
        $valores = " (".$programaActivo.", ".$area.", '".$nombre."', '".$dia."', '".$hora1."', '".$hora2."', 1, '".$prerrequisitos.", ".$cupo.");";
        $insertCurso = $database->query("INSERT INTO CURSO(IDPROGRAMA, IDAREA, NOMBRE, DIA, HORAINICIO, HORAFIN, NECESITAPRERREQUISITOS, PRERREQUISITOS, CUPO_LIMITE) VALUES (".$programaActivo.", ".$area.", '".$nombre."', '".$dia."', '".$hora1."', '".$hora2."', true, '".$prerrequisitos."', ".$cupo.");");
      }else {
        $insertCurso = $database->query("INSERT INTO CURSO(IDPROGRAMA, IDAREA, NOMBRE, DIA, HORAINICIO, HORAFIN, NECESITAPRERREQUISITOS, CUPO_LIMITE) VALUES(".$programaActivo.", ".$area.", '".$nombre."', '".$dia."', '".$hora1."', '".$hora2."', false, ".$cupo.");");
      }

      //averiguar el id del curso que se acaba de ingresar

      $idCurso = 0;
      $query="SELECT IDCURSO FROM CURSO WHERE NOMBRE='".$nombre."' AND (IDPROGRAMA = ".$programaActivo." AND DIA='".$dia."')";
      $queryIdCurso= $database->query($query);

      while($registro  = $queryIdCurso->fetch_array( MYSQLI_BOTH)){
        $idCurso = $registro['IDCURSO'];
      }
      echo '<br>'.$idCurso.'<br>';

      //insertar docentes y fechas
      foreach ($docentes as $docente) {
        $insD= $database->query("INSERT INTO IMPARTIDO_POR VALUES(".$docente.", ".$idCurso.")");
      }

      foreach ($fechas as $date) {
        if ($date) {
          $insF = $database->query("INSERT INTO FECHAS_CURSO(IDCURSO, FECHA) VALUES(".$idCurso.", '".cambiaf_a_mysql($date)."')");
        }
      }


      mysqli_close($database);
    }



  }
  header('Location:	cursos.php');
?>
