<?php


$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

if (isset($_POST['edit'])) {

  //filtrando entradas para evitar inyeccion sql
  $idArea = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
  $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
  $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);
  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{
    $consultaU="UPDATE AREA SET NOMBRE='".$nombre."', DESCRIPCION='".$descripcion."' WHERE IDAREA=".$idArea.";";
    echo $consultaU;
    $resultD=$database->query($consultaU) or mysql_error();

    mysqli_close($database);
  }
}

header('Location:	areas.php#line-'.$idArea);
?>
