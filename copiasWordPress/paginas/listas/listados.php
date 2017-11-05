<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Template Name: Generación de Listas
 *
 * @file           listados.php
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

  <?php
    require('include/Conn.inc.php');

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


      <footer>
         Copyright &copy; 2017 por César Casasola Miranda
      </footer>


      <?php if ( is_active_sidebar( 'sidebar-7' ) ) : ?>

      <?php endif; ?>

    <?php endif; ?>

    <?php get_footer(); ?>
