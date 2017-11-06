<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Template Name: Editar Programa
 *
 * @file           editarPrograma.php
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

<footer>
   Copyright &copy; 2017 por César Casasola Miranda
</footer>


<?php if ( is_active_sidebar( 'sidebar-7' ) ) : ?>

<?php endif; ?>

<?php endif; ?>

<?php get_footer(); ?>
