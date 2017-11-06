<!DOCTYPE html>
<html>
<head>
    <title>Áreas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">


</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Cursos Libres</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrar
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="active"><a href="areas.php">Áreas</a></li>
          <li><a href="agendaDocentes.php">Docentes</a></li>
          <li><a href="cursos.php">Cursos</a></li>
        </ul>
      </li>
      <li><a href="listados.php">Generar Listados</a></li>
      <li><a href="crearPrograma.php">Crear Nuevo Programa</a></li>      
    </ul>
  </div>
</nav>

<div class="container">

<div>
  <br><br><h1 align="center">Administración de Áreas</h1>
</div>

<form method="post" id="main-form" action="insArea.php">
  <fieldset>
  <legend>Agregar Área</legend>

  <div class="form-group">
    <label for="nombre">Nombre del área:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="80" oninvalid="this.setCustomValidity('Ingrese correctamente el nombre del área. ')" oninput="setCustomValidity('')">
  </div><br>

  <div class="form-group">
    <label for="descripcion">Descripción del área:</label>
    <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" oninvalid="this.setCustomValidity('Ingrese correctamente la descripción del área. ')" oninput="setCustomValidity('')">
  </div>


<div class="form-group">
  <div class="col-sm-offset-6 col-sm-10">
    <input type="submit" name="add" value="Aceptar" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form>


<div style="overflow-x:auto;">
			<table class="table table-active table-responsive table-bordered table-condensed table-striped" id="miTabla">

					<thead>
					<tr class="info">
            <th>No.</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Opciones</th>
          </tr>
          </thead>
          <tbody>
            <?php
              $dbserver = '127.0.0.1';
              $dbuser = 'root';
              $password = 'dbn0w';
              $dbname = 'cursos_libres';

              $database = new mysqli($dbserver, $dbuser, $password, $dbname);

              if($database->connect_errno) {
                die("No se pudo conectar a la base de datos");
              }else{
                $areas="SELECT * FROM AREA order by IDAREA";
                $queryAreas= $database->query($areas);

                while($registroArea  = $queryAreas->fetch_array( MYSQLI_BOTH)){
                  echo '<tr id="line-'.$registroArea['IDAREA'].'">
                  <td>'.$registroArea['IDAREA'].'</td>
                  <td>'.$registroArea['NOMBRE'].'</td>
                  <td>'.$registroArea['DESCRIPCION'].'</td>


                  <td><button class="btn btn-warning" data-toggle="modal" data-target="#edit-'.$registroArea['IDAREA'].'">Editar</button>

                  <div class="modal fade" id="edit-'.$registroArea['IDAREA'].'" tabindex="-1" role="dialog"
                  aria-labelledby="editLabel-'.$registroArea['IDAREA'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="editLabel-'.$registroArea['IDAREA'].'">Editar</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upArea.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroArea['IDAREA'].'"/>
                            <label class"control-label col-sm-4">Nombre: </label><input class="form-control" required  name="nombre" id="nombre-'.$registroArea['IDAREA'].'" maxlength="80" oninvalid="this.setCustomValidity(\"Ingrese correctamente el nombre.\")" value="'.$registroArea['NOMBRE'].'"/></br>
                            <label class"control-label col-sm-4">Descripción: </label><input class="form-control" required  name="descripcion" id="descripcion-'.$registroArea['IDAREA'].'" maxlength="100" oninvalid="this.setCustomValidity("Ingrese correctamente la descripcion.")" value="'.$registroArea['DESCRIPCION'].'"/></br>
                            <br>
                          </div>
                          <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <input type="submit" name="edit" value="Actualizar" class="btn btn-primary"/>
                        </div>
                        </form>
                        </div>
                        </div>
                        </div>
                </td>';

                }
                mysqli_close($database);
              }
            ?>
          </tbody>
      </table>


    <script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
</div>
</body>
</html>

<script>
     $(document).ready(function(){
      $('#miTabla').dataTable();
    });

    </script>
