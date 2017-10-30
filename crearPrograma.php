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
  $query="SELECT IDPROGRAMA FROM PROGRAMA WHERE ESTADO=1";
  $queryPrograma= $database->query($query);

  while($programa  = $queryPrograma->fetch_array( MYSQLI_BOTH)){
    $ultimoPrograma = $programa['IDPROGRAMA'];
  }
  //echo $ultimoPrograma;
  mysqli_close($database);
}
 ?>

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
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">


</head>
<body>
  <div class="container">


    <h1 align="center">Aperturar programa</h1>

    <div class="alert alert-warning">
      <strong>Precaución.</strong> Antes de aperturar un nuevo programa, debe cerrar el existente.
      Hágalo solamente si ya no necesitará modificar la información del programa actual. Si está
      segur@ de hacerlo, proceda seleccionando la opción Cerrar Programa.
    </div>
    <br>

    <form class="form-horizontal">
      <div class="form-group">
        <input type="hidden" id="programaActual" value="<?php echo $ultimoPrograma; ?>">
        <label class="control-label col-sm-6" for="cerrar">¿Desea cerrar el <?php echo $ultimoPrograma; ?>° Programa de Cursos Libres?  </label>
        <div class="col-sm-1">
          <input class="btn btn-danger" type="submit" name="cerrar" id="cerrar" value="Cerrar Programa">
        </div>

      </div>
    </form>
    <br><br>

    <div class="form" id="formulario">

    </div>



  </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
</body>
</html>

<script type="text/javascript">

    $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function () {
    $(".date").datepicker();
    });

    function addForm(e){
      e.preventDefault();
      var fecha = new Date();
      var anio = fecha.getFullYear();
      var nuevoPrograma = parseInt(document.getElementById('programaActual').value)+1;
      var strForm = '<h2 align="center">Creación del nuevo programa</h2><br> ';
      strForm = strForm + '<form method="post" id="main-form" class="form-horizontal" action="programCreate.php">';
      strForm = strForm + '<input type="hidden" id="programa" name="programa" value="'+nuevoPrograma+'">';

      strForm = strForm + '<div class="form-group">';
      strForm = strForm + '<label class="control-label col-sm-5" for="nombre">Nombre del programa:</label>';
      strForm = strForm + '<div class="col-sm-4">';
      strForm = strForm + '<input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma" value="'+nuevoPrograma+'° PROGRAMA DE CURSOS LIBRES" readonly="true">';
      strForm = strForm + '</div>';
      strForm = strForm + '</div><br>';

      strForm = strForm + '<div class="form-group">';
      strForm = strForm + '<label class="control-label col-sm-5" for="jornada">Jornada:</label>';
      strForm = strForm + '<div class="col-sm-3">';
      strForm = strForm + '<select class="form-control" id="jornada" name="jornada">';
      strForm = strForm + '<option value="1">Primera Jornada '+anio+'</option>';
      strForm = strForm + '<option value="2">Segunda Jornada '+anio+'</option>';
      strForm = strForm + '</select>';
      strForm = strForm + '</div>';
      strForm = strForm + '</div><br>';

      strForm = strForm + '<h5 align="center">Fechas de realización del programa:</h5>';

      strForm = strForm + '<div class="form-group">';
      strForm = strForm + '<label class="control-label col-sm-5" for="nombre">Nombre del programa:</label>';
      strForm = strForm + '<div class="col-sm-3">';
      strForm = strForm + '<input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma" value="'+nuevoPrograma+' PROGRAMA DE CURSOS LIBRES" readonly="true">';
      strForm = strForm + '</div>';
      strForm = strForm + '<label class="control-label col-sm-5" for="nombre">Nombre del programa:</label>';
      strForm = strForm + '<div class="col-sm-3">';
      strForm = strForm + '<input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma" value="'+nuevoPrograma+' PROGRAMA DE CURSOS LIBRES" readonly="true">';
      strForm = strForm + '</div>';
      strForm = strForm + '</div><br>';

      strForm = strForm + '</form>';
      document.getElementById('formulario').innerHTML = strForm;
    }

    $(document).ready(function() {
    	    $('#cerrar').click(addForm);
    	});

</script>
