<?php
if( ! class_exists('WooCommerce') ) {
    echo '<div class="message">'.__('You need to install the WooCommerce plugin.', 'steelnova').'</div>';
    return;
}

$post_ids = $settings['ids'];
$cat_ids  = $settings['categories'] ?? [];

$query_args = [
    'posts_per_page' => $settings['posts_per_page'] ?: 6,
    'orderby'        => $settings['orderby'],
    'order'          => $settings['order'],
    'query_type'     => $settings['query_type'] ?? 'recent',
];

if( !empty( $post_ids ) ) {
    $query_args['post__in'] = $post_ids;
    $query_args['orderby']  = 'post__in';
}

if( !empty( $cat_ids ) ) {
    $query_args['tax_query'][] = [
        'taxonomy' => 'product_cat',
        'field'    => 'term_id',
        'terms'    => $cat_ids,
    ];
}

$data = steelnova()->woo->get_products( $query_args );

$products = $data['products'];
$query    = $data['query'];

if( empty( $products ) ) {
    echo '<div class="message">'.__('No Products Found.', 'steelnova').'</div>';
    return;
}

?>

<ul class="products-listing">
    <?php foreach( $products as $post ) : 
        setup_postdata( $post );

        global $product;
        $product = wc_get_product( $post->ID );

        if ( ! $product ) {
            continue;
        }
    ?>
        <li class="product">
            <div class="product__thumbnail">
                <a href="<?php echo get_permalink($post->ID); ?>">
                    <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                </a>
            </div>
            <div class="product__content">
                <?php steelnova()->woo->custom_loop_rating(); ?>
                <h6 class="product__name">
                    <a href="<?php echo get_permalink($post->ID); ?>">
                        <?php echo get_the_title($post->ID); ?>
                    </a>
                </h6>
                <div class="price">
                    <?php echo $product->get_price_html(); ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
</ul>