		</div><!-- /main -->

		<footer id="site-footer" class="site-footer row">
				<div class="social col-xs-8 col-xs-offset-2">
					<a 	class="col-xs-2 text-center fa fa-twitter twitter"
						href="https://twitter.com/culturagovbr/" target="_blank" title="Twitter Cultura"></a>
					<a class="col-xs-2 text-center fa fa-facebook facebook"
						href="https://www.facebook.com/MinisterioDaCultura" target="_blank" title="Facebook Cultura"></a>
					<a class="col-xs-2 text-center fa fa-instagram instagram"
						href="https://instagram.com/culturagovbr/" target="_blank" title="Instagram Cultura"></a>
					<a class="col-xs-2 text-center fa fa-youtube-square youtube"
						href="https://www.youtube.com/user/ministeriodacultura/" target="_blank" title="Youtube Cultura"></i></a>
					<a class="col-xs-2 text-center fa fa-tumblr tumblr"
						href="http://culturagovbr.tumblr.com/" target="_blank" title="Tumblr Cultura"></a>
					<a class="col-xs-2 text-center fa fa-flickr flickr"
						href="https://www.flickr.com/photos/ministeriodacultura/" target="_blank" title="Flickr Cultura"></a>
				</div>
				
				<div class="logos col-xs-10 col-md-offset-1">

					<div class="col-md-4 col-xs-12">
						<div class="col-xs-12"><p>Desenvolvimento</p></div>
						<a class="col-xs-12" id="Cultura_digital" href="http://culturadigital.br" title="Cultura digital">
						<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/culturadigital_logo.png'/></a>
					</div>
					<div class="col-md-8 col-xs-12">
						<div class="col-xs-12"><p>Realização</p></div>
						<a class="col-md-4 col-xs-10 col-md-offset-1 text-center" id="CNPC" href="#" title="Conselho Nacional de Política Cultural">
						<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/CNPC_logo.png'/></a>
						<a class="col-md-6 col-xs-10 text-center" id="MinC" href="http://www.cultura.gov.br" title="Ministério da Cultura - Governo Federal">
						<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/MINC_logo.png'/></a>
					</div>
				</div>

				<div class="creditos col-md-6 col-xs-12 col-md-offset-3">
				<p class="text-center termos-de-uso"><a href="<?php bloginfo('url'); ?>/termos-de-uso">Termos de uso</a></p>
					<p class="text-center">2015 &#169; Conselho Nacional de Política Cultural.</p>
					<p class="text-center">Endereço: Esplanada dos Ministérios, Bloco B, 3º andar, CEP 70068-900, Brasília - Distrito Federal, Telefone: (61) 2024-2361/2302</p>
				</div>
		</footer> 
	</div><!-- /site-wrap -->

	<?php $mostra_query = new WP_Query( 'pagename=apoiadores' );
	if ( $mostra_query->have_posts() ) : ?>
		<div class="logos">
			<?php while( $mostra_query->have_posts()) : $mostra_query->the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div><!-- /logos -->
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<?php wp_footer(); ?>

	<script src="http://barra.brasil.gov.br/barra.js?cor=verde" type="text/javascript"></script>
</body>
</html>
