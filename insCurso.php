<?php

  if(isset($_POST['insert'])){
    $dbserver = '127.0.0.1';
    $dbuser = 'root';
    $password = 'dbn0w';
    $dbname = 'cursos_libres';

    /*$nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, "apellido", FILTER_SANITIZE_STRING);
    $profesion = filter_input(INPUT_POST, "profesion", FILTER_SANITIZE_STRING);
    $dpi = filter_input(INPUT_POST, "dpi", FILTER_VALIDATE_INT);
    $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
    $tel = filter_input(INPUT_POST, "tel", FILTER_VALIDATE_INT);
    $exp = filter_input(INPUT_POST, "exp", FILTER_SANITIZE_STRING);
    $competencias = filter_input(INPUT_POST, "competencias", FILTER_SANITIZE_STRING);


    $database = new mysqli($dbserver, $dbuser, $password, $dbname);
    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{
      $consultaD="SELECT DPI_DOCENTE, NOMBRE FROM DOCENTE WHERE DPI_DOCENTE=".$dpi." AND NOMBRE='".$nombre."';";
      $resultD=$database->query($consultaD) or mysql_error();
      //si la consulta no arroja un registro repetido
      if(mysqli_num_rows($resultD)==0){
        $valores="(".$dpi.", '".$nombre."', '".$apellido."', '".$profesion."', ".$tel.", '".$mail."', '".$exp."', '".$competencias."' );";
        $sql = "INSERT INTO DOCENTE VALUES".$valores;
        $sqlRes=$database->query($sql) or mysql_error();
      }
      mysqli_close($database);
    }*/
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $area = filter_input(INPUT_POST, "area", FILTER_VALIDATE_INT);
    $cupo = filter_input(INPUT_POST, "cupo", FILTER_VALIDATE_INT);
    $docentes = $_POST['docentes'];
    $necesitaP = filter_input(INPUT_POST, "necesitaP", FILTER_VALIDATE_INT);
    $prerrequisitos = filter_input(INPUT_POST, "req", FILTER_SANITIZE_STRING);
    $dia = filter_input(INPUT_POST, "dia", FILTER_SANITIZE_STRING);
    $hora1 = filter_input(INPUT_POST, "hora1", FILTER_SANITIZE_STRING);
    $hora2 = filter_input(INPUT_POST, "hora2", FILTER_SANITIZE_STRING);

    echo $nombre.'<br>'.$area.'<br>'.$cupo.'<br>';

    foreach ($docentes as $docente) {
      echo $docente.'<br>';
    }
    echo $necesitaP.'<br>'.$prerrequisitos.'<br>';
    echo $dia.'<br>'.$hora1.'<br>'.$hora2;



  }
  //header('Location:	agendaDocentes.php');
?>
