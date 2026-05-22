<?php
namespace SteelNova\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

use SteelNova\Elementor\Controls\Controls_Trait;
use SteelNova\Elementor\Controls\Custom_Controls_Trait;
use Elementor\Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

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

    /**
     * Register Box Style Controls
     */
    protected function register_box_style_controls() {
        $this->start_style_section([
            'name' => 'section_box_style',
            'label' => __( 'Box Item', 'steelnova' ),
        ]);
        $this->group_width([
            'name' => '_box_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]',
        ]);
        $this->group_height([
            'name' => '_box_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]',
        ]);

        $this->_start_controls_tabs([
            'name' => '_box_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => '_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'steelnova_background',
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]',
        ]);
        $this->group_box_css([
            'name' => '_box_css',
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => '_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => '_background_hover',
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]:not(.background-gradient):hover,
                           {{WRAPPER}} [data-widget-cat="steelnova"]:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => '_box_css_hover',
            'selector' => '{{WRAPPER}} [data-widget-cat="steelnova"]:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => '_box_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} [data-widget-cat="steelnova"]' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_steelnova_extra_controls() {
        $this->start_steelnova_section([
            'name' => 'my_custom_layout_section',
            'label'   => __( 'Extra Options', 'steelnova' ),
        ]);
        $this->group_width([
            'name' => '_width',
            'label' => __( 'CSS Width', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
            'separator' => 'before',
            'fields_options' => [
                'steelnova_max_width' => [
                    'selectors' => [
                        '{{SELECTOR}}' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                    ],
                ],
            ],
        ]);
        $this->group_height([
            'name' => '_height',
            'label' => __( 'CSS Height', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
        ]);
        $this->select([
            'name' => '_overflow',
            'label' => __('Overflow', 'steelnova'),
            'separator' => 'before',
            'options' => [
                '' => __('Default', 'steelnova'),
                'hidden' => __('Hidden', 'steelnova'),
                'auto' => __('Auto', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'overflow: {{VALUE}};'
            ]
        ]);
        $this->select([
            'name' => '_pointer_events',
            'label' => __('Pointer Events', 'steelnova'),
            'options' => [
                '' => __('Default', 'steelnova'),
                'none' => __('None', 'steelnova'),
                'visible' => __('Visible', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'pointer-events: {{VALUE}};'
            ]
        ]);
        $this->select([
            'name' => '_display',
            'label' => __('Display', 'steelnova'),
            'options' => [
                '' => __('Default', 'steelnova'),
                'inline' => __('Inline', 'steelnova'),
                'block' => __('Block', 'steelnova'),
                'inline-block' => __('Inline Block', 'steelnova'),
                'flex' => __('Flex', 'steelnova'),
                'inline-flex' => __('Inline Flex', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'display: {{VALUE}} !important;',
                '{{WRAPPER}} *' => 'display: {{VALUE}} !important;'
            ]
        ]);
        $this->group_css_filter([
            'name' => 'css_filter',
            'separator' => 'before',
            'selector' => '{{WRAPPER}}',
        ]);
        $this->group_position([
            'name' => '_position',
            'label' => __( 'Position', 'steelnova' ),
            'separator' => 'before',
            'selector' => '{{WRAPPER}}',
        ]);
        $this->number([
            'name' => 'steelnova_z_index',
            'label' => __( 'Z-Index', 'steelnova' ),
            'min' => -9999,
            'max' => 9999,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}}' => 'z-index: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Loop Animation Controls.
     */
    protected function register_loop_animation_controls() {
        $this->start_content_section([
            'name' => 'section_loop_animation_content',
            'label' => __( 'Loop Animation', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'loop_anim',
            'label' => __('Loop Animation', 'steelnova'),
            'default' => '',
            'options' => [
                ''    => __('None', 'steelnova'),
                'smoke' => __('Smoke', 'steelnova'),
                'drill-bounce' => __('Drill Bounce', 'steelnova'),
                'sway-rotate'  => __('Sway Rotate', 'steelnova')
            ]
        ]);
        $this->time([
            'name' => 'loop_anim_duration',
            'label' => __('Animation Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} [data-loop-animation]' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'loop_anim!' => ''
            ]
        ]);
        $this->time([
            'name' => 'loop_anim_delay',
            'label' => __('Animation Delay', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} [data-loop-animation]' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'loop_anim!' => ''
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Loop Animation Controls.
     */
    protected function register_steelnova_animation_controls() {
        $this->start_controls_section(
            'my_custom_entrance_animation_section',
            [
                'label'   => __( 'Entrance Animation', 'steelnova' ),
                'tab'     => 'steelnova_extra',
            ]
        );
        $this->select([
            'name' => 'entrance_anim',
            'label' => __('Entrance Animation', 'steelnova'),
            'default' => '',
            'prefix_class' => 'wow ',
            'render_type' => 'none',
            'groups' => Static_Options::entrance_animation_options()
        ]);
        $this->time([
            'name' => 'entrance_anim_duration',
            'label' => __('Animation Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ]
        ]);
        $this->time([
            'name' => 'entrance_anim_delay',
            'label' => __('Animation Delay', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ]
        ]);
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
        if( !empty( $settings['entrance_anim'] ) ) {
            $wrapper_attrs['data-aos'] = $settings['entrance_anim'];
        }

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