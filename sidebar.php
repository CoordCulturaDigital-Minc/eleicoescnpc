<?php

if ( is_active_sidebar( 'primary-widget-area' ) ) :

	?><div class="widget-area"><?php
	
	if ( is_active_sidebar( 'primary-widget-area' ) ) dynamic_sidebar( 'primary-widget-area' );
	
	?></div><?php

endif; ?>
