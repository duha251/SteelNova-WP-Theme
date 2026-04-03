<?php
namespace SteelNova\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class SteelNova_Elementor {
    private $version;
    public function __construct( $theme_version ) {

        $this->version = $theme_version;

        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
        // elementor/editor/after_enqueue_scripts
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );
        add_action('init', [$this, 'init'] );
        add_action( 'elementor/elements/categories_registered', [$this, 'register_elementor_widget_categories'] );
        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'update_elementor_style'], 10, 2);
    }

    public function init() {
        add_filter( 'elementor/fonts/groups', [$this, 'update_elementor_font_groups_control'] );
        add_filter( 'elementor/fonts/additional_fonts', [$this, 'update_elementor_font_control'] );
        add_filter('elementor/settings/general/disable_color_schemes', '__return_false');
        add_filter('elementor/settings/general/disable_typography_schemes', '__return_false');
        $this->ensure_cpt_support();
    }

    public function ensure_cpt_support() {
        if ( ! is_admin() ) {
            return;
        }
        $required_cpts = [ 'page', 'post', 'pxl-template', 'career', 'team' ];
        $current_cpts = get_option( 'elementor_cpt_support', [] );
        $has_changed = false;
        foreach ( $required_cpts as $cpt ) {
            if ( ! in_array( $cpt, $current_cpts ) ) {
                $current_cpts[] = $cpt;
                $has_changed = true;
            }
        }

        if ( $has_changed ) {
            update_option( 'elementor_cpt_support', $current_cpts );
        }
    }


    public function register_elementor_widget_categories( $elements_manager ) {
        $categories = [];
        $categories['steelnova-theme'] = [
            'title' => 'SteelNova Widgets',
            'icon' => 'fa fa-plug'
        ];
        $existent_categories = $elements_manager->get_categories();
        $categories = array_merge($categories, $existent_categories);
        $set_categories = function ($categories) {
            $this->categories = $categories;
        };
        $set_categories->call($elements_manager, $categories);
    }

    function update_elementor_font_groups_control($font_groups){
        $pxlfonts_group = array( 'pxlfonts' => esc_html__( 'Theme Fonts', 'steelnova' ) );
        return array_merge( $pxlfonts_group, $font_groups );
    }
    
    function update_elementor_font_control($additional_fonts){
        // $additional_fonts['Geist'] = 'pxlfonts';
        return $additional_fonts;
    }


    function update_elementor_style ( $element, $args ) {
        // Set default padding
        $element->update_control(
            'padding',
            [
                'default' => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        // Set default gap (column gap / row gap)
        $element->update_control(
            'row-gap',
            [
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
            ]
        );
    }

    public function register_widgets( $manager ) {
        $this->require_files();
        $this->load_and_register_widgets( $manager );
    }

    public function require_files() {
        $traits_path = get_template_directory() . '/elementor/includes/controls/traits/*.php';
        $trait_files = glob( $traits_path );
        if ( empty( $trait_files ) ) {
            return;
        }
        foreach ( $trait_files as $file ) {
            require_once $file;
        }
        require_once get_template_directory() . '/elementor/includes/base/widget-base.php';
	}
    

    /**
     * Load and register Elementor widgets.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @return void
     */
    public function load_and_register_widgets( $widgets_manager ) {

        // $base_widget_file = get_template_directory() . '/elementor/includes/base/widget-base.php';
        // if ( file_exists( $base_widget_file ) ) {
        //     require_once $base_widget_file;
        // }

        $widgets_path = get_template_directory() . '/elementor/includes/widgets/*/*.php';
        $widget_files = glob( $widgets_path );

        // require_once get_template_directory() . '/elementor/atomic-widgets/atomic-button/atomic-button.php';

        // if ( empty( $widget_files ) ) {
        //     return;
        // }
        // $widgets_manager->register( new \SteelNova\Elementor\Atomic_Widgets\Atomic_Button\SteelNova_Atomic_Button() );

        

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


    public function register_controls( $controls_manager ) {
        require_once get_template_directory() . '/elementor/includes/controls/groups/flex_css.php';
        $controls_manager->add_group_control(
            \SteelNova\Elementor\Controls\Group_Control_Flex_CSS::get_type(),
            new \SteelNova\Elementor\Controls\Group_Control_Flex_CSS()
        );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'steelnova-elementor-style', get_template_directory_uri() . '/elementor/assets/css/style.min.css', [], $this->version );
    }
}