<?php
$thumbnail_id = get_post_thumbnail_id($post->ID);   
extract( $display_args ); 
?>
<article class="post post-<?php echo esc_attr( $post->ID ); ?>">
    <div class="post__featured-image" data-hover="zoom-in">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php steelnova_print_image_by_size( $thumbnail_id, $img_width, $img_height, [] ); ?>
        </a>
    </div>
    <div class="post__content">
        <?php if( $show_date == true || $show_category == true ) : ?>
            <div class="post__meta">
                <?php if( $show_date == true ) : ?>
                    <div class="post__meta-date">
                        <?php echo get_the_date( 'd M y', $post->ID ); ?>
                    </div>
                <?php endif; ?>
                <?php if( $show_category == true ) : ?>
                    <div class="categories post__meta-category">
                        <?php the_terms($post->ID, 'category', '', ''); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <<?php echo esc_attr( $title_tag ); ?> class="post__title" data-hover="text-underline-slide">
            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
        <?php if( $show_excerpt ) : ?>
            <p class="post__excerpt">
                <?php echo wp_trim_words( $post->post_excerpt, $num_of_words, $more = null); ?>
            </p>
        <?php endif; ?>
        <?php if( $show_btn == true ) : ?>
            <a href="" class="cs-button cs-button--primary">
                <span class="cs-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M5.39401 0.251055C5.72875 -0.083685 6.27133 -0.083685 6.60607 0.251055L11.749 5.39398C12.0837 5.72872 12.0837 6.27132 11.749 6.60605L6.60607 11.749C6.27134 12.0837 5.72874 12.0837 5.39401 11.749C5.05928 11.4142 5.0593 10.8717 5.39401 10.5369L9.07372 6.85717H0.857149C0.38378 6.85717 3.49814e-05 6.47338 0 6.00002C2.76113e-08 5.52662 0.383759 5.14286 0.857149 5.14286H9.07372L5.39401 1.46312C5.05928 1.1284 5.0593 0.585797 5.39401 0.251055Z" fill="white"/>
                    </svg>
                </span>
                <span class="cs-buton__text">
                    <?php echo esc_html( $btn_text ); ?>
                </span>
            </a>
        <?php endif; ?>
    </div>
</article>
