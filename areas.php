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


</head>

<body>
<div class="container">
<div>
  <h1 align="center">Administración de Áreas</h1>
</div>

<form method="post" id="main-form" action="insArea.php">
  <fieldset>
  <legend>Agregar Área</legend>

  <div class="form-group">
    <label for="nombre">Nombre del área:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="30" oninvalid="this.setCustomValidity('Ingrese correctamente el nombre del área. ')" oninput="setCustomValidity('')">
  </div><br>

  <div class="form-group">
    <label for="descripcion">Descripción del área:</label>
    <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="40" oninvalid="this.setCustomValidity('Ingrese correctamente la descripción del área. ')" oninput="setCustomValidity('')">
  </div>


<div class="form-group">
  <div class="col-sm-offset-6 col-sm-10">
    <input type="submit" name="insert" value="Aceptar" class="btn btn-primary"/>
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
                $areas="SELECT * FROM AREA order by IDAREA ASC";
                $queryAreas= $database->query($areas);

                while($registroDocente  = $queryDocentes->fetch_array( MYSQLI_BOTH)){
                  echo '<tr id="line-'.$registroDocente['DPI_DOCENTE'].'">
                  <td>'.$registroDocente['NOMBRE'].'</td>
                  <td>'.$registroDocente['APELLIDO'].'</td>
                  <td>'.$registroDocente['DPI_DOCENTE'].'</td>
                  <td>'.$registroDocente['PROFESION'].'</td>
                  <td>'.$registroDocente['TELEFONO'].'</td>
                  <td>'.$registroDocente['CORREO'].'</td>
                  <td><button class="btn btn-success" data-toggle="modal" data-target="#experiencia-'.$registroDocente['DPI_DOCENTE'].'">Experiencia</button>

                  <div class="modal fade" id="experiencia-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="experienciaLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="experienciaLabel-'.$registroDocente['DPI_DOCENTE'].'">Experiencia del docente: '.$registroDocente['NOMBRE'].'  '.$registroDocente['APELLIDO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Experiencia Laboral:
                            <textarea class="form-control" cols="50" rows="4" name="exp" maxlength="200">'.$registroDocente['EXPERIENCIALABORAL'].'</textarea>
                            </label>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editExperiencia" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>	</td>

                  <td><button class="btn btn-info" data-toggle="modal" data-target="#competencias-'.$registroDocente['DPI_DOCENTE'].'">Competencias</button>

                  <div class="modal fade" id="competencias-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="competenciasLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="competenciasLabel-'.$registroDocente['DPI_DOCENTE'].'">Competencias del docente: '.$registroDocente['NOMBRE'].'  '.$registroDocente['APELLIDO'].'</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Competencias:
                            <textarea class="form-control" cols="50" rows="4" name="competencias" maxlength="200">'.$registroDocente['COMPETENCIAS'].'</textarea>
                            </label>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <input type="submit" name="editCompetencias" value="Actualizar" class="btn btn-primary"/>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div></td>

                  <td><button class="btn btn-warning" data-toggle="modal" data-target="#edit-'.$registroDocente['DPI_DOCENTE'].'">Editar</button>

                  <div class="modal fade" id="edit-'.$registroDocente['DPI_DOCENTE'].'" tabindex="-1" role="dialog"
                  aria-labelledby="editLabel-'.$registroDocente['DPI_DOCENTE'].'">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-tittle" id="editLabel-'.$registroDocente['DPI_DOCENTE'].'">Editar</h4>
                        </div>
                        <form class="form-vertical" method="POST" action="upDocente.php">
                          <div class="modal-body form-group">
                            <input type="hidden" name="id" value="'.$registroDocente['DPI_DOCENTE'].'"/>
                            <label class"control-label col-sm-2">Nombre: </label><input class="form-control" required  name="nombre" id="nombre-'.$registroDocente['DPI_DOCENTE'].'" maxlength="15" oninvalid="this.setCustomValidity(\"Ingrese correctamente el nombre.\")" value="'.$registroDocente['NOMBRE'].'"/></br>
                            <label class"control-label col-sm-2">Apellido: </label><input class="form-control" required  name="apellido" id="apellido-'.$registroDocente['DPI_DOCENTE'].'" maxlength="15" oninvalid="this.setCustomValidity("Ingrese correctamente el apellido.")" value="'.$registroDocente['APELLIDO'].'"/></br>
                            <label class"control-label col-sm-2">DPI: </label><input type="number" class="form-control" required  name="dpi" id="dpi-'.$registroDocente['DPI_DOCENTE'].'" min="1000000000000" max="9999999999999"  oninvalid="this.setCustomValidity("Ingrese correctamente los 13 dígitos del CUI.")"  value="'.$registroDocente['DPI_DOCENTE'].'"/></br>
                            <label class"control-label col-sm-2">Correo: </label><input type="email" class="form-control" required  name="mail" id="mail-'.$registroDocente['DPI_DOCENTE'].'" maxlength="25" required oninvalid="this.setCustomValidity("Ingrese correctamente el correo electrónico.")" value="'.$registroDocente['CORREO'].'"/></br>
                            <label class"control-label col-sm-2">Teléfono: </label><input type="number" class="form-control" required  name="tel" id="tel-'.$registroDocente['DPI_DOCENTE'].'" min="1000000" max="99999999" oninvalid="this.setCustomValidity("Ingrese correctamente los 8 dígitos del número de teléfono.")" value="'.$registroDocente['TELEFONO'].'"/></br>
                            <label class"control-label col-sm-2">Profesión: </label><input class="form-control" required  name="profesion" id="profesion-'.$registroDocente['DPI_DOCENTE'].'" maxlength="25" oninvalid="this.setCustomValidity("Ingrese correctamente la profesion.")" value="'.$registroDocente['PROFESION'].'"/></br>
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
