<?php

$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-post-tags',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute('wrapper', $wrapper_attrs);
$post_type = get_post_type();
$tag_slug = $post_type . '_tag';
?>

<div <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php the_terms( get_the_ID(), $tag_slug, '', ''); ?>
    <?php if( $post_type === 'pxl-template' ) : ?>
        <a href="#"><?php echo esc_html__( 'Demo', 'steelnova' ); ?></a>
        <a href="#"><?php echo esc_html__( 'Preview', 'steelnova' ); ?></a>
        <a href="#"><?php echo esc_html__( 'Template', 'steelnova' ); ?></a>
    <?php endif; ?>
</div>