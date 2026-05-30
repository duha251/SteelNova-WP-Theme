<?php
$wrapper_attrs = array_merge(
    [
        'class' => 'cs-price-filter',
    ],
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );

/**
 * Get global product price range.
 * Do not use current min_price/max_price filters here,
 * otherwise the range will be clamped after page reload.
 */
global $wpdb;

$price_range = $wpdb->get_row(
    "
    SELECT
        FLOOR( MIN( lookup.min_price ) ) AS min_price,
        CEIL( MAX( lookup.max_price ) ) AS max_price
    FROM {$wpdb->wc_product_meta_lookup} AS lookup
    INNER JOIN {$wpdb->posts} AS posts
        ON lookup.product_id = posts.ID
    WHERE posts.post_type = 'product'
        AND posts.post_status = 'publish'
        AND lookup.min_price IS NOT NULL
        AND lookup.max_price IS NOT NULL
    "
);

$min_price = isset( $price_range->min_price ) ? absint( $price_range->min_price ) : 0;
$max_price = isset( $price_range->max_price ) ? absint( $price_range->max_price ) : 0;

$current_min = isset( $_GET['min_price'] ) ? absint( wp_unslash( $_GET['min_price'] ) ) : $min_price;
$current_max = isset( $_GET['max_price'] ) ? absint( wp_unslash( $_GET['max_price'] ) ) : $max_price;

if ( $current_min < $min_price ) {
    $current_min = $min_price;
}

if ( $current_max > $max_price ) {
    $current_max = $max_price;
}

if ( $current_min > $current_max ) {
    $current_min = $min_price;
    $current_max = $max_price;
}

$form_action = '';

if ( is_shop() ) {
    $form_action = get_permalink( wc_get_page_id( 'shop' ) );
} elseif ( is_product_taxonomy() ) {
    $queried_object = get_queried_object();

    if ( $queried_object && ! is_wp_error( $queried_object ) ) {
        $term_link = get_term_link( $queried_object );

        if ( ! is_wp_error( $term_link ) ) {
            $form_action = $term_link;
        }
    }
}

if ( empty( $form_action ) ) {
    $form_action = home_url( add_query_arg( null, null ) );
}
?>

<form
    method="get"
    action="<?php echo esc_url( $form_action ); ?>"
    <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>
>
    <div class="cs-price-filter__range">
        <span class="cs-price-filter__track"></span>
        <span class="cs-price-filter__progress"></span>

        <input
            class="cs-price-filter__input cs-price-filter__input--min"
            type="range"
            name="min_price"
            min="<?php echo esc_attr( $min_price ); ?>"
            max="<?php echo esc_attr( $max_price ); ?>"
            value="<?php echo esc_attr( $current_min ); ?>"
        >

        <input
            class="cs-price-filter__input cs-price-filter__input--max"
            type="range"
            name="max_price"
            min="<?php echo esc_attr( $min_price ); ?>"
            max="<?php echo esc_attr( $max_price ); ?>"
            value="<?php echo esc_attr( $current_max ); ?>"
        >
    </div>

    <?php
    foreach ( $_GET as $key => $value ) {
        if ( in_array( $key, [ 'min_price', 'max_price', 'paged', 'product-page' ], true ) ) {
            continue;
        }

        if ( is_array( $value ) ) {
            continue;
        }
        ?>
            <input
                type="hidden"
                name="<?php echo esc_attr( $key ); ?>"
                value="<?php echo esc_attr( wp_unslash( $value ) ); ?>"
            >
        <?php
    }
    ?>

    <div class="cs-price-filter__bottom">
        <button class="cs-price-filter__button" type="submit">
            <?php esc_html_e( 'FILTER', 'steelnova' ); ?>
        </button>

        <div class="cs-price-filter__price">
            <?php esc_html_e( 'Price:', 'steelnova' ); ?>

            <span class="cs-price-filter__price-min">
                <?php echo wp_kses_post( wc_price( $current_min ) ); ?>
            </span>

            -

            <span class="cs-price-filter__price-max">
                <?php echo wp_kses_post( wc_price( $current_max ) ); ?>
            </span>
        </div>
    </div>
</form>