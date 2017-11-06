<?php


$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

if (isset($_POST['edit'])) {

  //filtrando entradas para evitar inyeccion sql
  $idPrograma = filter_input(INPUT_POST, "programa", FILTER_VALIDATE_INT);
  $jornada = filter_input(INPUT_POST, "jornada", FILTER_VALIDATE_INT);
  $fechaPro1 = filter_input(INPUT_POST, "fechaPro1", FILTER_SANITIZE_STRING);
  $fechaPro2 = filter_input(INPUT_POST, "fechaPro2", FILTER_SANITIZE_STRING);
  $fechaIns1 = filter_input(INPUT_POST, "fechaIns1", FILTER_SANITIZE_STRING);
  $fechaIns2 = filter_input(INPUT_POST, "fechaIns2", FILTER_SANITIZE_STRING);

  echo $fechaPro1.'<br>'.$fechaPro2.'<br>'.$fechaIns1.'<br>'.$fechaIns2;

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);
  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{
    $consultaU="UPDATE PROGRAMA SET JORNADA=".$jornada.", FECHAINICIO='".$fechaPro1."', FECHAFIN='$fechaPro2', INICIOINSCRIPCIONES='$fechaIns1', CIERREINSCRIPCIONES='$fechaIns2'  WHERE IDPROGRAMA=".$idPrograma.";";
    //echo $consultaU;
    $resultD=$database->query($consultaU) or mysql_error();

    mysqli_close($database);
  }
}

header('Location:	editarPrograma.php');
?>
