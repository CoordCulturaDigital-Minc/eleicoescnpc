
<?php
/**
 * The Template for displaying page 404.
 *
 * @package forunssetoriaiscnpc
 *
 */

get_header();
get_sidebar(); ?>

		<section class="content">

			
			<header>
				<h2 class="entry-title">Não encontrado</h2>
			</header>
			
			<div class="entry-content">
				<p>Parece que nada foi encontrado. Tente a pesquisa!</p>
				<?php get_search_form(); ?>
			</div>

		</section><!-- #content .site-content --><!-- #primary .content-area -->

<?php get_footer(); ?>
