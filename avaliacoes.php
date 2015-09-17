<?php
	global $current_user;

	$curators = get_users(array('role'=>'curador'));
	$curators_length = count($curators);

	$setorial = isset( $_POST['setorial'] ) ? $_POST['setorial'] : "arquitetura-urbanismo";

	if( current_user_can('curate') && !current_user_can('administrator') )
	    $setorial = get_user_meta( get_current_user_id(),'setorial_curate',true);

	$subscriptions = list_candidates_by_setorial(array('candidate-display-name',
											  'evaluation_of_candidate',
											  'subscription_number',
											  'admin_'.$current_user->ID.'_read'), true, $setorial);

	wp_enqueue_script('admin-avaliacoes', get_setoriaiscnpc_baseurl().'js/admin-avaliacoes.js', array('jquery'));
	wp_enqueue_script('tablesorter', get_setoriaiscnpc_baseurl().'js/jquery.tablesorter.min.js', array('jquery'));
	wp_localize_script('admin-avaliacoes', 'avaliacoes', array('ajaxurl' => admin_url('admin-ajax.php')));
?>

<?php get_header(); ?>

<section class="col-xs-12">
	<header>
		<h2 class="page__title">Candidatos avaliados</h2>
	</header>

    <?php if( !current_user_can('curate') || current_user_can('administrator') ) : ?>
        <form method="post" id="filter_setorial">    
            <label for="setorial">Selecione a setorial:</label>
            <?php echo dropdown_setoriais('setorial', $setorial, true) ?>
        </form>
    <?php endif; ?>
	
	<table class="js-sortable-table  inscritos--lista">
		<thead>
			<tr>
				<th>Candidato</th>
                <th>Setorial</th>
                <th>Estado</th>
				<th>Situação</th>
				<th>Observação</th>
			</tr>
		</thead>
		<tbody>
			<?php if( !empty($subscriptions) ) : ?>
				<?php foreach($subscriptions as $sub): $s_number=substr($sub['subscription_number'],0,8);?>
				<?php 	
					$user_id = get_post_field( 'post_author', $sub['pid'] );
					$user_candidate = array( 
						'user_name'=> get_user_meta($user_id, 'user_name', true),
						'setorial' => get_user_meta($user_id, 'setorial', true),
						'uf' 	   => get_user_meta($user_id, 'UF', true)
					);

					$e = load_evaluation($sub['pid'] );
		 		?>

				<tr class="">
					<td class="subscription__title">
						<a href="<?php echo site_url("inscricoes/".$s_number);?>"><?php echo $user_candidate['user_name'];?> <?php echo !empty($sub['candidate-display-name']) ? "(".$sub['candidate-display-name'].")" :'';?></a>
						
					</td>
	                <td>
	                    <?php echo get_label_setorial_by_slug($user_candidate['setorial']);?>
	                </td>
	                <td>
	                    <?php echo $user_candidate['uf'];?>
	                </td>
					<td>
					 	<?php echo isset( $e["evaluation-status"] ) ? label_status_candidate($e["evaluation-status"]) : '';  ?>  
					</td>
					<td>
					 	<?php echo isset( $e["remarks-comment"]) ? $e["remarks-comment"] : '';  ?>  
					</td>

				</tr>
				<?php endforeach; ?>

			<?php else : ?>
                <tr align="center">
                    <td colspan="6">Nenhum resultado</td>
                </tr>
            <?php endif; ?>
		</tbody>
	</table>

</section>
<?php get_footer(); ?>
