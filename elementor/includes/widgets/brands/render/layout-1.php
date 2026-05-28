<?php

if( ! class_exists('WooCommerce') ) {
    echo '<div class="message">'.__('You need to install the WooCommerce plugin..', 'steelnova').'</div>';
    return;
}

$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-brands',
    ], 
    $wrapper_attrs
);

if( $settings['show_divider'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' has-divider';
}

$this->add_render_attribute('wrapper', $wrapper_attrs);

$brands = get_terms([
    'taxonomy'   => 'product_brand',
    'hide_empty' => true,
]);

if( empty( $brands ) ) {
    echo '<div class="message">'.__('No Brands Found.', 'steelnova').'</div>';
    return;
}
?>

<ul <?php echo esc_attr( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php
        foreach ( $brands as $brand ) { 
            $count = $brand->count < 10 ? '0'.$brand->count : $brand->count;
        ?>
            <li class="brand">
                <div class="check-box"></div>
                <a href="<?php echo esc_url( get_term_link($brand) ); ?>" class="brand__link">
                    <span class="brand__name">
                        <?php echo esc_html( $brand->name ); ?>
                    </span>
                    <span class="brand__count">
                        <?php echo esc_html( '(' . $count . ')' ); ?>
                    </span>
                </a>
            </li>
            <?php
        }
    ?>
</ul>