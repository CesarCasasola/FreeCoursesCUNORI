<?php

$dpi = 0;
$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

if (isset($_POST['editExperiencia'])) {

  //filtrando entradas para evitar inyeccion sql
  $dpi = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
  $exp = filter_input(INPUT_POST, "exp", FILTER_SANITIZE_STRING);

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);
  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{
    $consultaU="UPDATE DOCENTE SET EXPERIENCIALABORAL='".$exp."' WHERE DPI_DOCENTE=".$dpi.";";
    echo $consultaU;
    $resultD=$database->query($consultaU) or mysql_error();

    mysqli_close($database);
  }
}elseif (isset($_POST['editCompetencias'])) {

  //filtrando entradas para evitar inyeccion sql
  $dpi = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
  $exp = filter_input(INPUT_POST, "competencias", FILTER_SANITIZE_STRING);

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);
  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{
    $consultaU="UPDATE DOCENTE SET COMPETENCIAS='".$exp."' WHERE DPI_DOCENTE=".$dpi.";";
    echo $consultaU;
    $resultD=$database->query($consultaU) or mysql_error();

    mysqli_close($database);
  }
}elseif (isset($_POST['edit'])) {

  //filtrando entradas para evitar inyeccion sql
  $dpi = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
  $dpiNew = filter_input(INPUT_POST, "dpi", FILTER_VALIDATE_INT);
  $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
  $apellido = filter_input(INPUT_POST, "apellido", FILTER_SANITIZE_STRING);
  $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
  $tel = filter_input(INPUT_POST, "tel", FILTER_VALIDATE_INT);
  $profesion = filter_input(INPUT_POST, "profesion", FILTER_SANITIZE_STRING);

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);
  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{
    $consultaU="UPDATE DOCENTE SET NOMBRE='".$nombre."', APELLIDO='".$apellido."', CORREO='".$mail."', PROFESION='".$profesion."', TELEFONO=".$tel.", DPI_DOCENTE=".$dpiNew." WHERE DPI_DOCENTE=".$dpi.";";
    echo $consultaU;
    $resultD=$database->query($consultaU) or mysql_error();

    mysqli_close($database);
  }
}

header('Location:	agendaDocentes.php#line-'.$dpi);
?>
