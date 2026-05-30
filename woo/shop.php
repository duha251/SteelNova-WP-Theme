<?php

namespace SteelNova\WooCommerce;

use SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shop extends SteelNova_WooCommerce {

    private $option;
    private $version;

    public function __construct( Option $option_instance, $theme_version ) {
        $this->option  = $option_instance;
        $this->version = $theme_version;

        add_filter( 'single_product_archive_thumbnail_size', [ $this, 'set_thumbnail_size' ] );
        add_filter( 'loop_shop_columns', [ $this, 'shop_columns' ] );
        add_filter( 'loop_shop_per_page', [ $this, 'products_per_page' ], 20 );

        add_filter( 'woocommerce_product_loop_start', [ $this, 'product_loop_start' ] );
        add_filter( 'woocommerce_product_loop_end', [ $this, 'product_loop_end' ] );
        add_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'custom_add_to_cart_link' ], 10, 3 );

        add_action( 'wp', [ $this, 'remove_actions' ] );
        add_action( 'woocommerce_before_shop_loop_item', [ $this, 'product_loop_content' ], 10 );

        add_action( 'wp_ajax_steelnova_products_ajax', [ $this, 'ajax_products' ] );
        add_action( 'wp_ajax_nopriv_steelnova_products_ajax', [ $this, 'ajax_products' ] );

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function init() {
    }

    public function set_thumbnail_size( $size ) {
        return 'full';
    }

    public function products_per_page() {
        $products_per_page = (int) $this->option->get_theme_option( 'products_per_page', 9 );
        $sidebar_pos       = $this->option->get_theme_option( 'shop_sidebar_mode', 'none' );

        $has_sidebar = ( isset( $_GET['sidebar'] ) && $_GET['sidebar'] !== 'none' ) || $sidebar_pos !== 'none';

        if ( $has_sidebar ) {
            $products_per_page += 6;
        }

        return $products_per_page;
    }

    public function shop_columns( $columns ) {
        $columns     = (int) $this->option->get_theme_option( 'product_columns', 4 );
        $sidebar_pos = $this->option->get_theme_option( 'shop_sidebar_mode', 'none' );
        $has_sidebar = false;
        if( $sidebar_pos !== 'none' ) {
            $has_sidebar = true;
        }
        if( isset( $_GET['sidebar'] ) ) {
            $has_sidebar = $_GET['sidebar'] !== 'none';
        }
        if ( intval( $columns ) ) {
            if ( $has_sidebar ) {
                return max( 1, $columns - 1 );
            }

            return $columns;
        }

        return $columns;
    }

    private function get_current_layout() {
        $layout = isset( $_GET['product_view'] )
            ? sanitize_text_field( wp_unslash( $_GET['product_view'] ) )
            : 'grid';

        return $layout === 'list' ? 'list' : 'grid';
    }

    public function product_loop_start() {
        $layout  = $this->get_current_layout();
        $columns = wc_get_loop_prop( 'columns' );

        if ( empty( $columns ) ) {
            $columns = $this->shop_columns( 3 );
        }

        ob_start();
        ?>

        <?php if ( is_shop() || is_product_taxonomy() ) : ?>
            <div class="content-area">
                <div class="content-area__header">
                    <div class="content-area__header-left">
                        <div class="buttons">
                            <button class="cs-button cs-button--toggle-layout <?php echo esc_attr($layout === 'grid' ? 'is-active' : ''); ?>" data-layout="grid" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13" fill="none">
                                    <path d="M4 13H0V10H4V13ZM10 13H6V10H10V13ZM16 13H11V10H16V13ZM4 8H0V5H4V8ZM10 8H6V5H10V8ZM16 8H11V5H16V8ZM4 3H0V0H4V3ZM10 3H6V0H10V3ZM16 3H11V0H16V3Z" fill="#FF5B1B"/>
                                </svg>
                            </button>

                            <button class="cs-button cs-button--toggle-layout <?php echo esc_attr($layout === 'list' ? 'is-active' : ''); ?>" data-layout="list" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13" fill="none">
                                    <path d="M1.5 10C2.32843 10 3 10.6716 3 11.5C3 12.3284 2.32843 13 1.5 13C0.671573 13 0 12.3284 0 11.5C0 10.6716 0.671573 10 1.5 10ZM15 13H4V10H15V13ZM1.5 5C2.32843 5 3 5.67157 3 6.5C3 7.32843 2.32843 8 1.5 8C0.671573 8 0 7.32843 0 6.5C0 5.67157 0.671573 5 1.5 5ZM15 8H4V5H15V8ZM1.5 0C2.32843 0 3 0.671573 3 1.5C3 2.32843 2.32843 3 1.5 3C0.671573 3 0 2.32843 0 1.5C0 0.671573 0.671573 0 1.5 0ZM15 3H4V0H15V3Z" fill="#DCDCDC"/>
                                </svg>
                            </button>
                        </div>

                        <div class="steelnova-result-count">
                            <?php woocommerce_result_count(); ?>
                        </div>
                    </div>

                    <div class="content-area__header-right">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>
        <?php endif; ?>

        <div class="grid products-grid is-post-type-product columns-<?php echo esc_attr( $columns ); ?>" data-layout="<?php echo esc_attr( $layout ); ?>">
            <div class="grid__inner">

        <?php
        return ob_get_clean();
    }

    public function product_loop_end() {
        ob_start();
        ?>

            </div>
        </div>

        <div class="steelnova-pagination">
            <?php woocommerce_pagination(); ?>
        </div>

        <?php if ( is_shop() || is_product_taxonomy() ) : ?>
            </div>
        <?php endif; ?>

        <?php
        return ob_get_clean();
    }

    public function remove_actions() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

        remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

        remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
    }

    public function product_loop_content() {
        $view = $this->get_current_layout();

        if ( $view === 'list' ) {
            $this->products_list_content();
        } else {
            $this->products_grid_content();
        }
    }

    public function products_grid_content() {
        global $product;

        if ( ! $product ) {
            return;
        }
        ?>

        <div class="product__thumbnail">
            <div class="product__actions">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>

            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-link">
                <?php
                echo woocommerce_get_product_thumbnail( 'full' );
                woocommerce_show_product_loop_sale_flash();
                ?>
            </a>
        </div>

        <div class="product__content">
            <h5 class="product__name">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <span><?php pxl_print_html( $product->get_name() ); ?></span>
                </a>
            </h5>

            <?php woocommerce_template_loop_price(); ?>
        </div>

        <?php
    }

    public function products_list_content() {
        global $product;

        if ( ! $product ) {
            return;
        }
        ?>

        <div class="product__thumbnail">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product__link">
                <?php
                echo woocommerce_get_product_thumbnail( 'full' );
                woocommerce_show_product_loop_sale_flash();
                ?>
            </a>
        </div>

        <div class="product__content">
            <div class="product__rating">
                <?php pxl_print_html( $this->custom_loop_rating() ); ?>
            </div>

            <h5 class="product__name">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <span><?php pxl_print_html( $product->get_name() ); ?></span>
                </a>
            </h5>

            <?php woocommerce_template_loop_price(); ?>

            <?php if ( ! empty( $product->get_short_description() ) ) : ?>
                <div class="product__short-description">
                    <?php echo wp_kses_post( $product->get_short_description() ); ?>
                </div>
            <?php endif; ?>

            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>

        <?php
    }

    public function custom_add_to_cart_link( $html, $product, $args ) {
        if ( is_admin() ) {
            return $html;
        }

        if ( ! $product ) {
            return $html;
        }

        $text = $product->add_to_cart_text();

        $label = sprintf(
            '<span class="screen-reader-text">%s</span>',
            esc_html( $product->add_to_cart_text() )
        );

        $args['class'] .= ' cs-button';

        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s" %s>%s%s</a>',
            esc_url( $product->add_to_cart_url() ),
            isset( $args['quantity'] ) ? esc_attr( $args['quantity'] ) : 1,
            esc_attr( $args['class'] ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $text ),
            $label
        );
    }

    private function get_ajax_query_args( $paged = 1 ) {
        $orderby = isset( $_POST['orderby'] )
            ? wc_clean( wp_unslash( $_POST['orderby'] ) )
            : '';

        $ordering_args = WC()->query->get_catalog_ordering_args( $orderby );

        $meta_query = WC()->query->get_meta_query();
        $tax_query  = WC()->query->get_tax_query();

        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => $this->products_per_page(),
            'paged'          => max( 1, absint( $paged ) ),
            'orderby'        => $ordering_args['orderby'],
            'order'          => $ordering_args['order'],
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
        ];

        if ( ! empty( $ordering_args['meta_key'] ) ) {
            $args['meta_key'] = $ordering_args['meta_key'];
        }

        if ( isset( $_POST['product_cat'] ) && $_POST['product_cat'] !== '' ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( wp_unslash( $_POST['product_cat'] ) ),
            ];
        }

        if ( isset( $_POST['product_tag'] ) && $_POST['product_tag'] !== '' ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_tag',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( wp_unslash( $_POST['product_tag'] ) ),
            ];
        }

        if ( isset( $_POST['product_brand'] ) && $_POST['product_brand'] !== '' ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_brand',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( wp_unslash( $_POST['product_brand'] ) ),
            ];
        }

        $min_price = isset( $_POST['min_price'] ) && $_POST['min_price'] !== ''
            ? floatval( wp_unslash( $_POST['min_price'] ) )
            : null;

        $max_price = isset( $_POST['max_price'] ) && $_POST['max_price'] !== ''
            ? floatval( wp_unslash( $_POST['max_price'] ) )
            : null;

        if ( $min_price !== null || $max_price !== null ) {
            $price_query = [
                'key'     => '_price',
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
                'value'   => [
                    $min_price !== null ? $min_price : 0,
                    $max_price !== null ? $max_price : PHP_INT_MAX,
                ],
            ];

            $args['meta_query'][] = $price_query;
        }

        if ( ! empty( $args['tax_query'] ) ) {
            $args['tax_query']['relation'] = 'AND';
        }

        return $args;
    }

    private function setup_ajax_loop_props( $query ) {
        $columns = $this->shop_columns( 3 );

        wc_set_loop_prop( 'total', $query->found_posts );
        wc_set_loop_prop( 'total_pages', $query->max_num_pages );
        wc_set_loop_prop( 'per_page', $query->get( 'posts_per_page' ) );
        wc_set_loop_prop( 'current_page', max( 1, $query->get( 'paged' ) ) );
        wc_set_loop_prop( 'columns', $columns );
    }

    private function render_ajax_result_count( $query ) {
        $this->setup_ajax_loop_props( $query );

        ob_start();

        woocommerce_result_count();

        return ob_get_clean();
    }

    private function render_ajax_products_html( $query, $layout = 'grid' ) {
        $this->setup_ajax_loop_props( $query );

        $columns = wc_get_loop_prop( 'columns' );

        ob_start();
        ?>

        <div class="grid products-grid is-post-type-product columns-<?php echo esc_attr( $columns ); ?>" data-layout="<?php echo esc_attr( $layout ); ?>">
            <div class="grid__inner">
                <?php
                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) :
                        $query->the_post();

                        global $product;

                        $product = wc_get_product( get_the_ID() );

                        if ( ! $product ) {
                            continue;
                        }
                        ?>
                        <div class="grid__item">
                            <div <?php wc_product_class( 'product', $product ); ?>>
                                <?php
                                if ( $layout === 'list' ) {
                                    $this->products_list_content();
                                } else {
                                    $this->products_grid_content();
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                    endwhile;
                else :
                    wc_no_products_found();
                endif;
                ?>
            </div>
        </div>

        <?php
        wp_reset_postdata();

        return ob_get_clean();
    }

    private function render_ajax_pagination_html( $query, $paged = 1 ) {
        if ( empty( $query->max_num_pages ) || $query->max_num_pages <= 1 ) {
            return '';
        }

        return steelnova()->component->get_pagination( $query, true );

    }

    public function ajax_products() {
        check_ajax_referer( 'steelnova_shop_nonce', 'nonce' );

        $layout = isset( $_POST['layout'] )
            ? sanitize_text_field( wp_unslash( $_POST['layout'] ) )
            : 'grid';

        $layout = $layout === 'list' ? 'list' : 'grid';

        $paged = isset( $_POST['paged'] )
            ? absint( $_POST['paged'] )
            : 1;

        $args  = $this->get_ajax_query_args( $paged );
        $query = new \WP_Query( $args );

        $products_html    = $this->render_ajax_products_html( $query, $layout );
        $pagination_html  = $this->render_ajax_pagination_html( $query, $paged );
        $result_count     = $this->render_ajax_result_count( $query );

        wp_send_json_success([
            'products_html'   => $products_html,
            'pagination_html' => $pagination_html,
            'result_count'    => $result_count,
            'layout'          => $layout,
            'paged'           => $paged,
            'max_num_pages'   => $query->max_num_pages,
        ]);
    }

    public function enqueue_scripts() {
        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }

        parent::enqueue_scripts();

        wp_enqueue_style(
            'wc-shop-style',
            get_template_directory_uri() . '/woo/assets/css/shop.min.css',
            [],
            $this->version
        );

        wp_enqueue_script(
            'wc-shop-js',
            get_template_directory_uri() . '/woo/assets/js/shop.js',
            [ 'jquery' ],
            $this->version,
            true
        );

        $queried_object = get_queried_object();

        wp_localize_script( 'wc-shop-js', 'steelnova_ajax', [
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'nonce'         => wp_create_nonce( 'steelnova_shop_nonce' ),
            'product_cat'   => is_product_category() && isset( $queried_object->slug ) ? $queried_object->slug : '',
            'product_tag'   => is_product_tag() && isset( $queried_object->slug ) ? $queried_object->slug : '',
            'product_brand' => is_tax( 'product_brand' ) && isset( $queried_object->slug ) ? $queried_object->slug : '',
        ]);
    }
}