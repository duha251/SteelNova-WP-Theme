<?php
$thumbnail_id = get_post_thumbnail_id($post->ID);   
extract( $display_args ); 
?>
<article class="post post-<?php echo esc_attr( $post->ID ); ?>">
    <div class="post__featured-image">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php steelnova_print_image_by_size( $thumbnail_id, $img_width, $img_height ); ?>
        </a>
    </div>
    <div class="post__content">
        <?php if( $show_category == true ) : 
            echo '<div class="post__category categories">';
            $terms = get_the_terms($post->ID, 'category');
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<a href="' . esc_url(get_term_link($term)) . '">';
                    echo '<span class="icon-dot"></span>';
                    echo esc_html($term->name);
                    echo '</a>';
                }
            }    
            echo '</div>';
        ?>
        <?php endif; ?>
        <<?php echo esc_attr( $title_tag ); ?> class="post__title">
            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
        <?php if( $show_btn == true ) : ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-button cs-button--learn-details">
                <span class="cs-buton__text">
                    <?php echo esc_html( $btn_text ); ?>
                </span>
                <span class="cs-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M4.49501 0.209212C4.77396 -0.0697375 5.22611 -0.0697375 5.50506 0.209212L9.79083 4.49498C10.0697 4.77393 10.0697 5.2261 9.79083 5.50504L5.50506 9.79083C5.22612 10.0697 4.77395 10.0697 4.49501 9.79083C4.21607 9.51183 4.21608 9.05975 4.49501 8.78075L7.56143 5.71431H0.714291C0.319817 5.71431 2.91512e-05 5.39448 0 5.00002C2.30094e-08 4.60552 0.319799 4.28572 0.714291 4.28572H7.56143L4.49501 1.21927C4.21607 0.940333 4.21608 0.488164 4.49501 0.209212Z" fill="#0A1119"/>
                    </svg>
                </span>
            </a>
        <?php endif; ?>
    </div>
</article>
