<?php
	global $current_user;

	$curators = get_users(array('role'=>'curador'));
	$curators_length = count($curators);

	$subscriptions = list_subscriptions(array('project-title',
											  'director-name',
											  'director-region',
											  'company-name',
											  'subscription_number',
											  'admin_'.$current_user->ID.'_read'));

	wp_enqueue_script('admin-avaliacoes', get_setoriaiscnpc_baseurl().'js/admin-avaliacoes.js', array('jquery'));
	wp_enqueue_script('tablesorter', get_setoriaiscnpc_baseurl().'js/jquery.tablesorter.min.js', array('jquery'));
	wp_localize_script('admin-avaliacoes', 'avaliacoes', array('ajaxurl' => admin_url('admin-ajax.php')));
?>

<?php get_header(); ?>

<section class="col-xs-12">
	<header>
		<h2 class="page__title">Incrições avaliadas</h2>
	</header>
	
	<table class="js-sortable-table  inscritos--lista">
		<thead>
			<tr>
				<th>Projeto</th>
                <th>Região</th>
				<?php foreach($curators as $c): $name=get_user_meta($c->ID, 'first_name', true); ?>
					<th class="subscription__curator">
						<?php echo $name?$name:preg_replace('/@.+$/','',$c->display_name);?>
					</th>
				<?php endforeach; ?>
				
				<th>Médias</th>
				<th>Total</th>
				<th>Lido</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($subscriptions as $sub): $s=$sl=$n=$nl=$a=$al=0; $s_number=substr($sub['subscription_number'],0,8);?>
			<tr class="">
				<td class="subscription__title">
					<a href="<?php echo site_url("inscricoes/".$s_number);?>"><?php echo $sub['project-title'];?></a>
					<br/><small>de <?php echo $sub['director-name'];?></small>
				</td>
                <td>
                    <?php echo $sub['director-region'];?>
                </td>
				<?php foreach($curators as $c): $e = load_evaluation($sub['pid'], $c->ID);  ?>
					<td class="subscription__evaluation">
						<a href="<?php echo site_url("avaliacoes/$s_number/reviewer/{$c->ID}");?>" title="(Mérito / Viabilidade / Qualificação)"><?php echo sprintf('%d / %d / %d', $e["synopsis-score"], $e["notes-score"], $e["arguments-score"] ); ?></a>
					</td>

					<?php 
                    
                    $s += $e["synopsis-score"]; $n += $e["notes-score"]; $a += $e["arguments-score"]; 
                    
                    if ($e["synopsis-score"] > 0) $sl ++;
                    if ($e["notes-score"] > 0) $nl ++;
                    if ($e["arguments-score"] > 0) $al ++;
                    
                    ?>
                    
                    
                    
				<?php endforeach; ?>
				<?php if ($curators_length): ?>
                    <?php /* médias */ 
                    
                    if ($sl > 0) $s /= $sl; 
                    if ($nl > 0) $n /= $nl; 
                    if ($al > 0) $a /= $al; ?>
                <?php endif; ?>

				<td><?php printf("%.2f / %.2f / %.2f", $s, $n, $a);?></td>
				<td><?php printf("%.2f",$s + $n + $a);?></td>
				<td class="subscription__status">
					<input type="checkbox" name="read" value="<?php echo $s_number;?>"<?php echo $sub['admin_'.$current_user->ID.'_read']?' checked':'';?> />
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</section>
<?php get_footer(); ?>
