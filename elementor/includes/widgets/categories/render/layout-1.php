<?php
$post_type = $settings['post_type'];

$wrapper_attrs = array_merge(
    [
        'class'       => 'cs-categories is-post-type-' . $post_type,
        'data-layout' => '1',
    ],
    $wrapper_attrs
);

if ( $settings['show_divider'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' has-divider';
}

$this->add_render_attribute( 'wrapper', $wrapper_attrs );

if ( $post_type === 'product' && ! class_exists( 'WooCommerce' ) ) {
    echo '<div class="message">' . esc_html__( 'You need to install the WooCommerce plugin..', 'steelnova' ) . '</div>';
    return;
}

$taxonomy = $post_type . '_category';

if ( $post_type === 'product' ) {
    $taxonomy = 'product_cat';
} elseif ( $post_type === 'post' ) {
    $taxonomy = 'category';
}

$categories = $settings[ $post_type . '_categories' ];

if ( empty( $categories ) ) {
    $categories = steelnova()->post_manager->get_cpt_category_list( $taxonomy );
}

if ( empty( $categories ) ) {
    echo '<div class="message">' . esc_html__( 'No Categories Found.', 'steelnova' ) . '</div>';
    return;
}

/**
 * Current URL for product filter.
 */
$current_url = home_url( add_query_arg( null, null ) );
$current_url = remove_query_arg( [ 'paged', 'product-page' ], $current_url );

/**
 * Get current active category.
 */
$current_term_id   = 0;
$current_cat_slug  = '';

if ( $post_type === 'product' ) {
    if ( isset( $_GET['product_cat'] ) ) {
        $current_cat_slug = sanitize_text_field( wp_unslash( $_GET['product_cat'] ) );
    }

    if ( is_tax( 'product_cat' ) ) {
        $current_term = get_queried_object();

        if ( $current_term && ! is_wp_error( $current_term ) && ! empty( $current_term->term_id ) ) {
            $current_term_id  = (int) $current_term->term_id;
            $current_cat_slug = $current_term->slug;
        }
    }
} else {
    if ( is_tax( $taxonomy ) || is_category() ) {
        $current_term = get_queried_object();

        if ( $current_term && ! is_wp_error( $current_term ) && ! empty( $current_term->term_id ) ) {
            $current_term_id = (int) $current_term->term_id;
        }
    }
}
?>

<ul <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php
    foreach ( $categories as $cat_id => $cat_label ) {
        $term = get_term( $cat_id, $taxonomy );

        if ( ! $term || is_wp_error( $term ) ) {
            continue;
        }

        if ( $post_type === 'product' ) {
            /**
             * Product category filter URL.
             * Example: /shop/?product_cat=tivi
             */
            $link = add_query_arg(
                [
                    'product_cat' => $term->slug,
                ],
                $current_url
            );

            $is_active = ( $current_cat_slug === $term->slug );
        } else {
            /**
             * Normal category URL for post/custom post type.
             */
            $link = get_term_link( $term );

            if ( is_wp_error( $link ) ) {
                continue;
            }

            $is_active = ( (int) $term->term_id === $current_term_id );
        }

        $count = $term->count < 10 ? '0' . $term->count : $term->count;

        $category_classes = [
            'category',
        ];

        if ( $is_active ) {
            $category_classes[] = 'active';
        }
        ?>
            <li class="<?php echo esc_attr( implode( ' ', $category_classes ) ); ?>">
                <a
                    href="<?php echo esc_url( $link ); ?>"
                    class="category__link"
                    <?php echo $is_active ? 'aria-current="page"' : ''; ?>
                >
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