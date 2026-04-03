<?php
namespace SteelNova\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

use SteelNova\Elementor\Controls\Controls_Trait;
use SteelNova\Elementor\Controls\Custom_Controls_Trait;
use Elementor\Widget_Base;

abstract class SteelNova_Widget_Base extends Widget_Base {

    use Controls_Trait, Custom_Controls_Trait;

    protected $config = [];

    abstract protected function widget_info();

    public function __construct( $data = [], $args = null ) {
        $widget_args = $this->widget_info();

        $this->setup_widget_info( $widget_args );
        
        parent::__construct( $data, $args );
    }

    private function setup_widget_info( $args ) {
        $defaults = [
            'name'       => '',
            'title'      => '',
            'icon'       => 'eicon-code',
            'categories' => [ 'steelnova-theme' ],
            'keywords'   => [],
            'style'      => [],
            'script'     => [],
        ];
        $this->config = wp_parse_args( $args, $defaults );
    }

    public function get_name() {
        return $this->config['name'];
    }

    public function get_title() {
        return $this->config['title'];
    }

    public function get_icon() { return $this->config['icon']; }
    public function get_categories() { return $this->config['categories']; }
    public function get_keywords() { return $this->config['keywords']; }
    public function get_style_depends() { return $this->config['style']; }
    public function get_script_depends() { return $this->config['script']; }

    /**
     * Not render elementor-widget-container
     */
    public function has_widget_inner_wrapper(): bool {
        return false;
    }

    // protected function register_controls() {
    //     // To be optionally implemented by child classes
    //     $this->register_box_style_controls();
    // }

    /**
     * Register Box Style Controls
     */
    protected function register_box_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_box_style',
            'label' => __( 'Box Item', 'steelnova' ),
        ]);

        $this->size([
            'name' => 'box_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} [data-widget-type="single"]' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} [data-widget-type="single"]' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([
            'name' => 'box_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'background',
            'selector' => '{{WRAPPER}} [data-widget-type="single"]',
        ]);
        $this->group_box_css([
            'name' => 'box_css',
            'selector' => '{{WRAPPER}} [data-widget-type="single"]',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'background_hover',
            'selector' => '{{WRAPPER}} [data-widget-type="single"]:not(.background-gradient):hover,
                           {{WRAPPER}} [data-widget-type="single"]:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'box_css_hover',
            'selector' => '{{WRAPPER}} [data-widget-type="single"]:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} [data-widget-type="single"]' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Get the path to the render template for this widget
     */
    protected function get_template_path( $layout = '1' ) {
        $name = $this->get_name();

        $name = preg_replace( '/^steelnova[-_]?/', '', $name );

        $name = str_replace( '_', '-', $name );

        $layout = "layout-{$layout}.php";

        return get_template_directory() . "/elementor/includes/widgets/{$name}/render/{$layout}";
    }
    /**
     * Default render logic shared by all child widgets
     */
    protected function render() {
        $widget = $this;
        $settings = $this->get_settings_for_display();
        $layout = $settings['layout'] ?? 1;
        $template_file = $this->get_template_path( $layout );
        $wrapper_attrs = [
            'data-widget-type' => 'single',
            'data-widget-cat' => 'steelnova',
        ];

        if ( file_exists( $template_file ) ) {
            include $template_file;
        } else {
            printf(
                '<div style="color:red;">Template not found: <code>%s</code></div>',
                esc_html( str_replace( get_template_directory(), '', $template_file ) )
            );
        }
    }
}