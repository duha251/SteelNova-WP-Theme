<?php
$post_id = get_the_ID();

$author_id = get_post_field( 'post_author', $post_id );
$biography = get_the_author_meta( 'description', $author_id );

$social_list = steelnova()->get_theme_option('user_social_name', []);
?>

<div class="steelnova-post-author">
    <div class="steelnova-post-author__avatar">
        <?php steelnova_print_user_avatar( $author_id, $settings['avatar_size'] ?: 96 ); ?>
    </div>
    <div class="steelnova-post-author__info">
        <div class="steelnova-post-author__name">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="steelnova-post-author__link">
                <?php echo get_the_author_meta('display_name', $author_id); ?>
            </a>
        </div>
        <?php if ( ! empty( $biography ) ) : ?>
            <div class="steelnova-post-author__bio">
                <?php echo wp_kses_post( $biography ); ?>
            </div>
        <?php endif; ?>
        <?php if( !empty( $social_list ) ) : 
            $social_icons = steelnova()->get_theme_option('user_social_icon', []);    
        ?>
            <div class="steelnova-post-author__socials">
                <?php foreach ( $social_list as $i => $social ) : 
                    $id = sanitize_title($social); 
                    $meta_key = 'user_social_' . $id;
                    $social_url = get_the_author_meta( $meta_key, $author_id );

                    if ( ! empty( $social_url ) ) : ?>
                        <a href="<?php echo esc_url( $social_url ); ?>" class="steelnova-post-author__social-link" target="_blank" rel="noopener noreferrer">
                            <?php steelnova_print_svg_content( $social_icons[$i]['url'] ?? '' ); ?>
                        </a>
                <?php   
                    endif;
                endforeach; 
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>