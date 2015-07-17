<?php
    if ( post_password_required() )
        return;
?>

<?php if ( comments_open() || '0' < get_comments_number() ) : ?>
<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
    <?php 

    $args = array(
        'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
        '</label><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true">' .
        '</textarea></p>',
        'must_log_in' => '<p class="must-log-in">' .
        sprintf(
          __( 'Você precisa se <a href="%s">cadastrar</a> e/ou fazer <a href="%s">login</a> para comentar no fórum, participe!' ),
          site_url('/inscricoes/'),  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
        ) . '</p>',
        
        'comment_notes_before' => '<p class="comment-notes">' .
        __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
        '</p>',

        'comment_notes_after' => '<p class="form-allowed-tags">' .
        sprintf(
          __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
          ' <code>' . allowed_tags() . '</code>'
        ) . '</p>',

        'fields' => apply_filters( 'comment_form_default_fields', $fields ),
    );
     ?>

         <?php comment_form($args); ?>

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



   
</div><!-- /comments -->
<?php endif; ?>
