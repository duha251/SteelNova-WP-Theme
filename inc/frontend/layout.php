<?php
namespace SteelNova\Inc\Frontend;

/**
 * Frontend Layout
 *
 * Handles layout structure for frontend.
 *
 * @package SteelNova
 */

use SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Layout {

    private $option;
    private $component;

    public function __construct( Option $option_instance, Components $component_instance ) {
        $this->option = $option_instance;
        $this->component = $component_instance;
        add_action('steelnova_before_main_content', [$this, 'before_main_content_render']);
        add_action('steelnova_after_main_content', [$this, 'after_main_content_render']);
    }

    public function before_main_content_render() {
        $this->get_header();
        $this->get_header_sticky();
        $this->get_header_mobile();
        $this->get_hero();
    }

    public function after_main_content_render() {
        if( class_exists('WooCommerce') ) {
            ?> 
                <svg class="svg-origintal svg-linked">
                    <defs>
                        <linearGradient id="steelnova-star-201" x1="7.60846" y1="0" x2="7.60846" y2="16" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FF5B1B"/>
                            <stop offset="1" stop-color="#993710"/>
                        </linearGradient>
                    </defs>
                </svg>
                <svg class="svg-origintal svg-linked">
                    <defs>
                        <linearGradient id="steelnova-star-201_gradient" x1="7.60846" y1="0" x2="7.60846" y2="16" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FF5B1B"/>
                            <stop offset="1" stop-color="#993710"/>
                        </linearGradient>
                        <clipPath id="steelnova-star-201_clip">
                            <rect x="0" y="0" width="8" height="15"/>
                        </clipPath>
                    </defs>
                </svg>
            <?php
        }
        $this->get_footer();
    }

    public function get_header() {
        $prefix_id = steelnova_get_prefix_id_option();

        $mode = $this->option->get_option( $prefix_id.'header_mode', 'default');
        $layout_id = $this->option->get_option( $prefix_id.'header_layout', 0);

        if( $mode === 'inherit' ) {
            $mode = $this->option->get_theme_option( 'header_mode', 'hide');
            $layout_id = $this->option->get_theme_option( 'header_layout', 0);
        }

        if( $mode === 'hide' || ( $mode === 'builder' && $layout_id === 0 ) ) {
            return '';
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout_id) &&
            $layout_id > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        if( ! $is_builder ) {
            $logo = $this->option->get_theme_option('header_logo', ['url'=> get_template_directory_uri() . '/assets/imgs/logo.webp']);
            $logo_html = (!empty($logo['url'])) 
                ? sprintf(
                    '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                    esc_url( home_url( '/' ) ),
                    esc_attr( get_bloginfo( 'name' ) ),
                    esc_url( $logo['url'] )
                ) : '';

            steelnova_get_template('template-parts/header/desktop/default',[
                'logo_html' => $logo_html
            ]);
            return;
        }
        steelnova_get_template('template-parts/header/desktop/builder', [
            'layout_id' => $layout_id,
        ]);
    }

    public function get_header_sticky() {
        $prefix_id = steelnova_get_prefix_id_option();

        $mode = $this->option->get_option( $prefix_id.'header_sticky_mode', 'hide');
        $layout_id = $this->option->get_option( $prefix_id.'header_sticky_layout', 0);
        $direction = $this->option->get_option( $prefix_id.'header_sticky_display_on', 'up' );

        if( $mode === 'inherit' ) {
            $mode = $this->option->get_theme_option( 'header_sticky_mode', 'hide');
            $layout_id = $this->option->get_theme_option( 'header_sticky_layout', 0);
        }

        if( $mode === 'hide' || ( $mode === 'builder' && $layout_id === 0 ) ) {
            return '';
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout_id) &&
            $layout_id > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        if( ! $is_builder ) {
            return '';
        }
        steelnova_get_template('template-parts/header/desktop/sticky', [
            'layout_id' => $layout_id,
            'direction' => $direction
        ]);
    }

    public function get_header_mobile() {
        $prefix_id = steelnova_get_prefix_id_option();

        $mode = $this->option->get_option( $prefix_id.'header_mobile_mode', 'default');
        $layout_id = $this->option->get_option( $prefix_id.'header_mobile_layout', 0);

        if( $mode === 'inherit' ) {
            $mode = $this->option->get_theme_option( 'header_mobile_mode', 'hide');
            $layout_id = $this->option->get_theme_option( 'header_mobile_layout', 0);
        }

        if( $mode === 'hide' || ( $mode === 'builder' && $layout_id === 0 ) ) {
            return '';
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout) &&
            $layout > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        if( ! $is_builder ) {
            $logo = $this->option->get_theme_option('header_mobile_logo', ['url'=> get_template_directory_uri() . '/assets/imgs/logo.webp']);
            $logo_html = (!empty($logo['url'])) 
                ? sprintf(
                    '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                    esc_url( home_url( '/' ) ),
                    esc_attr( get_bloginfo( 'name' ) ),
                    esc_url( $logo['url'] )
                ) : '';

            steelnova_get_template('template-parts/header/mobile/default',[
                'logo_html' => $logo_html
            ]);
            return;
        }
        steelnova_get_template('template-parts/header/mo/builder', [
            'layout_id' => $layout_id,
        ]);
    }

    public function get_hero() {
        $prefix_id = steelnova_get_prefix_id_option();


        $mode = $this->option->get_option( $prefix_id.'hero_mode', 'default');
        $layout_id = $this->option->get_option( $prefix_id.'hero_layout', 0);

        if( $mode === 'inherit' ) {
            $mode = $this->option->get_theme_option( 'hero_mode', 'hide');
            $layout_id = $this->option->get_theme_option( 'hero_layout', 0);
        }


        if( $mode === 'hide' || ( $mode === 'builder' && $layout_id === 0 ) ) {
            return '';
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout_id) &&
            $layout_id > 0 &&
            class_exists('Pxltheme_Core') &&
            class_exists('\Elementor\Plugin')
        );

        if( ! $is_builder ) {
            steelnova_get_template('template-parts/hero/default',[
                'title' => $this->component->get_hero_title(),
                'note'  => $this->component->get_hero_note()
            ]);
            return;
        }

        steelnova_get_template('template-parts/hero/builder', [
            'layout_id' => $layout_id,
        ]);
    }

    public function get_footer() {
        $prefix_id = steelnova_get_prefix_id_option();
        
        $mode   = $this->option->get_option($prefix_id . 'footer_mode', 'inherit');
        $layout_id = $this->option->get_option($prefix_id . 'footer_layout', 'hide');


        if ( $mode === 'inherit' ) {
            $mode   = $this->option->get_theme_option('footer_mode', '');
            $layout_id = $this->option->get_theme_option('footer_layout', 0);
        }

        if ( $mode === 'hide' || ( $mode === 'builder' && $layout_id <= 0 ) ) {
            return;
        }

        $is_builder = (
            $mode === 'builder' &&
            is_numeric($layout_id) &&
            class_exists('Pxltheme_Core') &&
            method_exists('\Elementor\Plugin', 'instance')
        );

        if( ! $is_builder ) {
            steelnova_get_template('template-parts/footer/default', []);
            return;
        }

        steelnova_get_template('template-parts/footer/builder', [
            'layout_id' => $layout_id,
        ]);
    }

}