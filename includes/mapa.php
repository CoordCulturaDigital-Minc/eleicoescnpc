<div id="mapa">
	
	<?php include '../assets/mapa_do_brasil.svg'; ?>

    <?php if( function_exists('get_setoriais') ) : $setoriais = get_setoriais(); ?>

        <div class="menu-setoriais-container">
            <div class="menu-head">
                <h2 class="menu-title">Setoriais</h2>
            </div>
            <ul id="menu-setoriais" class="menu">
                <?php foreach ($setoriais as $key => $setorial) : ?>
                    <li><a id="<?php echo $key; ?>" href="#<?php echo $key ?>"><?php echo $setorial ?></a></li>
                <?php endforeach; ?>
        
            </ul>
        </div>
        
    <?php endif ?>
</div>
