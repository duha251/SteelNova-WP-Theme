<?php

$thumbnail_id = get_post_thumbnail_id($post->ID);    
$position = get_post_meta( $post->ID, 'member_role', true );
extract( $display_args ); 

?>
<div class="member">
    <div class="member__thumbnail">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php steelnova_print_image_by_size( $thumbnail_id, $img_width, $img_height ); ?>
        </a>
    </div>
    <div class="member__content">
        <<?php echo esc_attr( $title_tag ); ?> class="member__title">
            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
        <?php if( !empty( $position ) ) : ?>
            <div class="member__role">
                <?php echo esc_html( $position ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
