<?php

  if(isset($_POST['add'])){
    $dbserver = '127.0.0.1';
    $dbuser = 'root';
    $password = 'dbn0w';
    $dbname = 'cursos_libres';

    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);


    $database = new mysqli($dbserver, $dbuser, $password, $dbname);
    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{
      $consultaD="SELECT NOMBRE FROM AREA WHERE NOMBRE='".$nombre."' AND DESCRIPCION='".$descripcion."';";
      //echo $consultaD;
      $resultD=$database->query($consultaD) or mysql_error();
      //si la consulta no arroja un registro repetido
      if(mysqli_num_rows($resultD)==0){
        $valores="('".$nombre."', '".$descripcion."');";
        $sql = "INSERT INTO AREA(NOMBRE, DESCRIPCION) VALUES".$valores;
        //echo $sql;
        $sqlRes=$database->query($sql) or mysql_error();
      }
      mysqli_close($database);
    }

  }
  header('Location:	areas.php');
?>
