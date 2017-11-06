<?php
$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = 'dbn0w';
$dbname = 'cursos_libres';

$database = new mysqli($dbserver, $dbuser, $password, $dbname);

if($database->connect_errno) {
  die("No se pudo conectar a la base de datos");
}else{
  $ultimoPrograma = 0;
  $query="SELECT * FROM PROGRAMA WHERE ESTADO=1";
  $queryPrograma= $database->query($query);

  while($programa  = $queryPrograma->fetch_array( MYSQLI_BOTH)){
    $idPrograma = $programa['IDPROGRAMA'];
    $jornada = $programa['JORNADA'];
    $fechaInicio = $programa['FECHAINICIO'];
    $fechaFin = $programa['FECHAFIN'];
    $inicioInscripciones = $programa['INICIOINSCRIPCIONES'];
    $finInscripciones = $programa['CIERREINSCRIPCIONES'];

  }
  //echo $idPrograma.'<br>'.$jornada.'<br>'.$fechaInicio.'<br>'.$fechaFin.'<br>'.$inicioInscripciones.'<br>'.$finInscripciones;
  mysqli_close($database);
}
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Aperturar Programa</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">


</head>
<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">

    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
     </button>
     <a class="navbar-brand" href="#">Cursos Libres</a>
   </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrar
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="areas.php">Áreas</a></li>
          <li><a href="agendaDocentes.php">Docentes</a></li>
          <li><a href="cursos.php">Cursos</a></li>
        </ul>
      </li>
      <li><a href="listados.php">Generar Listados</a></li>
      <li class="active"><a href="editarPrograma.php">Editar Programa</a></li>
      <li><a href="crearPrograma.php">Crear Nuevo Programa</a></li>
    </ul>
  </div>
</div>
</nav><br><br>

<div class="container">
    <h1 align="center">Editar programa</h1><br><br>

    <fieldset>
      <form method="post" id="main-form" class="form-horizontal" action="upPrograma.php">
      <input type="hidden" id="programa" name="programa" value="<?php echo $idPrograma;?>">

    <div class="form-group">
      <label class="control-label col-sm-5" for="nombre">Nombre del programa:</label>
      <div class="col-sm-4">
      <input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma" value="<?php echo $idPrograma;?>° PROGRAMA DE CURSOS LIBRES" readonly="true">
      </div>
    </div><br>

    <div class="form-group">
      <label class="control-label col-sm-5" for="jornada">Jornada:</label>
      <div class="col-sm-3">
      <select class="form-control" id="jornada" name="jornada">
      <?php
        if ($jornada == 1) {
          echo '<option value="'.$jornada.'">Primera Jornada '.date('Y').'</option>';
        }else {
          echo '<option value="'.$jornada.'">Segunda Jornada '.date('Y').'</option>';
        }
       ?>
      <option value="1">Primera Jornada <?php echo date('Y'); ?></option>
      <option value="2">Segunda Jornada <?php echo date('Y'); ?></option>
      </select>
      </div>
    </div><br>

    <h4 align="center">Fechas de realización del programa:</h4><br>

    <div class="form-group">
      <label class="control-label col-sm-3" for="fechaPro1">Inicio:</label>
      <div class="col-sm-2">
      <input type="date" class="form-control" id="fechaPro1" name="fechaPro1" size="8" value="<?php echo $fechaInicio;?>" required>
    </div>

    <label class="control-label col-sm-2" for="fechaPro2">Fin:</label>
      <div class="col-sm-2">
      <input type="date" class="form-control date" id="fechaPro2" name="fechaPro2" size="8" value="<?php echo $fechaFin;?>" required>
      </div>
    </div><br>

    <h4 align="center">Fechas de inscripción:</h4><br>

    <div class="form-group">
    <label class="control-label col-sm-3" for="fechaIns1">Inicio:</label>
    <div class="col-sm-2">
    <input type="date" class="form-control date" id="fechaIns1" name="fechaIns1" size="8" value="<?php echo $inicioInscripciones; ?>" required>
    </div>

    <label class="control-label col-sm-2" for="fechaIns2">Fin:</label>
    <div class="col-sm-2">
    <input type="date" class="form-control" id="fechaIns2" name="fechaIns2" size="8" value="<?php echo $finInscripciones; ?>" required>
    </div>
  </div><br><br>

    <div class="form-group">
    <div class="col-sm-offset-6 col-sm-10">
    <input type="submit" class="btn btn-success" name="edit" value="Aceptar">
    </div>
    </div><br>

    </form>
  </fieldset>
</div>

</body>
</html>
