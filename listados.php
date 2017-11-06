<!DOCTYPE html>
<html>
<head>
    <title>Generación de listados</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link href="css/select2.min.css" rel="stylesheet"/>
</head>

<body>

  <?php
    $dbserver = '127.0.0.1';
    $dbuser = 'root';
    $password = 'dbn0w';
    $dbname = 'cursos_libres';

    $database = new mysqli($dbserver, $dbuser, $password, $dbname);

    if($database->connect_errno) {
      die("No se pudo conectar a la base de datos");
    }else{
      $cursOptions='<option value=""></option>';
      $cursos="SELECT C.IDCURSO, C.NOMBRE FROM CURSO C INNER JOIN PROGRAMA P ON C.IDPROGRAMA=P.IDPROGRAMA WHERE P.ESTADO=1 order by NOMBRE ASC";
      $queryCursos= $database->query($cursos);

      while($registroCurso  = $queryCursos->fetch_array( MYSQLI_BOTH)){
        $cursOptions = $cursOptions.' <option value="'.$registroCurso['IDCURSO'].'">'.$registroCurso['NOMBRE'].'</option>';
      }
    }
   ?>

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
       <li class="active"><a href="listados.php">Generar Listados</a></li>
       <li><a href="crearPrograma.php">Crear Nuevo Programa</a></li>
     </ul>
   </div>
 </div>
</nav><br><br>

<div class="container">
<div>
  <h1 align="center">Generación de Listados</h1>
</div><br><br>

<div class="form-group">
  <label class="control-label col-sm-1 col-sm-offset-2" for="area">Curso:</label>
  <div class="col-sm-7">
    <select class="form-control pick" id="curso" name="curso">
      <?php echo $cursOptions; ?>
    </select>
  </div>
</div><br><br>

<div id="contenido">

</div>

</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.min.js"></script>


</body>
</html>


  <script type="text/javascript">

    function addContent(){
      var curso = document.getElementById("curso").value;
      var parametros = {
        "idCurso" : curso
      };

      $.ajax({
        		data:	parametros,
        		url:	'listGenerator.php',
        		type: 	'post',
        		success: 	function(data){
				    $('#contenido').html(data);
				    },
			      error : 	function() {
			           console.log('error');
			      }
        	});

        $('#miTabla').dataTable();

    }

    $(document).ready(function(){
      $('#curso').change(addContent);
      $('#miTabla').dataTable();
      $('.pick').select2();
    });

  </script>
