<?php
$post_id = get_the_ID();

$author_id = get_post_field( 'post_author', $post_id );
$biography = get_the_author_meta( 'description', $author_id );
$position = get_the_author_meta( 'position', $author_id );

$social_list = steelnova()->get_theme_option('user_social_name', []);
?>

<div class="cs-post-author" data-layout="2">
    <div class="cs-post-author__avatar">
        <?php steelnova_print_user_avatar( $author_id, $settings['avatar_size'] ?: 96 ); ?>
    </div>
    <div class="cs-post-author__info">
        <h5 class="cs-post-author__name">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="cs-post-author__link">
                <?php echo get_the_author_meta('display_name', $author_id); ?>
            </a>
        </h5>
        <div class="cs-post-author__position">
            <?php echo esc_html( $position ); ?>
        </div>
        <div class="divider"></div>
        <?php if ( ! empty( $biography ) ) : ?>
            <div class="cs-post-author__bio">
                <?php echo wp_kses_post( $biography ); ?>
            </div>
        <?php endif; ?>
        <?php if( !empty( $social_list ) ) : 
            $social_icons = steelnova()->get_theme_option('user_social_icon', []);    
        ?>
            <div class="cs-post-author__socials">
                <?php foreach ( $social_list as $i => $social ) : 
                    $id = sanitize_title($social); 
                    $meta_key = 'user_social_' . $id;
                    $social_url = get_the_author_meta( $meta_key, $author_id );

                    if ( ! empty( $social_url ) ) : ?>
                        <a href="<?php echo esc_url( $social_url ); ?>" class="cs-post-author__social-link" target="_blank" rel="noopener noreferrer">
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