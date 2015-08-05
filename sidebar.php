<?php

if ( is_active_sidebar( 'primary-widget-area' ) ) :

	?><div class="sidebar col-xs-12 col-md-4"><?php
	
	if ( is_active_sidebar( 'primary-widget-area' ) ) dynamic_sidebar( 'primary-widget-area' );
	
	?></div><?php

endif; ?>
