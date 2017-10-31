
<!DOCTYPE html>
<html>
<head>
    <title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>

<?php

function cambiaf_a_mysql($fecha){//funcion para cambiar fecha a formato YYYY-mm-dd
  $date = substr($fecha, 6, 4);
  $date = $date.'-'.substr($fecha, 3, 2);
  $date = $date.'-'.substr($fecha, 0, 2);
  return $date;
}

function cambiaf_a_esp($fecha){
  $date = substr($fecha, 8, 2);
  $date = $date.'-'.substr($fecha, 5, 2);
  $date = $date.'-'.substr($fecha, 0, 4);
  return $date;
}

  if(isset($_POST['crearPrograma'])){
    $dbserver = '127.0.0.1';
    $dbuser = 'root';
    $password = 'dbn0w';
    $dbname = 'cursos_libres';

    $programa = filter_input(INPUT_POST, "programa", FILTER_VALIDATE_INT);
    $jornada = filter_input(INPUT_POST, "jornada", FILTER_VALIDATE_INT);
    $fechaPro1 = filter_input(INPUT_POST, "fechaPro1", FILTER_SANITIZE_STRING);
    $fechaPro2 = filter_input(INPUT_POST, "fechaPro2", FILTER_SANITIZE_STRING);
    $fechaIns1 = filter_input(INPUT_POST, "fechaIns1", FILTER_SANITIZE_STRING);
    $fechaIns2 = filter_input(INPUT_POST, "fechaIns2", FILTER_SANITIZE_STRING);

    $fechaPro1 = cambiaf_a_mysql($fechaPro1);
    $fechaPro2 = cambiaf_a_mysql($fechaPro2);
    $fechaIns1 = cambiaf_a_mysql($fechaIns1);
    $fechaIns2 = cambiaf_a_mysql($fechaIns2);

    $database = new mysqli($dbserver, $dbuser, $password, $dbname);
    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{
      $database->autocommit(false); //deshabilitando autocommit para manejar transaccion
      $flag = true;



      $result = $database->query("INSERT INTO PROGRAMA VALUES(".$programa.", ".$jornada.", '".$fechaPro1."', '".$fechaPro2."', 1, '".$fechaIns1."', '".$fechaIns2."')");
      if ($database->errno) {
          $flag = false;
      }

      $result = $database->query("UPDATE PROGRAMA SET ESTADO=0 WHERE IDPROGRAMA=".($programa-1));
      if ($database->errno) {
          $flag = false;
      }

      if ($flag) {//si no hubo error en las consultas
        $database->commit();
        echo "<h1 align='center'>¡".$programa."° PROGRAMA DE CURSOS LIBRES CREADO EXITOSAMENTE!</h1><br>
              <p align='center'>El Programa se desarrollará del ".cambiaf_a_esp($fechaPro1)." al
                                ".cambiaf_a_esp($fechaPro2).". <br>Ahora puede editar la información del Programa
                                o crear los cursos para el mismo siguiendo el enlace correspondiente.</p><br><br><br>
              <div class='btn-group col-sm-offset-5 col-sm-5'>
                  <a href='editarPrograma.php' class='btn btn-primary active'>
                      <i class='glyphicon glyphicon-wrench' aria-hidden='true'></i> Editar Programa
                  </a>
              </div><br><br>
              <div class='btn-group col-sm-offset-5 col-sm-4'>
                  <a href='cursos.php' class='btn btn-primary active'>
                      <i class='glyphicon glyphicon-plus' aria-hidden='true'></i> Agregar Cursos
                  </a>
              </div>";
      }else {
        $database->rollback();
        echo "<h1 align='center'>No fue posible crear el nuevo programa.</h1><br>
              <h3 align='center'>Por favor, vuelva a intentar</h3><br><br><br>
              <div class='btn-group col-sm-offset-1 col-sm-4'>
                  <a href='crearPrograma.php' class='btn btn-primary active'>
                      <i class='glyphicon glyphicon-chevron-left' aria-hidden='true'></i> Regresar
                  </a>
              </div>";
      }

    }

  }
 ?>







  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
