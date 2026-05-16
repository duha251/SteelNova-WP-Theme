<?php
/**
 * Handles front-end scripts and styles.
 *
 * @package    SteelNova
 * @subpackage Inc\Frontend
 * @author     Case Theme
 */

namespace SteelNova\Inc\Frontend;

use SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages the enqueuing of scripts and styles for the theme's front-end.
 */
class Enqueue {

    private $version;
	private $option;

    public function __construct( Option $option_instance, $theme_version) {
        $this->option = $option_instance;

		$this->version = $theme_version;
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_assets'] );
	}

    public function enqueue_assets(){
        $this->enqueue_styles();
		$this->enqueue_scripts();
    }


    public function enqueue_scripts() {
        // wp_enqueue_script('jquery'); 
		// Comment
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
		// Libraries
		wp_register_script('swiper-bundle', get_template_directory_uri() . '/assets/js/libraries/swiper-bundle.min.js', [], '12.1.3', true);
		wp_register_script('gsap', get_template_directory_uri() . '/assets/js/libraries/gsap.min.js', [], '3.14.2', true);
		wp_register_script('ScrollTrigger', get_template_directory_uri() . '/assets/js/libraries/ScrollTrigger.min.js', ['gsap'], '3.14.2', true);
		wp_enqueue_script('nice-select', get_template_directory_uri() . '/assets/js/libraries/nice-select.min.js', [], '3.4.3', true);
		wp_register_script('particles-js', get_template_directory_uri() . '/assets/js/libraries/particles.min.js', [], '2.0.0', true);

		// Core
		wp_enqueue_script('steelnova-utils', get_template_directory_uri() . '/assets/js/core/utils.js', [], $this->version, true);

		// Components
		wp_enqueue_script('steelnova-drawer', get_template_directory_uri() . '/assets/js/components/drawer.js', [], $this->version, true);
		wp_enqueue_script('steelnova-video-popup', get_template_directory_uri() . '/assets/js/components/video-popup.js', [], $this->version, true);

		// App
		wp_enqueue_script(
			'app',
			get_template_directory_uri() . '/assets/js/app.js',
			[
				'steelnova-utils',
				'steelnova-drawer',
				'steelnova-video-popup',
			],
			$this->version,
			true
		);
    }

    /**
	 * Enqueues theme stylesheets.
	 */
    public function enqueue_styles() {
        wp_enqueue_style('steelnova-style', get_template_directory_uri() . '/assets/css/style.min.css', [], $this->version);
        wp_add_inline_style( 'steelnova-style', $this->render_inline_styles() );
        wp_enqueue_style('steelnova-wp-block-style', get_template_directory_uri() . '/assets/css/wp-block.css', [], $this->version);

		// Libraries
        wp_enqueue_style('nice-select-style', get_template_directory_uri() . '/assets/css/libraries/nice-select.css', [], '1.0.0');
        wp_register_style('steelnova-swiper', get_template_directory_uri() . '/assets/css/libraries/swiper.css', [], '1.0.0');
		
        // Enquence Google Font
        $google_font_url = $this->get_google_fonts_url();
        if ( ! empty( $google_font_url ) ) {
            wp_enqueue_style( 'steelnova-google-fonts', $google_font_url, [], null );
        }
    }

	/**
	 * Generates the Google Fonts URL.
	 *
	 * @return string
	 */
	public function get_google_fonts_url() {
		$fonts = [];

		$fonts[] = 'Public+Sans:ital,wght@0,100..900;1,100..900';
		$fonts[] = 'Inter:ital,wght@0,100..900;1,100..900';
		$fonts[] = 'Plus+Jakarta+Sans:wght@200..800';
		$fonts[] = 'DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000';
		$fonts[] = 'Instrument+Sans:ital,wght@0,400..700;1,400..700';

		return 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
	}

	/**
	 * Generates the global inline CSS for :root variables.
	 *
	 * @return string The generated CSS.
	 */
	public function render_inline_styles() {
		$theme_colors     = $this->get_style_config( 'theme_colors' );
		$link_colors      = $this->get_style_config( 'link' );
		$linear_gradient_colors    = $this->get_style_config( 'linear_gradient' );
		$theme_typography = $this->get_style_config( 'theme_typography' );

		$css_editor = $this->option->get_option('css_editor', '');
		$breakpoints = [
			'xs' => '575px',
			'sm' => '767px',
			'md' => '991px',
			'lg' => '1199px',
			'xl' => '1399px',
		];

		// $container = preg_match('/([\d.]+)([a-z%]*)/', $this->get_style_config( 'container' )['width'], $matches);
		// $container_size = isset($matches[1]) ? (float) $matches[1] : 1300;
		// $container_unit = $matches[2] ?? 'px';

		ob_start();

		echo ':root{';
			foreach ( $theme_colors as $color => $value ) {
				printf( '--cs-%1$s-color: %2$s;', esc_attr( $color ), esc_attr( $value ) );
			}
			foreach ( $link_colors as $color => $value ) {
				printf( '--cs-link-%1$s: %2$s;', esc_attr( $color ), esc_attr( $value ) );
			}
			foreach ( $linear_gradient_colors as $color => $value ) {
				printf( '--cs-linear-color-%1$s: %2$s;', esc_attr( $color ), esc_attr( $value ) );
			}
			foreach ( $theme_typography as $font => $value ) {
				$font_family = is_array( $value) ? $value['font-family'] : $value;
				printf( '--cs-%1$s-font: %2$s;', esc_attr( $font ), esc_attr( $font_family ) );
			}
			// printf( '--cs-container: %1$s;', esc_attr( $container_size . $container_unit ) );
		echo '}';
		
		if( !empty( $css_editor ) ) {
			pxl_print_html( $css_editor );
		}

		return ob_get_clean();
	}

	/**
	 * Private helper to get style configurations.
	 * This is the equivalent of the old steelnova_global_style_config().
	 *
	 * @param string $key The configuration key to retrieve.
	 * @return array The configuration array.
	 */
	public function get_style_config( $key ) {
		$configs = [
			'theme_colors'     => [
				'primary'   => $this->option->get_option( 'primary_color', '#CDF683' ),
				'secondary' => $this->option->get_option( 'secondary_color', '#000' ),
				'third'     => $this->option->get_option( 'third_color', '#EDDD5E' ),
				'body-background'   => $this->option->get_option( 'body_bg_color', '#FFF' ),
				'heading'   => $this->option->get_option( 'heading_color', '#0A1119' ),
			],
			'link'             => [
				'color'       => $this->option->get_option( 'link_color', [ 'regular' => '#000' ] )['regular'],
				'hover-color' => $this->option->get_option( 'link_color', [ 'hover' => '#FFF' ] )['hover'],
			],
			'linear_gradient' => $this->option->get_option( 'linear_gradient_color', [ 'from' => '#000', 'to' => '#FFF' ] ),
			'theme_typography' => [
				'primary'   => $this->option->get_option( 'primary_font', 'Public Sans' ),
                'secondary' => $this->option->get_option( 'secondary_font', 'DM Sans' ),
                'text'     => $this->option->get_option( 'text_font', 'Public Sans' ),
                'heading'   => $this->option->get_option( 'heading_font', 'Plus Jakarta Sans' ),
			],
			'container' => $this->option->get_option( 'container_width', ['width' => '', 'units' => 'px'] ),
		];
		return isset( $configs[ $key ] ) ? $configs[ $key ] : [];
	}
}