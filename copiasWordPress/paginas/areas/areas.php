<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Template Name: Página de Administración de Áreas
 *
 * @file           areas.php
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
  <h1 align="center">Administración de Áreas</h1>
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
              require('include/Conn.inc.php');	

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



    <script>
     $(document).ready(function(){
      $('#miTabla').dataTable();
    });

    </script>

    <footer>
       Copyright &copy; 2017 por César Casasola Miranda
    </footer>


    <?php if ( is_active_sidebar( 'sidebar-7' ) ) : ?>

    <?php endif; ?>

  <?php endif; ?>

  <?php get_footer(); ?>
