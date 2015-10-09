<?php
	global $current_user;

	if( (!current_user_can('curate') && !current_user_can('administrator') ) && !can_show_invalid_candidates() ) {
        wp_redirect(site_url('/'));
    }

	$curators = get_users(array('role'=>'curador'));
	$curators_length = count($curators);
	$setorial_default = "arquitetura-urbanismo";

	// verifica se foi passado alguma setorial 
	$setorial = isset( $_POST['setorial'] ) ? $_POST['setorial'] : "";

	//se for curador e não admin
	if( current_user_can('curate') && !current_user_can('administrator') ) {
	    
	    $setorial_curate =  get_user_meta( get_current_user_id(),'setorial_curate',true);
		
		// se o curador tiver setorial definida
		if( !empty( $setorial_curate  ) ) {
			
			$setorial = $setorial_curate; // adiciona setorial definida para o usuário

		}else if( isset( $_REQUEST['setorial_curate'] ) && empty( $setorial ) ) { // se existe setorial na requisicao e nenhum setorial foi passada

			$setorial = $_REQUEST['setorial_curate'];

		}else if( empty( $setorial ) ) {
			$setorial = $setorial_default; // setorial padrão
		}
	}

	if( empty( $setorial ) ) {
		$setorial = $setorial_default; // setorial padrão
	}

	$candidates = get_id_candidates_by_setorial( true, $setorial);

	wp_enqueue_script('admin-avaliacoes', get_setoriaiscnpc_baseurl().'js/admin-avaliacoes.js', array('jquery'));
	wp_enqueue_script('tablesorter', get_setoriaiscnpc_baseurl().'js/jquery.tablesorter.min.js', array('jquery'));
	wp_localize_script('admin-avaliacoes', 'avaliacoes', array('ajaxurl' => admin_url('admin-ajax.php')));
?>

<?php get_header(); ?>

<section class="col-xs-12">
	<header>
		<h3 class="page__title text-center">Lista de Habilitados e inabilitados CNPC</h3>
		<br>
	</header>

    <?php if( ( current_user_can('curate') &&  empty( $setorial_curate ) )  || current_user_can('administrator') || can_show_invalid_candidates() ) : ?>

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
			<?php if( !empty($candidates) ) : ?>

				<?php foreach($candidates as $pid):?>
				<?php 	
					$candidate = get_candidate( $pid );
		 		?>

				<tr class="">
					<td class="subscription__title">
						<?php if( current_user_can('curate') ): ?>
							<a href="<?php echo site_url("inscricoes/".$candidate['subscription_number']);?>"><?php echo $candidate['user_name'];?> <?php echo !empty($candidate['candidate-display-name']) ? "(".$candidate['candidate-display-name'].")" :'';?></a>
						<?php else : ?>
							<?php echo $candidate['user_name'];?> <?php echo !empty($candidate['candidate-display-name']) ? "(".$candidate['candidate-display-name'].")" :'';?>
						<?php endif; ?>
					</td>
	                <td>
	                    <?php echo get_label_setorial_by_slug($candidate['setorial']);?>
	                </td>
	                <td>
	                    <?php echo $candidate['UF'];?>
	                </td>
					<td>
					 	<?php echo isset( $candidate["evaluation-status"] ) ? label_status_candidate($candidate["evaluation-status"]) : '';  ?>  
					</td>
					<td>
					 	<?php echo isset( $candidate["remarks-comment"]) ? $candidate["remarks-comment"] : '';  ?>  
					</td>
				</tr>

				<?php $data[] = [
					(isset( $candidate['user_name'] ) ? $candidate['user_name'] : ''),
				    (isset( $candidate['candidate-display-name'] ) ? $candidate['candidate-display-name'] : ''),
				    (isset( $candidate['setorial'] ) ? get_label_setorial_by_slug($candidate['setorial']) : ''),
				    (isset( $candidate['UF'] ) ? $candidate['UF'] : ''),
				    (isset( $candidate["evaluation-status"] ) ? label_status_candidate($candidate["evaluation-status"]) : ''),
				    (isset( $candidate["remarks-comment"]) ? $candidate["remarks-comment"] : '')
				]; ?>    
				<?php endforeach; ?>

			<?php else : ?>
                <tr align="center">
                    <td colspan="6">Nenhum resultado</td>
                </tr>
            <?php endif; ?>
		</tbody>
	</table>

	<?php if( current_user_can('curate') ) : ?>
	 <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_setorial' data_csv='<?php echo json_encode($data) ?>'>
       </iframe>
    <?php endif; ?>
</section>
<?php get_footer(); ?>
