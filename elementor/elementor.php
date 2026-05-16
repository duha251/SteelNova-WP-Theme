<?php
namespace SteelNova\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use SteelNova\Elementor\Elements\SteelNova_Container; 
use SteelNova\Elementor\Elements\SteelNova_Widget; 

class SteelNova_Elementor {

	/**
	 * Theme version.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 *
	 * @param string $theme_version Theme version.
	 */
	public function __construct( $theme_version ) {
		$this->version = $theme_version;

		add_action( 'elementor/init', [ $this, 'init' ] );
	}

	/**
	 * Initialize Elementor integrations.
	 *
	 * @return void
	 */
	public function init() {
        $this->require_files();
        new SteelNova_Container();
		add_filter( 'elementor/fonts/groups', [ $this, 'update_elementor_font_groups_control' ] );
		add_filter( 'elementor/fonts/additional_fonts', [ $this, 'update_elementor_font_control' ] );

		add_filter( 'elementor/settings/general/disable_color_schemes', '__return_false' );
		add_filter( 'elementor/settings/general/disable_typography_schemes', '__return_false' );

		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_frontend_styles' ] );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_elementor_widget_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'load_and_register_widgets' ] );
		add_action( 'elementor/controls/register', [ $this, 'load_and_register_controls' ] );

		$this->ensure_cpt_support();
		$this->register_tab();
	}

	/**
	 * Ensure Elementor supports required post types.
	 *
	 * @return void
	 */
	public function ensure_cpt_support() {
		if ( ! is_admin() ) {
			return;
		}

		$required_cpts = [ 'page', 'post', 'pxl-template', 'service', 'member', 'project' ];
		$current_cpts  = get_option( 'elementor_cpt_support', [] );
		$current_cpts  = is_array( $current_cpts ) ? $current_cpts : [];
		$has_changed   = false;

		foreach ( $required_cpts as $cpt ) {
			if ( ! in_array( $cpt, $current_cpts, true ) ) {
				$current_cpts[] = $cpt;
				$has_changed    = true;
			}
		}

		if ( $has_changed ) {
			update_option( 'elementor_cpt_support', $current_cpts );
		}
	}

	/**
	 * Register Elementor widget categories.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elements manager.
	 * @return void
	 */
	public function register_elementor_widget_categories( $elements_manager ) {
		$categories = [
			'steelnova-theme' => [
				'title' => esc_html__( 'SteelNova Elements', 'steelnova' ),
				'icon'  => 'fa fa-plug',
			],
			'steelnova-single' => [
				'title' => esc_html__( 'SteelNova Post', 'steelnova' ),
				'icon'  => 'fa fa-plug',
			],
			'steelnova-woo' => [
				'title' => esc_html__( 'SteelNova WOO', 'steelnova' ),
				'icon'  => 'fa fa-plug',
			],
		];

		$existent_categories = $elements_manager->get_categories();
		$categories          = array_merge( $categories, $existent_categories );

		$set_categories = function( $categories ) {
			$this->categories = $categories;
		};

		$set_categories->call( $elements_manager, $categories );
	}

	/**
	 * Add custom font groups to Elementor.
	 *
	 * @param array $font_groups Font groups.
	 * @return array
	 */
	public function update_elementor_font_groups_control( $font_groups ) {
		$pxlfonts_group = [ 'pxlfonts' => esc_html__( 'Theme Fonts', 'steelnova' ) ];

		return array_merge( $pxlfonts_group, $font_groups );
	}

	/**
	 * Add additional fonts to Elementor.
	 *
	 * @param array $additional_fonts Additional fonts.
	 * @return array
	 */
	public function update_elementor_font_control( $additional_fonts ) {
		// $additional_fonts['Geist'] = 'pxlfonts';
		return $additional_fonts;
	}

	/**
	 * Require needed files.
	 *
	 * @return void
	 */
	public function require_files() {
		$traits_path = get_template_directory() . '/elementor/includes/controls/traits/*.php';
		$trait_files = glob( $traits_path );

		if ( ! empty( $trait_files ) ) {
			foreach ( $trait_files as $file ) {
				require_once $file;
			}
		}

		$widget_base_file = get_template_directory() . '/elementor/includes/base/widget-base.php';

		if ( file_exists( $widget_base_file ) ) {
			require_once $widget_base_file;
		}

        require_once get_template_directory() . '/elementor/includes/elements/container.php';
	}

	/**
	 * Load and register Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager.
	 * @return void
	 */
	public function load_and_register_widgets( $widgets_manager ) {
		$widgets_path = get_template_directory() . '/elementor/includes/widgets/*/*.php';
		$widget_files = glob( $widgets_path );

		if ( empty( $widget_files ) ) {
			return;
		}

		foreach ( $widget_files as $file ) {
			require_once $file;

			$filename        = basename( $file, '.php' );
			$class_name      = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $filename ) ) );
			$full_class_name = __NAMESPACE__ . '\\Widgets\\Widget_' . $class_name;

			if ( ! class_exists( $full_class_name ) ) {
				continue;
			}

			if ( ! is_subclass_of( $full_class_name, '\Elementor\Widget_Base' ) ) {
				continue;
			}

			try {
				$reflection = new \ReflectionClass( $full_class_name );

				if ( ! $reflection->isAbstract() ) {
					$widgets_manager->register( new $full_class_name() );
				}
			} catch ( \Throwable $e ) {
				error_log( 'Elementor widget register error: ' . $e->getMessage() );
			}
		}
	}

	/**
	 * Register custom controls.
	 *
	 * @param \Elementor\Controls_Manager $controls_manager Controls manager.
	 * @return void
	 */

	public function load_and_register_controls( $controls_manager ) {
		$controls_path = get_template_directory() . '/elementor/includes/controls/groups/*.php';
		require_once get_template_directory() . '/elementor/includes/controls/vertical-dimensions.php';
		$controls_manager->register( new \SteelNova\Elementor\Controls\Control_Vertical_Dimensions() );

		$control_files = glob( $controls_path );
		if ( empty( $control_files ) ) {
			return;
		}

		foreach ( $control_files as $file ) {
			require_once $file;

			$filename        = basename( $file, '.php' );
			$class_name      = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $filename ) ) );
			$full_class_name = __NAMESPACE__ . '\\Controls\\Group_Control_' . $class_name;

			if ( ! class_exists( $full_class_name ) ) {
				continue;
			}

			if ( ! is_subclass_of( $full_class_name, '\Elementor\Group_Control_Base' ) ) {
				continue;
			}

			try {
				$reflection = new \ReflectionClass( $full_class_name );

				if ( ! $reflection->isAbstract() ) {
					$controls_manager->add_group_control(
						$full_class_name::get_type(),
						new $full_class_name()
					);
				}
			} catch ( \Throwable $e ) {
				error_log( 'Elementor group control register error: ' . $e->getMessage() );
			}
		}
	}

	/**
	 * Register custom Elementor tab.
	 *
	 * @return void
	 */
	public function register_tab() {
		\Elementor\Controls_Manager::add_tab(
			'steelnova_extra',
			esc_html__( 'Extra', 'steelnova' )
		);
	}

	/**
	 * Enqueue frontend Elementor styles.
	 *
	 * @return void
	 */
	public function enqueue_frontend_styles() {
		// Global styles
		wp_enqueue_style(
			'steelnova-elementor-style',
			get_template_directory_uri() . '/elementor/assets/css/style.min.css',
			[],
			$this->version
		);

		wp_enqueue_style(
			'steelnova-elementor-config-style',
			get_template_directory_uri() . '/elementor/assets/css/config.min.css',
			[],
			$this->version
		);

		$base_dir = get_template_directory() . '/elementor/assets/css/widgets';
		$base_url = get_template_directory_uri() . '/elementor/assets/css/widgets';

		if ( ! is_dir( $base_dir ) ) {
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				$base_dir,
				\RecursiveDirectoryIterator::SKIP_DOTS
			)
		);

		foreach ( $iterator as $file ) {

			if ( ! $file->isFile() ) continue;

			$file_path = $file->getPathname();
			$file_name = $file->getFilename();

			if ( pathinfo( $file_name, PATHINFO_EXTENSION ) !== 'css' ) continue;

			$relative_path = str_replace( $base_dir, '', $file_path );
			$relative_path = str_replace( '\\', '/', $relative_path );
			$relative_path = ltrim( $relative_path, '/' );

			// remove .min.css / .css
			$clean_name = preg_replace( '/\.min\.css$|\.css$/', '', $relative_path );

			// handle: steelnova-widget-xxx
			$handle = 'steelnova-widget-' . sanitize_title(
				str_replace( '/', '-', $clean_name )
			);

			$file_url = $base_url . '/' . $relative_path;

			wp_register_style(
				$handle,
				$file_url,
				[],
				$this->version
			);
		}
	}

	/**
	 * Enqueue editor Elementor styles.
	 *
	 * @return void
	 */
	public function enqueue_editor_styles() {
		wp_enqueue_style( 'steelnova-elementor-editor-style', get_template_directory_uri() . '/elementor/assets/css/editor.min.css', [], $this->version );
	}

	public function enqueue_editor_scripts() {
	}


	/**
	 * Enqueue frontend Elementor scripts.
	 *
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		// Elementor Modules
		wp_register_script('steelnova-carousel', get_template_directory_uri() . '/elementor/assets/js/carousel.js', ['jquery', 'swiper-bundle'], $this->version, true);
		wp_register_script('steelnova-counter', get_template_directory_uri() . '/elementor/assets/js/counter.js', ['jquery', 'ScrollTrigger'], $this->version, true);
		wp_register_script('steelnova-countdown', get_template_directory_uri() . '/elementor/assets/js/countdown.js', ['jquery'], $this->version, true);
		wp_register_script('steelnova-accordion', get_template_directory_uri() . '/elementor/assets/js/accordion.js', ['jquery'], $this->version, true);
		wp_register_script('steelnova-price-filter', get_template_directory_uri() . '/elementor/assets/js/price-filter.js', ['jquery'], $this->version, true);
		wp_register_script('steelnova-particles', get_template_directory_uri() . '/elementor/assets/js/particles.js', ['jquery', 'particles-js'], $this->version, true);
		wp_register_script('steelnova-tabs', get_template_directory_uri() . '/elementor/assets/js/tabs.js', ['jquery'], $this->version, true);
	}
}