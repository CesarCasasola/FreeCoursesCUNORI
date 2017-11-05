<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Template Name: Agenda de Docentes
 *
 * @file           agendaDocentes.php
 * @package        Celestial Lite
 * @version        Celestial Lite 1.0.1
 * @author         Styled Themes
 * @copyright      2012-2013 Styledthemes.com
 * @license        license.txt
 */

get_header();


if (!current_user_can('manage_course') and !current_user_can('administrator')) {
	# code...
	$usererror_msg = 'No posee los permisos para ver este contenido. <br>';
	$usererror_msg .= ' Si piensa que esto es un error póngase en contacto con el Administrador del sistema.';
	echo '<div id="erroruser" class="form_entry ui-state-error ui-corner-all">'.$usererror_msg.'</div>';
	exit;
}
?>

<?php if (get_theme_mod('blog_left') ) : // Use this layout if the blog left is selected ?>
	<?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>
		<div id="secondary" class="widget-area span4" role="complementary">
			<div id="st-left" class="st-sidebar-list">
			<?php dynamic_sidebar( 'sidebar-6' ); ?>
			</div>
		</div><!-- #secondary -->
	<?php endif; ?>
	<section id="primary" class="span8">

		<div id="content" role="main">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( '/partials/content', get_post_format() ); ?>
				<?php endwhile; ?>
			<?php endif; // end have_posts() check ?>
			<?php celestial_lite_post_nav( 'nav-below' ); ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php else : // If the left sidebar is not selected - use this layout ?>

	<section id="primary" >
		<a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>


		<div id="content" role="main">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( '', get_post_format() ); ?>
				<?php endwhile; ?>
			<?php endif; // end have_posts() check ?>
		</div><!-- #content -->
	</section><!-- #primary -->


<div class="container">
<div>
  <h1 align="center">Agenda de Docentes</h1>
</div>

<form method="post" id="main-form" class="form-horizontal" action="insDocente.php">
  <fieldset>
  <legend>Agregar Docente</legend>
  <div class="form-group">
    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
    <div class="col-sm-3">
      <input class="form-control" id="nombre" name="nombre" required maxlength="30" oninvalid="this.setCustomValidity('Ingrese correctamente el nombre del docente. ')" oninput="setCustomValidity('')">
    </div>
    <label class="control-label col-sm-2" for="apellido">Apellido:</label>
    <div class="col-sm-3">
      <input class="form-control" id="apellido" name="apellido" required maxlength="30" oninvalid="this.setCustomValidity('Ingrese correctamente el apellido del docente.')" oninput="setCustomValidity('')">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="dpi">DPI:</label>
    <div class="col-sm-3">
      <input type="number" class="form-control" id="dpi" name="dpi" required min="1000000000000" max="9999999999999"  oninvalid="this.setCustomValidity('Ingrese correctamente los 13 dígitos del CUI.')" oninput="setCustomValidity('')">
    </div>
    <label class="control-label col-sm-2" for="mail">Correo:</label>
    <div class="col-sm-3">
      <input type="email" class="form-control" id="mail" name="mail" maxlength="25" required oninvalid="this.setCustomValidity('Ingrese correctamente el correo electrónico.')" oninput="setCustomValidity('')">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="tel">Teléfono:</label>
    <div class="col-sm-3">
      <input type="number" class="form-control" id="tel" name="tel" required min="1000000" max="99999999" oninvalid="this.setCustomValidity('Ingrese correctamente los 8 dígitos del número de teléfono.')" oninput="setCustomValidity('')">
    </div>
    <label class="control-label col-sm-2" for="profesion">Profesion:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="profesion" name="profesion" required maxlength="25" oninvalid="this.setCustomValidity('Ingrese correctamente la profesión del docente.')" oninput="setCustomValidity('')">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="exp">Experiencia Laboral:</label>
      <div class="col-sm-3">
        <textarea class="form-control" id="exp" name="exp" cols="50" rows="4"  ></textarea>
      </div>
    <label class="control-label col-sm-2" for="competencias">Competencias:</label>
    <div class="col-sm-3">
      <textarea cols="50" rows="4" class="form-control" id="competencias" name="competencias" ></textarea>
    </div>
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
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>DPI</th>
            <th>Profesión</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Experiencia Laboral</th>
            <th>Competencias</th>
            <th>Opciones</th>
          </tr>
          </thead>
          <tbody>
            <?php
              require('include/Conn.inc.php');

              $database = new mysqli($dbserver, $dbuser, $password, $dbname);

              if($database->connect_errno) {
                die("No se pudo conectar a la base de datos");
              }else{
                $docentes="SELECT * FROM DOCENTE order by APELLIDO ASC, NOMBRE ASC";
                $queryDocentes= $database->query($docentes);

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
<script>
     $(document).ready(function(){
      $('#miTabla').dataTable();
    });

    </script>

</div>

<footer>
   Copyright &copy; 2017 por César Casasola Miranda
</footer>


<?php if ( is_active_sidebar( 'sidebar-7' ) ) : ?>

<?php endif; ?>

<?php endif; ?>

<?php get_footer(); ?>
