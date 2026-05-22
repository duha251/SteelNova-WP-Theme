<?php
$thumbnail_id = get_post_thumbnail_id($post->ID);  
$thumbnail_url = get_the_post_thumbnail_url($post->ID);   
extract( $display_args ); 
$content_class = $content_class ?? '';
?>
<article class="project project-<?php echo esc_attr( $post->ID . $active_class ); ?>" style="background-image: url(<?php echo esc_url($thumbnail_url); ?>)">
    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="box-link"></a>
    <div class="project__content<?php echo esc_attr( $content_class ); ?>">
        <div class="project__content-inner">
            <svg class="mask" width="90" height="90" viewBox="0 0 89 89" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 89L0 0C7 0 11 5 11 11V66C11 73 17 78 23 78H78C85 78 89 83 89 89H0.5Z" fill="white"/>
            </svg>
            <?php 
            $terms = get_the_terms($post->ID, 'project_category');
            if( $show_category == true && !empty($terms) && !is_wp_error($terms) ) : 
                echo '<div class="project__category categories">';
                    foreach ($terms as $term) {
                        echo '<a href="' . esc_url(get_term_link($term)) . '">';
                        echo '<span class="icon-dot"></span>';
                        echo esc_html($term->name);
                        echo '</a>';
                    }
                echo '</div>';
            endif;
            ?>
            <<?php echo esc_attr( $title_tag ); ?> class="project__title" data-hover="text-underline-slide">
                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                    <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                </a>
            </<?php echo esc_attr( $title_tag ); ?>>
            <div class="divider"></div>
            <?php if( $show_excerpt == true ) : ?>
                <p class="project__excerpt">
                    <?php echo wp_trim_words( $post->post_excerpt, $num_of_words, $more = null); ?>
                </p>
            <?php endif; ?>
            <?php 
                $project_info = get_post_meta($post->ID, 'project_info', true);
                if( is_array( $project_info ) && $show_meta == true ) :
                    $count = count( $project_info['redux_repeater_data'] ) ?? 0;
                    if( $count > 0 ) :
                        if( $num_of_meta > 0 && ( $num_of_meta < $count + 1 ) ) {
                            $count = $num_of_meta;
                        }
                        echo '<ul class="list project__meta">';
                        for( $i=0; $i<$count; $i++ ) : 
                            $label = $project_info['info_label'][$i] ?? '';
                            $text  = $project_info['info_text'][$i] ?? '';
                            $icon_url  = $project_info['info_icon'][$i]['url'] ?? '';
                            ?>
                            <li class="list__item">
                                <span class="list__item-icon d-inline-flex-center">
                                    <?php steelnova_print_svg_content( $icon_url ); ?>
                                </span>
                                <span class="list__item-value">
                                    <?php echo esc_html( $text ); ?>
                                </span>
                            </li>
                            <?php
                        endfor;
                        echo '</ul>';
                    endif;
                endif;
            ?>
            <?php if( $show_btn == true ) : ?>
                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="cs-button">
                    <span class="cs-button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M5.39401 0.251055C5.72875 -0.083685 6.27133 -0.083685 6.60607 0.251055L11.749 5.39398C12.0837 5.72872 12.0837 6.27132 11.749 6.60605L6.60607 11.749C6.27134 12.0837 5.72874 12.0837 5.39401 11.749C5.05928 11.4142 5.0593 10.8717 5.39401 10.5369L9.07372 6.85717H0.857149C0.38378 6.85717 3.49814e-05 6.47338 0 6.00002C2.76113e-08 5.52662 0.383759 5.14286 0.857149 5.14286H9.07372L5.39401 1.46312C5.05928 1.1284 5.0593 0.585797 5.39401 0.251055Z" fill="white"/>
                        </svg>
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</article>
