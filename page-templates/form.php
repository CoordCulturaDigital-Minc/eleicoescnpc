<?php
/**
 * Template name: Form
 *
 * @package forunssetoriaiscnpc
 */


get_header(); the_post(); ?>
	<div class="content  content--sidebarless">

		<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>') ?>
			</div><!-- /entry-content -->

			<div class="entry__form">
				<?php
				$options = get_post_meta($post->ID, "email", true);
				$nome = $_POST['nome'];
				$email = $_POST['email'];
				$mensagem = $_POST['mensagem'];
				$email_enviando = '<b>Autor:</b> <br />' . htmlspecialchars ($nome) . '<br />' . htmlspecialchars($email) . '<br /><br />' . '<b>Mensagem:</b>' . nl2br( htmlspecialchars($mensagem) );
				$new_nome = '';
				$new_email = '';
				$new_mensagem = '';

				$options == '' ? $email_do_historias = get_option('admin_email') : $email_do_historias = $options;

				if(isset($_POST['enviar'])):

					$email_s = wp_mail($email_do_historias, 'New message received', $email_enviando, 'Content-Type: text/html; charset=UTF-8;');

					if ($email_s == true) {

						echo "<p class='accept'>" . __('Email successfully sent!', 'historias') . "</p>";

					}if ($email_s == false) {
						echo "<p class='error'>" . __('Error sending email, please try again', 'historias') . "</p>";
						$new_nome = $nome;
						$new_email = $email;
						$new_mensagem = $mensagem;
					}
				endif;

				?>

				<form action="" id="contato-historias" method="post">
					<div class="form__item">
						<label for="mensagem"><?php _e('Message', 'historias'); ?></label>
						<textarea name="mensagem" rows="10"><?php echo $new_mensagem;?></textarea>
					</div>
					<div class="form__item">
						<label for="nome"><?php _e('Your Name', 'historias'); ?></label>
						<input type="text" name="nome" value="<?php echo $new_nome;?>" />
					</div>
					<div class="form__item">
						<label for="email"><?php _e('Your Email', 'historias'); ?></label>
						<input type="text" name="email" value="<?php echo $new_email;?>" />
					</div>
					<button type="submit" name="enviar" class="button"><?php _e( 'Send', 'historias' ); ?></button> <?php _e('to','historias'); ?> <?php echo $email_do_historias ?>
				</form>
			</div>
		</article><!-- /page-<?php the_ID(); ?> -->

	</div><!-- /content -->

<?php get_footer(); ?>
