<?php
/**
 * Template Name: Mostra itinerante
 *
 */

get_header(); the_post(); ?>

    <div class="content  content--sidebarless">

        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1 class="entry-title"><?php the_title(); ?></h1>

            <?php if ( has_excerpt() ) : ?>
                <div class="entry__summary">
                    <?php the_excerpt(); ?>
                </div><!-- /entry__sumary -->
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>') ?>
            </div><!-- /entry-content -->

            <?php $mostra = get_post_meta($post->ID, "latlng", false);
            if ($mostra[0]=="") : ?>

                <?php else : ?>
                <div style="display:none">
                    <?php $i = 1;

                    foreach($mostra as $mostra) :
                        list( $coordinates, $location, $details ) = explode( "\n", $mostra ); ?>
                        <div id="item<?php echo $i; ?>">
                            <h2 class="item__title"><?php echo $location; ?></h2>
                            <?php
                            // Agora, teremos uma div.item__details para cada item separado por pipe(|)
                            $details_list = explode( '|', $details );
                            if ( $details_list ) : foreach ( $details_list as $detail ) : ?>
                            <div class="item__details">
                                <?php echo $detail; ?>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    <?php $i++;

                    endforeach; ?>
                </div>

                <script>
                    var locations = [
                        <?php $mostra = get_post_meta($post->ID, "latlng", false);
                            if ($mostra[0]=="") : ?>

                        <?php else : ?>
                        <?php $i = 1; foreach($mostra as $mostra) : $mostra = nl2br( $mostra ); list( $coordinates, $location, $details ) = explode( '<br />', $mostra ); ?>
                            {latlng : new google.maps.LatLng<?php echo $coordinates; ?>,
                            info : document.getElementById('item<?php echo $i; ?>')},
                        <?php $i++; endforeach; endif; ?>
                    ];
                </script>

                <div id="map"></div>
            <?php endif; ?>

            
            <?php comments_template('', true); ?>

        </article><!-- /page-<?php the_ID(); ?> -->
    </div><!-- /content -->

<?php get_footer(); ?>
