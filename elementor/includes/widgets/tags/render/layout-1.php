<?php
$post_type = $settings['post_type'];

$wrapper_attrs = array_merge(
    [
        'class' => 'cs-tags is-post-type-'.$post_type,
    ],
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );


if ( $post_type === 'product' && ! class_exists( 'WooCommerce' ) ) {
    echo '<div class="message">' . esc_html__( 'You need to install the WooCommerce plugin.', 'steelnova' ) . '</div>';
    return;
}

$tags = $settings[ $post_type . '_tags' ];

$taxonomy = $post_type . '_tag';

if ( empty( $tags ) ) {
    $tags = steelnova()->post_manager->get_cpt_tag_list( $taxonomy );
}

if ( empty( $tags ) ) {
    echo '<div class="message">' . esc_html__( 'No Tags Found.', 'steelnova' ) . '</div>';
    return;
}

/**
 * Current URL for product filter.
 */
$current_url = home_url( add_query_arg( null, null ) );
$current_url = remove_query_arg( [ 'paged', 'product-page' ], $current_url );

/**
 * Get current active tag.
 */
$current_term_id  = 0;
$current_tag_slug = '';

if ( $post_type === 'product' ) {
    if ( isset( $_GET['product_tag'] ) ) {
        $current_tag_slug = sanitize_text_field( wp_unslash( $_GET['product_tag'] ) );
    }

    if ( is_tax( 'product_tag' ) ) {
        $current_term = get_queried_object();

        if ( $current_term && ! is_wp_error( $current_term ) && ! empty( $current_term->term_id ) ) {
            $current_term_id  = (int) $current_term->term_id;
            $current_tag_slug = $current_term->slug;
        }
    }
} else {
    if ( is_tax( $taxonomy ) ) {
        $current_term = get_queried_object();

        if ( $current_term && ! is_wp_error( $current_term ) && ! empty( $current_term->term_id ) ) {
            $current_term_id = (int) $current_term->term_id;
        }
    }
}
?>

<ul <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php
    foreach ( $tags as $tag_id => $tag_name ) {
        $term = get_term( $tag_id, $taxonomy );

        if ( ! $term || is_wp_error( $term ) ) {
            continue;
        }

        if ( $post_type === 'product' ) {
            /**
             * Product tag filter URL.
             * Example: /shop/?product_tag=marketing
             */
            $link = add_query_arg(
                [
                    'product_tag' => $term->slug,
                ],
                $current_url
            );

            $is_active = ( $current_tag_slug === $term->slug );
        } else {
            /**
             * Normal tag archive URL for post/custom post type.
             */
            $link = get_term_link( $term );

            if ( is_wp_error( $link ) ) {
                continue;
            }

            $is_active = ( (int) $term->term_id === $current_term_id );
        }

        $tag_classes = [
            'tag',
        ];

        if ( $is_active ) {
            $tag_classes[] = 'is-active';
        }
        ?>
            <li class="<?php echo esc_attr( implode( ' ', $tag_classes ) ); ?>">
                <a
                    href="<?php echo esc_url( $link ); ?>"
                    class="tag__link"
                    <?php pxl_print_html( $is_active ? 'aria-current="page"' : '' ); ?>
                >
                    <?php echo esc_html( $term->name ); ?>
                </a>
            </li>
        <?php
    }
    ?>
</ul>