<?php
/**
 * @package Case-Themes
 */
            wp_enqueue_script( 'comment-reply' );

if ( post_password_required() ) {
    return;
} ?>
<div id="comment" class="comment-area">
    <?php
    
    $comment_count = get_comments_number();
    if ( have_comments() ) : 
    ?>
        <div class="comment-wrapper">
            <h4 class="comment-title">
                <?php echo ($comment_count . ' Comments'); ?>
            </h4>
            <ul class="comment-list">
                <?php
                    wp_list_comments( array(
                        'style'      => 'ul',
                        'short_ping' => true,
                        'callback'   => array(steelnova()->customize, 'comment_list'),
                        'max_depth'  => 3
                    ) );
                ?>
            </ul>
            <?php the_comments_navigation(); ?>
        </div>
        <div class="divider"></div>
        <?php if ( !comments_open() ) : ?>
            <p class="no-comments"><?php _e( 'Comments are closed.', 'steelnova' ); ?></p>
        <?php
        endif;

    endif;
    $commenter = wp_get_current_commenter(); 
    $field_class = 'grid__item form-control grid__item-full';
    if( is_login() ) {
        $field_class = 'form-control';
    }
    $args = array(
        'id_form'           => 'commentform',
        'id_submit'         => 'submit',
        'class_submit'      => 'button button--primary',
        'title_reply'       => __( 'Make a Comment', 'steelnova'),
        'title_reply_to'    => __( 'Write your comment %s', 'steelnova'),
        'cancel_reply_link' => __( 'Cancel Comment', 'steelnova'),
        
        'submit_button'     => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">
                                    <span class="button__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M5.39401 0.251055C5.72875 -0.083685 6.27133 -0.083685 6.60607 0.251055L11.749 5.39398C12.0837 5.72872 12.0837 6.27132 11.749 6.60605L6.60607 11.749C6.27134 12.0837 5.72874 12.0837 5.39401 11.749C5.05928 11.4142 5.0593 10.8717 5.39401 10.5369L9.07372 6.85717H0.857149C0.38378 6.85717 3.49814e-05 6.47338 0 6.00002C2.76113e-08 5.52662 0.383759 5.14286 0.857149 5.14286H9.07372L5.39401 1.46312C5.05928 1.1284 5.0593 0.585797 5.39401 0.251055Z" fill="white"/>
                                        </svg>
                                    </span>
                                    <span class="button__text">
                                        '.__('Our Services Offer', 'steelnova').'
                                    </span>
                                </button>',
        'comment_notes_after' => '',
        'comment_notes_before' => '<p class="comment-note">' . __('Your email address will not be published. Required field are marked*', 'steelnova') . '</p>',
        
        'comment_field' => '<div class="form-control form-control--full">'.
                        '<textarea id="comment" name="comment" placeholder="'.esc_attr__('Your Comment...', 'steelnova').'" aria-required="true"></textarea>'.
                        '</div>',

        'fields' => array(
            'author' => '<div class="form-control">'.
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                        '" size="30" placeholder="'.esc_attr__('Your Name', 'steelnova').'"/></div>',

            'email' => '<div class="form-control">'.
                        '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
                        '" size="30" placeholder="'.esc_attr__('Email Address', 'steelnova').'"/></div>',
        ),
        

    );
    comment_form($args); ?>
</div>