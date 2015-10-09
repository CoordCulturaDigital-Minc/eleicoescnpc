<?php
/**
 * The Template for displaying all single posts.
 *
 * @package forunssetoriaiscnpc
 *
 */

get_header(); ?>

	<section class="col-xs-12">

		<?php while ( have_posts() ) : the_post(); ?>
				<?php // Lista de candidatos ?>
				<?php

				$uf = substr($post->post_name, 0, 2);

				$setorial = substr($post->post_name, 3);

				$candidates = Foruns::get_candidates($uf, $setorial);

				$forum_uf_setorial = strtoupper($uf).'-'.$setorial;
				
				$original_post = $post;

				$current_user_ID = get_current_user_id();

				?>
			
				<header>
					<div class="section-description">
						<!-- <p>Olá <strong><?php echo user_short_name(); ?>!</strong> Este é o fórum de debates do Setorial de <strong><?php echo substr($post->post_title, 4); ?> </strong>do estado <strong><?php echo get_state_name_by_uf( substr($post->post_title, 0, 2) ); ?></strong>.</p> -->
						<?php if( is_user_this_uf_setorial($post->post_name) ) : ?>
							<p><?php echo nl2br(get_theme_option('txt_forum_is_voter')); ?></p>
						<?php else: ?>
							<p><?php echo nl2br(get_theme_option('txt_forum_is_not_voter')); ?></p>
						<?php endif; ?>
						<p>
						<?php echo nl2br(get_theme_option('txt_forum')); ?></p>
					</div>

					<h2 class="entry-title">Setorial de <?php echo substr($post->post_title, 4); ?> <?php echo show_text_state_by_uf($uf); ?></h2>
					<h1 class="entry-title-candidate">Candidatos(as)</h1>
				</header>

				<?php if ($candidates->have_posts()):  ?>
					<div class="candidates-content">
						<div class="loading">
							<h2>Carregando...</h2>
						</div>

						<div class="candidates" >

							<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>

								<?php

									$candidate_meta = array_map( function( $a ){ return $a[0]; }, get_post_meta( get_the_ID() ) );

									$candidate_id 			= get_post_field( 'post_author', get_the_ID() );
									$candidate_user      	= get_userdata( $candidate_id );
									$candidate_uf_setorial 	= get_user_meta($candidate_id, 'uf-setorial', true);
									
									$candidate_class = '';
									
									$candidacy_removed 		 = false;
									$is_candidate_elected    = false;
									$is_candidate_invalid 	 = false;
									// $show_invalid_candidates = false;

									$e = array();

									if( $candidate_uf_setorial !== $forum_uf_setorial ) {
										$candidacy_removed = true;
										$candidate_class = 'candidate_disabled';
									}

									if( can_show_elected_candidates() ) {
										if( get_post_meta(get_the_ID(), 'elected-candidate', true) ) {
											$is_candidate_elected = true;
											$candidate_class = 'candidate_elected';
										}
									}

									if( can_show_invalid_candidates() ) {

										// $show_invalid_candidates = true;

										$e = load_evaluation( get_the_ID() );

										if( $e["evaluation-status"] == 'invalid' ) {
											$is_candidate_invalid = true;
											$candidate_class = 'candidate_disabled';
										}
									}

									if( strlen($candidate_meta['candidate-display-name']) < 1 ) {
										$candidate_meta['candidate-display-name'] = get_user_meta($candidate_id, 'user_name', true);
									}
									
								 ?>

								<div class="candidate <?php echo (get_current_user_vote() == get_the_ID()) ? 'voted':''; ?> <?php echo $candidate_class; ?>" id="<?php the_ID(); ?> ">
									<div class="candidate-avatar" data-candidate-id="<?php the_ID(); ?>">
										<?php echo wp_get_attachment_image($candidate_meta['candidate-avatar'], 'avatar_candidate', 'avatar_candidate'); ?>
									</div>

									<div class="candidate-text">
										
										<div class="candidate-name"><span><?php echo $candidate_meta['candidate-display-name']; ?></span></div>
										<!-- <div class="candidate-resume"></div> -->

										<?php // mais detalhes do candidato aqui ?>
										<a class="show-candidate-details" data-candidate-id="<?php the_ID(); ?>">+</a>


										<?php if ( ( !$candidacy_removed && can_show_elected_candidates() ) || current_user_can('administrator') ): ?>
											<div class="number_votes">Votos: <span><?php echo get_number_of_votes_by_project(get_the_ID()); ?></span></div>
										<?php endif; ?>
									
									</div>

									<div class="candidate-details dialog" id="candidate-details-<?php the_ID(); ?>">
										
										<i class="fa fa-times close"></i>

										<div class="candidate-avatar" align="center">
											<?php echo wp_get_attachment_image($candidate_meta['candidate-avatar'], 'avatar_candidate', 'avatar_candidate'); ?>
										</div>

										<h2 class="candidate-name"><?php echo $candidate_meta['candidate-display-name']; ?></h2>
										
										<?php if( !$candidacy_removed ) : ?>

											<?php if( $is_candidate_invalid ) : ?>
												<?php if( $current_user_ID == $candidate_id ) : ?>
													<br>
													<p>Sua candidatura foi inabilitada. Se desejar envie recurso para o e-mail <a href="<?php echo site_url('/fale-conosco'); ?>">votacultura@cultura.gov.br</a> até o dia 14/10/2015.</p>
													<p><a href="http://cultura.gov.br/votacultura/wp-content/uploads/2015/10/FORMULARIO-DE-RECURSO-ELEICOES-CNPC-2015.docx">Baixe o formulário aqui.</a>
													<p>Motivo: <?php echo isset( $e["remarks-comment"]) ? $e["remarks-comment"] : '';  ?></p>
												<?php else : ?>
													<br>
													<p>Este(a) candidato(a) foi inabilitado(a).</p>
													<p>Motivo: <?php echo isset( $e["remarks-comment"]) ? $e["remarks-comment"] : '';  ?></p>

												<?php endif; ?>


											<?php else : ?>
												<p><h3>Defesa do candidato:</h3><?php echo $candidate_meta['candidate-explanatory']; ?></p>
												<p><h3>Experiência:</h3><?php echo $candidate_meta['candidate-experience']; ?></p>
											<?php endif; ?>
										<?php else: ?>
											<br>
											<p>Este candidato removeu a candidatura desta setorial.</p>
											<p>Visitar <a href="<?php echo site_url('/foruns/'.$candidate_uf_setorial) ?>">fórum atual</a> deste candidato</p>
										<?php endif; ?>
									</div>

									<br />
									<?php if( !$candidacy_removed ) : ?>

										<?php if (is_votacoes_abertas() && is_user_logged_in() /*&& current_user_can_vote_in_project( get_the_ID() ) */): ?>

												<?php if ( get_current_user_vote() == get_the_ID() ): ?>
													<a class="vote voted" id="vote-for-<?php the_ID(); ?>" data-project_id="<?php the_ID(); ?>">
													Voto registrado
													</a>
												<?php else : ?>
													<a class="vote" id="vote-for-<?php the_ID(); ?>" data-project_id="<?php the_ID(); ?>">
													Votar
													</a>
												<?php endif; ?>

										<?php endif; ?>
										
										<?php if( $is_candidate_elected ) : ?>
											<div class="candidate__elected text-center">Candidato(a) eleito(a)</div>
										<?php elseif( $is_candidate_invalid  ) : ?>
											<div class="candidate__disabled text-center">Candidato(a) Inabilitado(a)</div>
										<?php endif; ?>
									<?php else: ?>
										<div class="candidate__disabled text-center">Esta candidatura foi retirada</div>
									<?php endif; ?>						

								</div>
							<?php endwhile; ?>

						</div>
						<div class="navigation"></div>
					</div><!--candidates-content -->
				<?php else: // colocar botão para cadastro ?>
					<div class="candidate-not-found row">
						<div class="col-md-3 text-center">
							<i class="fa fa-question"></i>
						</div>
						<div class="col-md-9">
							<div class="col-md-12">
								<p>Ainda não há candidatos(as)<?php echo ( is_user_this_uf_setorial( $post->post_name ) ) ? ', deseja se candidatar?' : '!'; ?></p>
							</div>

							<?php if( is_user_this_uf_setorial($post->post_name) ) : ?>

								<div class="col-md-11">
									<a href="<?php echo site_url('/inscricoes/'); ?>" id="registrar" class="button alignright">Candidatar</a>
								</div>
					
							<?php elseif( is_user_logged_in() ) : ?>
								<div class="col-md-11">
									<a href="<?php echo get_link_forum_user(); ?>" id="return_forum" class="button alignright">Ir para o meu fórum</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if (is_votacoes_abertas() && !is_user_logged_in()) : ?>
					<div class="text-center">
						<p>Para votar você precisa se <a href="<?php echo site_url('/inscricoes/'); ?>" title="Inscrever">inscrever</a> e/ou fazer <a href="<?php echo wp_login_url( $_SERVER['REQUEST_URI'] ); ?>" title="login">login</a>.</p>
					</div>
					
				<?php endif; ?>

				<div class="clearfix"></div>
				<br>
				<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
					<div class="text-center social-share">
						<h3>Compartilhe</h3>
						<br>
						<?php //ADDTOANY_SHARE_SAVE_KIT(); ?>

						<?php 
						if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
					        echo '<div class="addtoany_list_container">';
					            ADDTOANY_SHARE_SAVE_KIT( array( 'linkname' => "Acesse Setorial de" . substr($original_post->post_title, 4) . " " . show_text_state_by_uf($uf), 'linkurl' => wp_get_shortlink($original_post->ID) ));
					        echo '</div>';
					    } ?>
					</div>
				<?php endif; ?>

				<?php $post = $original_post; ?>
			
			
				<div class="clearfix"></div>
				<?php // Discussão ?>
				<br><br>
				<h2 class="forum-title">Fórum de Debates</h2>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				 if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
				?>
		<?php endwhile; // end of the loop. ?>

	</section><!-- #content .site-content --><!-- #primary .content-area -->

<?php get_footer(); ?>

