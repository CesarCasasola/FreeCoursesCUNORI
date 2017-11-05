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

$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

  if(isset($_POST['edit'])){

    $idCurso = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $area = filter_input(INPUT_POST, "area", FILTER_VALIDATE_INT);
    $cupo = filter_input(INPUT_POST, "cupo", FILTER_VALIDATE_INT);
    /*$docentes = $_POST['docentes'];
    */
    $dia = filter_input(INPUT_POST, "dia", FILTER_SANITIZE_STRING);
    $hora1 = filter_input(INPUT_POST, "hora1", FILTER_SANITIZE_STRING);
    $hora2 = filter_input(INPUT_POST, "hora2", FILTER_SANITIZE_STRING);


    echo $idCurso.'<br>'.$nombre.'<br>'.$area.'<br>'.$cupo.'<br>';

    /*foreach ($docentes as $docente) {
      echo $docente.'<br>';
    }*/

    echo $dia.'<br>'.$hora1.'<br>'.$hora2;
    $database = new mysqli($dbserver, $dbuser, $password, $dbname);

    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{

      $upCurso = $database->query("UPDATE CURSO SET IDAREA=$area, NOMBRE='$nombre', DIA='$dia', HORAINICIO='$hora1', HORAFIN='$hora2', CUPO_LIMITE=$cupo WHERE IDCURSO=$idCurso");
      mysqli_close($database);
    }

  }elseif(isset($_POST['editFechas'])) {
      $idCurso = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
      $fechas[0] = filter_input(INPUT_POST, "fecha1", FILTER_SANITIZE_STRING);
      $fechas[1] = filter_input(INPUT_POST, "fecha2", FILTER_SANITIZE_STRING);
      $fechas[2] = filter_input(INPUT_POST, "fecha3", FILTER_SANITIZE_STRING);
      $fechas[3] = filter_input(INPUT_POST, "fecha4", FILTER_SANITIZE_STRING);
      $fechas[4] = filter_input(INPUT_POST, "fecha5", FILTER_SANITIZE_STRING);
      $fechas[5] = filter_input(INPUT_POST, "fecha6", FILTER_SANITIZE_STRING);

      $database = new mysqli($dbserver, $dbuser, $password, $dbname);

      if($database->connect_errno) {
        die("No se pudo conectar a la base de datos");
      }else{
        $database->autocommit(false); //deshabilitando autocommit para manejar transaccion
        $flag = true;
        //eliminando fechas actuales
        $delFechas = $database->query("DELETE FROM FECHAS_CURSO WHERE IDCURSO=$idCurso");
        if ($database->errno) {
            $flag = false;
        }

          echo $idCurso.'<br>';
          foreach ($fechas as $date) {
            if ($date) {
              echo $date.'<br>';
              $insDate = $database->query("INSERT INTO FECHAS_CURSO(IDCURSO, FECHA) VALUES(".$idCurso.", '".$date."')");
              if ($database->errno) {
                  $flag = false;
              }
            }
          }

        if ($flag) {
          $database->commit();
          echo "commited";
        }else {
          $database->rollback();
        }
        mysqli_close($database);
      }

    }elseif (isset($_POST['editPre'])) {
      $idCurso = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
      $necesitaP = filter_input(INPUT_POST, "necesitaP", FILTER_VALIDATE_INT);
      $prerrequisitos = filter_input(INPUT_POST, "reqEd", FILTER_SANITIZE_STRING);

      $database = new mysqli($dbserver, $dbuser, $password, $dbname);

      if($database->connect_errno) {
        die("No se pudo conectar a la base de datos");
      }else{

        if ($necesitaP) {
          echo $necesitaP.'<br>'.$prerrequisitos.'<br>';
          $upPre = $database->query("UPDATE CURSO SET NECESITAPRERREQUISITOS=1, PRERREQUISITOS='$prerrequisitos' WHERE IDCURSO=$idCurso");
        }else {
          echo '0<br>';
          $upPre = $database->query("UPDATE CURSO SET NECESITAPRERREQUISITOS=0, PRERREQUISITOS='' WHERE IDCURSO=$idCurso");
        }

        mysqli_close($database);
      }

    }elseif (isset($_POST['editDocentes'])) {
      $idCurso = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
      $docentes = $_POST['docentes'];
      echo $idCurso.'<br>';

      $database = new mysqli($dbserver, $dbuser, $password, $dbname);

      if($database->connect_errno) {
        die("No se pudo conectar a la base de datos");
      }else{
        $database->autocommit(false); //deshabilitando autocommit para manejar transaccion
        $flag = true;
        //eliminando docentes actuales
        $delFechas = $database->query("DELETE FROM IMPARTIDO_POR WHERE IDCURSO=$idCurso");
        if ($database->errno) {
            $flag = false;
        }

        foreach ($docentes as $docente) {
          echo $docente.'<br>';
          $insD= $database->query("INSERT INTO IMPARTIDO_POR VALUES(".$docente.", ".$idCurso.")");
          if ($database->errno) {
              $flag = false;
          }
        }

        if ($flag) {
          $database->commit();
          echo "commited";
        }else {
          $database->rollback();
        }

        mysqli_close($database);
      }
    }
  header('Location:	cursos.php#line-'.$idCurso);
?>
