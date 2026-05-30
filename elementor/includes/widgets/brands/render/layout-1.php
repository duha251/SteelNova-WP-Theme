<?php

if ( ! class_exists( 'WooCommerce' ) ) {
    echo '<div class="message">' . esc_html__( 'You need to install the WooCommerce plugin..', 'steelnova' ) . '</div>';
    return;
}

$wrapper_attrs = array_merge(
    [
        'class' => 'cs-brands',
    ],
    $wrapper_attrs
);

if ( $settings['show_divider'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' has-divider';
}

$this->add_render_attribute( 'wrapper', $wrapper_attrs );

$taxonomy = 'product_brand';

$brands = get_terms(
    [
        'taxonomy'   => $taxonomy,
        'hide_empty' => true,
    ]
);

if ( empty( $brands ) || is_wp_error( $brands ) ) {
    echo '<div class="message">' . esc_html__( 'No Brands Found.', 'steelnova' ) . '</div>';
    return;
}

/**
 * Current URL for product filter.
 */
$current_url = home_url( add_query_arg( null, null ) );
$current_url = remove_query_arg( [ 'paged', 'product-page' ], $current_url );

/**
 * Get current active brand.
 */
$current_brand_slug = '';
$current_term_id    = 0;

if ( isset( $_GET['product_brand'] ) ) {
    $current_brand_slug = sanitize_text_field( wp_unslash( $_GET['product_brand'] ) );
}

if ( is_tax( $taxonomy ) ) {
    $current_term = get_queried_object();

    if ( $current_term && ! is_wp_error( $current_term ) && ! empty( $current_term->term_id ) ) {
        $current_term_id    = (int) $current_term->term_id;
        $current_brand_slug = $current_term->slug;
    }
}
?>

<ul <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php
    foreach ( $brands as $brand ) {
        /**
         * Product brand filter URL.
         * Example: /shop/?product_brand=lg
         */
        $link = add_query_arg(
            [
                'product_brand' => $brand->slug,
            ],
            $current_url
        );

        $count = $brand->count < 10 ? '0' . $brand->count : $brand->count;

        $is_active = ( $current_brand_slug === $brand->slug );

        $brand_classes = [
            'brand',
        ];

        if ( $is_active ) {
            $brand_classes[] = 'is-active';
        }
        ?>
            <li class="<?php echo esc_attr( implode( ' ', $brand_classes ) ); ?>">
                <div class="check-box"></div>

                <a
                    href="<?php echo esc_url( $link ); ?>"
                    class="brand__link"
                    <?php pxl_print_html( $is_active ? 'aria-current="page"' : '' ); ?>
                >
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