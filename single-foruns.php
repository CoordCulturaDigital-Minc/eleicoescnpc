<?php
/**
 * The Template for displaying all single posts.
 *
 * @package forunssetoriaiscnpc
 *
 */

get_header(); ?>

	<section class="content content-full">

		<?php while ( have_posts() ) : the_post(); ?>

				<h2 class="entry-title"><?php the_title(); ?></h2>
				
				<?php // Lista de candidatos ?>
				<?php 
				$uf = substr($post->post_name, 0, 2);
				
				$setorial = substr($post->post_name, 3);
				
				$candidates = Foruns::get_candidates($uf, $setorial);
				
				$original_post = $post;
				?>
				<div class="candidates">
					<?php if ($candidates->have_posts()):  ?>
					<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>
					
						<div class="candidate" id="<?php the_ID(); ?>">
							<div class="candidate-avatar">
								<?php $avatar_file_id = get_post_meta(get_the_ID(), 'candidate-avatar', true); ?>
								<?php echo wp_get_attachment_image($avatar_file_id, 'avatar_candidate'); ?>
							</div>

							<div class="candidate-text">					
								<div class="candidate-name"><?php echo get_post_meta(get_the_ID(), 'candidate-display-name', true); ?></div>
								<div class="candidate-resume"></div>
							
								<?php // mais detalhes do candidato aqui ?>
								<a class="show-candidate-details" data-candidate-id="<?php the_ID(); ?>">Saiba +</a>
							</div>
							<div class="candidate-details" id="candidate-details-<?php the_ID(); ?>">
								<p>Experiência:<?php echo get_post_meta(get_the_ID(), 'candidate-experience', true); ?></p>
								<p>Defesa do candidato:<?php echo get_post_meta(get_the_ID(), 'candidate-explanatory', true); ?></p>
							</div>
							
							<br />
							
							<?php if (is_votacoes_abertas() && current_user_can_vote_in_project(get_the_ID())): ?>
								<a class="vote" id="vote-for-<?php the_ID(); ?>" data-project_id="<?php the_ID(); ?>">
									<?php if (get_current_user_vote() == get_the_ID()): ?>
										Voto registrado
									<?php else: ?>
										Votar
									<?php endif; ?>
									
								</a>
							<?php endif; ?>
							
							<?php if (current_user_can('administrator')): ?>
								Número de votos desse candidato: <?php echo get_number_of_votes_by_project(get_the_ID()); ?>
							<?php endif; ?>
						
						</div>
					
					<?php endwhile; ?>
					<?php else: // colocar botão para cadastro ?>
						Nenhum candidato nesta setorial e neste estado


					<?php endif; ?>
					
					<?php $post = $original_post; ?>
				</div>
				<div class="clearfix"></div>
				<?php // Discussão ?>
				<h2>Debate</h2>
				
				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
				?>
			
			
		<?php endwhile; // end of the loop. ?>	
	</section><!-- #content .site-content --><!-- #primary .content-area -->

<?php get_footer(); ?>
