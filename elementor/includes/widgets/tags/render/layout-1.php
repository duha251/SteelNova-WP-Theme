<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-tags',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute('wrapper', $wrapper_attrs);

$post_type = $settings['post_type'];

if( $post_type === 'product' && ! class_exists('WooCommerce') ) {
    echo '<div class="message">'.__('You need to install the WooCommerce plugin.', 'steelnova').'</div>';
    return;
}

$tags = $settings[$post_type.'_tags'];

$taxonomy = $post_type.'_tag';


if( empty( $tags ) ) {
    $tags = steelnova()->post_manager->get_cpt_tag_list( $taxonomy );
}


?>

<ul <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
    <?php
        foreach ( $tags as $tag_id => $tag_name ) {

            $term = get_term( $tag_id, $taxonomy ); 

            if ( ! $term || is_wp_error( $term ) ) continue;

            $link = get_term_link( $term );
        ?>
            <li class="tag">
                <a href="<?php echo esc_url( $link ); ?>" class="tag__link">
                    <?php echo esc_html( $term->name ); ?>
                </a>
            </li>
            <?php
        }
    ?>
</ul>