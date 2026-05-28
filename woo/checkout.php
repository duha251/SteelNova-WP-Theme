<?php
/**
 * WooCommerce Cart Integration
 *
 * Handles WooCommerce cart functionality and shop loop modifications.
 *
 * @package Mindverse\Inc\Integrations\Woocommerce
 * @since 1.0.0
 */

namespace SteelNova\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Checkout extends SteelNova_WooCommerce {

    private $version;
    public function __construct( $theme_version ) {   
        $this->version = $theme_version; 
        add_filter('woocommerce_checkout_fields', [$this, 'custom_checkout_fields'], 20 );    
        add_filter( 'gettext', [$this, 'rename_checkout_titles'], 20, 3 ); 
        add_action('woocommerce_checkout_before_order_review_heading', [$this, 'checkout_before_order_review_heading']);
        add_action('woocommerce_checkout_after_order_review', [$this, 'checkout_after_order_review']);
        add_filter( 'woocommerce_order_button_text', [$this, 'order_button_text']);
        remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10);

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function order_button_text() {
        return __('Place order now', 'steelnova');
    }

    public function checkout_before_order_review_heading() {
        ?>
        <div class="order-review-wrapper">
        <?php
    }

    public function checkout_after_order_review() {
        ?>            
    </div>
        <?php
    }

    function rename_checkout_titles( $translated, $text, $domain ) {

        if ( 'woocommerce' === $domain ) {
            if ( 'Billing details' === $text ) {
                $translated = 'Billing Address';
            }

            if ( 'Ship to a different address?' === $text ) {
                $translated = 'Addtional Information';
            }
        }

        return $translated;
    }

    function custom_checkout_fields( $fields ) {

        /*
        |--------------------------------------------------------------------------
        | BILLING
        |--------------------------------------------------------------------------
        */
        $fields['billing']['billing_first_name']['label']       = __( 'First Name', 'steelnova' );
        $fields['billing']['billing_first_name']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['billing']['billing_first_name']['priority']    = 10;
        $fields['billing']['billing_first_name']['class']       = [ 'form-row-first' ];

        $fields['billing']['billing_last_name']['label']       = __( 'Last Name', 'steelnova' );
        $fields['billing']['billing_last_name']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['billing']['billing_last_name']['priority']    = 20;
        $fields['billing']['billing_last_name']['class']       = [ 'form-row-last' ];

        $fields['billing']['billing_company']['label']       = __( 'Company Name', 'steelnova' );
        $fields['billing']['billing_company']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['billing']['billing_company']['priority']    = 30;
        $fields['billing']['billing_company']['required']    = false;
        $fields['billing']['billing_company']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_country']['label']    = __( 'Country / Region', 'steelnova' );
        $fields['billing']['billing_country']['priority'] = 40;
        $fields['billing']['billing_country']['class']    = [ 'form-row-wide' ];

        $fields['billing']['billing_address_1']['label']       = __( 'Street Address', 'steelnova' );
        $fields['billing']['billing_address_1']['placeholder'] = __( '32nd Madison Street', 'steelnova' );
        $fields['billing']['billing_address_1']['priority']    = 50;
        $fields['billing']['billing_address_1']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_address_2']['label']       = __( 'Apartment / Unit (Optional)', 'steelnova' );
        $fields['billing']['billing_address_2']['placeholder'] = __( 'Unit 4', 'steelnova' );
        $fields['billing']['billing_address_2']['priority']    = 60;
        $fields['billing']['billing_address_2']['required']    = false;
        $fields['billing']['billing_address_2']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_postcode']['label']       = __( 'Postcode/ Zip', 'steelnova' );
        $fields['billing']['billing_postcode']['placeholder'] = __( '324456', 'steelnova' );
        $fields['billing']['billing_postcode']['priority']    = 70;
        $fields['billing']['billing_postcode']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_city']['label']       = __( 'Town / City', 'steelnova' );
        $fields['billing']['billing_city']['placeholder'] = __( 'Amron', 'steelnova' );
        $fields['billing']['billing_city']['priority']    = 80;
        $fields['billing']['billing_city']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_state']['label']    = __( 'State *', 'steelnova' );
        $fields['billing']['billing_state']['priority'] = 90;
        $fields['billing']['billing_state']['class']    = [ 'form-row-wide' ];

        $fields['billing']['billing_phone']['label']       = __( 'Phone No', 'steelnova' );
        $fields['billing']['billing_phone']['placeholder'] = __( '123 456 789', 'steelnova' );
        $fields['billing']['billing_phone']['priority']    = 100;
        $fields['billing']['billing_phone']['class']       = [ 'form-row-wide' ];

        $fields['billing']['billing_email']['label']       = __( 'Email Address', 'steelnova' );
        $fields['billing']['billing_email']['placeholder'] = __( 'example@gmail.com', 'steelnova' );
        $fields['billing']['billing_email']['priority']    = 110;
        $fields['billing']['billing_email']['class']       = [ 'form-row-wide' ];

        /*
        |--------------------------------------------------------------------------
        | SHIPPING
        |--------------------------------------------------------------------------
        */
        $fields['shipping']['shipping_first_name']['label']       = __( 'First Name', 'steelnova' );
        $fields['shipping']['shipping_first_name']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['shipping']['shipping_first_name']['priority']    = 10;
        $fields['shipping']['shipping_first_name']['class']       = [ 'form-row-first' ];

        $fields['shipping']['shipping_last_name']['label']       = __( 'Last Name', 'steelnova' );
        $fields['shipping']['shipping_last_name']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['shipping']['shipping_last_name']['priority']    = 20;
        $fields['shipping']['shipping_last_name']['class']       = [ 'form-row-last' ];

        $fields['shipping']['shipping_company']['label']       = __( 'Company Name', 'steelnova' );
        $fields['shipping']['shipping_company']['placeholder'] = __( 'Name here', 'steelnova' );
        $fields['shipping']['shipping_company']['priority']    = 30;
        $fields['shipping']['shipping_company']['required']    = false;
        $fields['shipping']['shipping_company']['class']       = [ 'form-row-wide' ];

        $fields['shipping']['shipping_country']['label']    = __( 'Country / Region', 'steelnova' );
        $fields['shipping']['shipping_country']['priority'] = 40;
        $fields['shipping']['shipping_country']['class']    = [ 'form-row-wide' ];

        $fields['shipping']['shipping_address_1']['label']       = __( 'Street Address', 'steelnova' );
        $fields['shipping']['shipping_address_1']['placeholder'] = __( '32nd Madison Street', 'steelnova' );
        $fields['shipping']['shipping_address_1']['priority']    = 50;
        $fields['shipping']['shipping_address_1']['class']       = [ 'form-row-wide' ];

        $fields['shipping']['shipping_address_2']['label']       = __( 'Apartment / Unit (Optional)', 'steelnova' );
        $fields['shipping']['shipping_address_2']['placeholder'] = __( 'Unit 4', 'steelnova' );
        $fields['shipping']['shipping_address_2']['priority']    = 60;
        $fields['shipping']['shipping_address_2']['required']    = false;
        $fields['shipping']['shipping_address_2']['class']       = [ 'form-row-wide' ];

        $fields['shipping']['shipping_postcode']['label']       = __( 'Postcode/ Zip', 'steelnova' );
        $fields['shipping']['shipping_postcode']['placeholder'] = __( '324456', 'steelnova' );
        $fields['shipping']['shipping_postcode']['priority']    = 70;
        $fields['shipping']['shipping_postcode']['class']       = [ 'form-row-wide' ];

        $fields['shipping']['shipping_city']['label']       = __( 'Town / City', 'steelnova' );
        $fields['shipping']['shipping_city']['placeholder'] = __( 'Amron', 'steelnova' );
        $fields['shipping']['shipping_city']['priority']    = 80;
        $fields['shipping']['shipping_city']['class']       = [ 'form-row-wide' ];

        $fields['shipping']['shipping_state']['label']    = __( 'State', 'steelnova' );
        $fields['shipping']['shipping_state']['priority'] = 90;
        $fields['shipping']['shipping_state']['class']    = [ 'form-row-wide' ];

        /*
        |--------------------------------------------------------------------------
        | Note
        |--------------------------------------------------------------------------
        */
        $fields['order']['order_comments']['label']       = __( 'Order Notes', 'steelnova' );
        $fields['order']['order_comments']['placeholder'] = __( 'Notes About your order & delivery', 'steelnova' );
        $fields['order']['order_comments']['required']    = false;
        $fields['order']['order_comments']['class']       = [ 'form-row-wide' ];
        $fields['order']['order_comments']['priority']    = 10;
        return $fields;
    }

    public function enqueue_scripts() {
        if ( is_admin() || !is_checkout() ) {
            return;
        }

        parent::enqueue_scripts();

        wp_enqueue_style('wc-checkout-style',get_template_directory_uri() . '/woo/assets/css/checkout.min.css', [], $this->version );

    }
}