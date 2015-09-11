<footer id="site-footer" class="site-footer row">
	<div class="
		social
		col-sm-8 col-sm-offset-2
		col-xs-12
		">
		<a 	class="col-sm-2 col-xs-4 text-center fa fa-twitter twitter"
			href="https://twitter.com/culturagovbr/" target="_blank" title="Twitter Cultura"></a>
		<a class="col-sm-2 col-xs-4 text-center fa fa-facebook facebook"
			href="https://www.facebook.com/MinisterioDaCultura" target="_blank" title="Facebook Cultura"></a>
		<a class="col-sm-2 col-xs-4 text-center fa fa-instagram instagram"
			href="https://instagram.com/culturagovbr/" target="_blank" title="Instagram Cultura"></a>
		<a class="col-sm-2 col-xs-4 text-center fa fa-youtube-square youtube"
			href="https://www.youtube.com/user/ministeriodacultura/" target="_blank" title="Youtube Cultura"></i></a>
		<a class="col-sm-2 col-xs-4 text-center fa fa-tumblr tumblr"
			href="http://culturagovbr.tumblr.com/" target="_blank" title="Tumblr Cultura"></a>
		<a class="col-sm-2 col-xs-4 text-center fa fa-flickr flickr"
			href="https://www.flickr.com/photos/ministeriodacultura/" target="_blank" title="Flickr Cultura"></a>
	</div>
	
	<div class="
		logos
		col-xs-12
		">
		<div class="
			col-sm-4
			col-xs-12
			">
			<div class="col-xs-12"><p>Desenvolvimento</p></div>
			<a class="
				col-sm-12
				col-xs-10 col-xs-offset-1
				" id="Cultura_digital" href="http://culturadigital.br" title="Cultura digital">
				<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/culturadigital_logo.png'/>
			</a>
		</div>
		
		<div class="
			col-sm-8
			col-xs-12
			">
			<div class="col-xs-12"><p>Realização</p></div>
			<a class="
				col-sm-4 col-sm-offset-1
				col-xs-8 col-xs-offset-2
				text-center
				" id="CNPC" href="#" title="Conselho Nacional de Política Cultural">
				<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/CNPC_logo.png'/>
			</a>
			<a class="
				col-sm-4 col-sm-offset-2
				col-xs-8 col-xs-offset-2
				text-center" id="MinC" href="http://www.cultura.gov.br" title="Ministério da Cultura - Governo Federal">
			<img class="img-responsive" src='<?php echo get_template_directory_uri(); ?>/images/MINC_logo.png'/>
			</a>
		</div>
	</div>

	<div class="
		creditos
		col-xs-12
		text-center
		">
		<p><a href="<?php bloginfo('url'); ?>/termos-de-uso">Termos de uso</a></p>
		<p>2015 &#169; Conselho Nacional de Política Cultural.</p>
		<p>Endereço: Esplanada dos Ministérios, Bloco B, 3º andar, CEP 70068-900, Brasília - Distrito Federal, Telefone: (61) 2024-2336/2335/2186</p>
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

<!— Piwik —>
<script type="text/javascript">
 var _paq = _paq || [];
 _paq.push(["trackPageView"]);
 _paq.push(["enableLinkTracking"]);

 (function() {
 var u=(("https:" == document.location.protocol) ? "https" : "http") + "://analise.cultura.gov.br/";
 _paq.push(["setTrackerUrl", u+"piwik.php"]);
 _paq.push(["setSiteId", "17"]);
 var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
 g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
 })();
</script>
<!— End Piwik Code —>

<?php wp_reset_postdata(); ?>

<?php wp_footer(); ?>
<script src="http://barra.brasil.gov.br/barra.js?cor=verde" type="text/javascript"></script>
</body></html>
