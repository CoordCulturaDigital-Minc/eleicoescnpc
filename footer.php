		</div><!-- /main -->



		<footer id="main-footer" class="span-24 site-footer">
			<div class="container">

				<div class="social">
					<ul class="social-links">
						<li class="twitter"><a href="https://twitter.com/culturagovbr" target="_blank" title="Twitter Cultura"><i class="fa fa-twitter"></i></a></li>
						<li class="facebook"><a href="https://www.facebook.com/MinisterioDaCultura" target="_blank" title="Facebook Cultura"><i class="fa fa-facebook"></i></a></li>
						<li class="instagram"><a href="https://instagram.com/culturagovbr/" target="_blank" title="Instagram Cultura"><i class="fa fa-instagram"></i></a></li>
						<li class="youtube"><a href="https://www.youtube.com/user/ministeriodacultura" target="_blank" title="Youtube Cultura"><i class="fa fa-youtube-square"></i></i></a></li>
						<li class="tumblr"><a href="http://culturagovbr.tumblr.com/" target="_blank" title="Tumblr Cultura"><i class="fa fa-tumblr"></i></a></li>
						<li class="flickr"><a href="https://www.flickr.com/photos/ministeriodacultura" target="_blank" title="Flickr Cultura"><i class="fa fa-flickr"></i></a></li>
					</ul>
				</div>

				<div class="logos">
					<div class="minc"><a href="http://www.cultura.gov.br" title="Ministério da Cultura - Governo Federal"><img src='<?php echo get_template_directory_uri(); ?>/images/minc-gov.png'/></a></div>
				</div>

				<p class="creditos">
					<span class="textleft">2015 &#169; Conselho Nacional de Política Cultural. Alguns direitos reservados.</br>
					Endereço: Esplanada dos Ministérios, Bloco B, 3º andar, CEP 70068-900, Brasília - Distrito Federal, Telefone: (61) 2024-2361/2302</a></span>
				</p>
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
