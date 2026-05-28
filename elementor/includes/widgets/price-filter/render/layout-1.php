<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-price-filter',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute('wrapper', $wrapper_attrs);

$min_price = steelnova()->woo->get_price_range()['min'];
$max_price = steelnova()->woo->get_price_range()['max'];

$current_min = isset($_GET['min_price']) ? absint($_GET['min_price']) : $min_price;
$current_max = isset($_GET['max_price']) ? absint($_GET['max_price']) : $max_price;
?>

<div <?php echo esc_attr( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
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

    <div class="cs-price-filter__bottom">
        <button class="cs-price-filter__button" type="submit">
            <?php esc_html_e( 'FILTER', 'steelnova' ); ?>
        </button>

        <div class="cs-price-filter__price">
            <?php esc_html_e( 'Price:', 'steelnova' ); ?>
            <span class="cs-price-filter__price-min">
                <?php echo wc_price( $current_min ); ?>
            </span>
            -
            <span class="cs-price-filter__price-max">
                <?php echo wc_price( $current_max ); ?>
            </span>
        </div>
    </div>
</div>
