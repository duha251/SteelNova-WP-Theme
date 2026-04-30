<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-categories',
        'data-layout' => '1'
    ], 
    $wrapper_attrs
);

if( $settings['show_divider'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' has-divider';
}

$this->add_render_attribute('wrapper', $wrapper_attrs);

$post_type = $settings['post_type'];

if( $post_type === 'product' && ! class_exists('WooCommerce') ) {
    echo '<div class="message">'.__('You need to install the WooCommerce plugin..', 'steelnova').'</div>';
    return;
}

$taxonomy = $post_type.'_category';

if( $post_type === 'product' ) {
    $taxonomy = 'product_cat';
}else if( $post_type === 'post' ) {
    $taxonomy = 'category';
}

$categories = $settings[$post_type.'_categories'];

if( empty( $categories ) ) {
    $categories = steelnova()->post_manager->get_cpt_category_list($taxonomy);
}

if( empty( $categories ) ) {
    echo '<div class="message">'.__('No Categories Found.', 'steelnova').'</div>';
    return;
}

?>

<ul <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
    <?php
        foreach ( $categories as $cat_id => $cat_label ) {

            $term = get_term( $cat_id, 'category' );

            if ( ! $term || is_wp_error( $term ) ) continue;

            $link = get_term_link( $term );
            $count = $term->count < 10 ? '0' . $term->count : $term->count;
        ?>
            <li class="category">
                <a href="<?php echo esc_url( $link ); ?>" class="category__link">
                    <span class="category__name">
                        <?php echo esc_html( $term->name ); ?>
                    </span>
                    <span class="category__count">
                        <?php echo esc_html( '(' . $count . ')' ); ?>
                    </span>
                </a>
            </li>
            <?php
        }
    ?>
</ul>