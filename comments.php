<?php
    if ( post_password_required() )
        return;
?>

<?php if ( comments_open() || '0' < get_comments_number() ) : ?>
<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h3 class="comments-title">
            <?php printf( _n( 'Um comentário', '%1$s comentários', get_comments_number(), 'historias' ), number_format_i18n( get_comments_number() ) ); ?>
            <?php if ( comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
                <a href="#respond"><?php printf( __('%s Leave a reply', 'historias' ), '<i class="fa fa-comment"></i>' ); ?></a>
        	<?php endif; ?>
        </h3>

        <ol class="comments-list">
            <?php wp_list_comments( array( 'callback' => 'historias_comment' ) ); ?>
        </ol><!-- /comments-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav role="navigation" id="comments-nav-below" class="navigation comments-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', 'historias' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( sprintf( __('%s Older comments', 'historias' ), '<i class="fa fa-arrow-left"></i>' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( sprintf( __('Newer comments %s', 'historias' ), '<i class="fa fa-arrow-right"></i>' ) ); ?></div>
        </nav><!-- /comments-navigation -->
        <?php endif; ?>

        <?php endif; ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', 'historias' ); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- /comments -->
<?php endif; ?>
