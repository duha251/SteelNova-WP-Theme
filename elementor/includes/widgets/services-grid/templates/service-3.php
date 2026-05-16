<?php

$thumbnail_url = get_the_post_thumbnail_url($post->ID);    
$features = get_post_meta( $post->ID, 'service_features', true ) ?: [];

$service_icon = get_post_meta( $post->ID, 'service_icon', true ) ?: '';

extract( $display_args ); 

?>
<div class="service" style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>);">
    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="box-link"></a>
    <div class="service__content">
        <div class="service__icon">
            <?php steelnova_print_svg_content( $service_icon['url'] ); ?>
        </div>
        <div class="divider"></div>
        <<?php echo esc_attr( $display_args['title_tag'] ); ?> class="service__title">
            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
            </a>
        </<?php echo esc_attr( $display_args['title_tag'] ); ?>>
    </div>
</div>
