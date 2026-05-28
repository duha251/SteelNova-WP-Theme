<?php
namespace SteelNova\Elementor\Elements;

use SteelNova\Elementor\Controls\Controls_Trait;
use SteelNova\Elementor\Controls\Custom_Controls_Trait;
use SteelNova\Inc\Helpers\Static_Options;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SteelNova_Container {
    use Controls_Trait, Custom_Controls_Trait;

	public function __construct() {
        add_action('elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ] , 10, 2);
        add_action('elementor/frontend/container/before_render', [ $this, 'before_render' ]);
    }

    public function register_controls($element, $args) {
        $this->register_steelnova_extra_controls($element, $args);
        $this->register_steelnova_animation_controls($element, $args);
        $this->register_steelnova_sticky_controls( $element, $args );
    }

    public function register_steelnova_extra_controls( $element, $args ) {
        $this->start_steelnova_section([
            'name' => 'section_steelnova_extra',
            'label'   => __( 'Extra Options', 'steelnova' ),
        ], $element);

        // $this->size([
        //     'name'  => '_container_max_width',
        //     'label' => __( 'Max Width', 'steelnova' ),
        //     'selectors' => [
        //         '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}};'
        //     ]
        // ], $element);

        $this->group_width([
            'name' => '_width',
            'label' => __( 'CSS Width', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
            'fields_options' => [
                'steelnova_max_width' => [
                    'selectors' => [
                        '{{SELECTOR}}' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                    ],
                ],
            ],
        ], $element);
        $this->group_height([
            'name' => '_height',
            'label' => __( 'CSS Height', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
        ], $element);

        $this->size([
            'name'  => '_backdrop_filter_blur',
            'label' => __( 'Backdrop Filter Blur', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});'
            ]
        ], $element);

        $this->select([
            'name' => '_display',
            'label' => __('Display', 'steelnova'),
            'options' => [
                '' => __('Default', 'steelnova'),
                'block' => __('Block', 'steelnova'),
                'inline-block' => __('Inline Block', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'display: {{VALUE}} !important;',
            ]
        ], $element);

        $this->choose([
            'name' => '_text_align',
            'label' => __('Text Align', 'steelnova'),
            'options' => Static_Options::text_align_css_options(),
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
            ],
        ], $element);
        
        $element->end_controls_section();
    }
    
    /**
     * Register Loop Animation Controls.
     */
    protected function register_steelnova_animation_controls( $element, $args ) {
        $this->start_steelnova_section([
            'label'   => __( 'Entrance Animation', 'steelnova' ),
            'name' => 'section_steelnova_aniamtion',
        ], $element);
        $this->select([
            'name' => 'entrance_anim',
            'label' => __('Entrance Animation', 'steelnova'),
            'default' => '',
            'prefix_class' => 'wow ',
            'render_type' => 'none',
            'groups' => [
                [
                    'label' => esc_html__( 'None', 'steelnova' ),
                    'options' => [
                        '' => esc_html__( 'None', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Bouncing Entrances', 'steelnova' ),
                    'options' => [
                        'bounceIn'      => esc_html__( 'Bounce In', 'steelnova' ),
                        'bounceInDown'  => esc_html__( 'Bounce In Down', 'steelnova' ),
                        'bounceInLeft'  => esc_html__( 'Bounce In Left', 'steelnova' ),
                        'bounceInRight' => esc_html__( 'Bounce In Right', 'steelnova' ),
                        'bounceInUp'    => esc_html__( 'Bounce In Up', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Fading Entrances', 'steelnova' ),
                    'options' => [
                        'fadeIn'         => esc_html__( 'Fade In', 'steelnova' ),
                        'fadeInDown'     => esc_html__( 'Fade In Down', 'steelnova' ),
                        'fadeInDownBig'  => esc_html__( 'Fade In Down Big', 'steelnova' ),
                        'fadeInLeft'     => esc_html__( 'Fade In Left', 'steelnova' ),
                        'fadeInLeftBig'  => esc_html__( 'Fade In Left Big', 'steelnova' ),
                        'fadeInRight'    => esc_html__( 'Fade In Right', 'steelnova' ),
                        'fadeInRightBig' => esc_html__( 'Fade In Right Big', 'steelnova' ),
                        'fadeInUp'       => esc_html__( 'Fade In Up', 'steelnova' ),
                        'fadeInUpBig'    => esc_html__( 'Fade In Up Big', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Flippers', 'steelnova' ),
                    'options' => [
                        'flipInX' => esc_html__( 'Flip In X', 'steelnova' ),
                        'flipInY' => esc_html__( 'Flip In Y', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'LightSpeed', 'steelnova' ),
                    'options' => [
                        'lightSpeedIn' => esc_html__( 'LightSpeed In', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Rotating Entrances', 'steelnova' ),
                    'options' => [
                        'rotateIn'          => esc_html__( 'Rotate In', 'steelnova' ),
                        'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'steelnova' ),
                        'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'steelnova' ),
                        'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'steelnova' ),
                        'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Sliding Entrances', 'steelnova' ),
                    'options' => [
                        'slideInDown'  => esc_html__( 'Slide In Down', 'steelnova' ),
                        'slideInLeft'  => esc_html__( 'Slide In Left', 'steelnova' ),
                        'slideInRight' => esc_html__( 'Slide In Right', 'steelnova' ),
                        'slideInUp'    => esc_html__( 'Slide In Up', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Zoom Entrances', 'steelnova' ),
                    'options' => [
                        'zoomIn'      => esc_html__( 'Zoom In', 'steelnova' ),
                        'zoomInDown'  => esc_html__( 'Zoom In Down', 'steelnova' ),
                        'zoomInLeft'  => esc_html__( 'Zoom In Left', 'steelnova' ),
                        'zoomInRight' => esc_html__( 'Zoom In Right', 'steelnova' ),
                        'zoomInUp'    => esc_html__( 'Zoom In Up', 'steelnova' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Specials', 'steelnova' ),
                    'options' => [
                        'rollIn' => esc_html__( 'Roll In', 'steelnova' ),
                    ],
                ],
            ],
        ], $element);
        $this->time([
            'name' => 'entrance_anim_duration',
            'label' => __('Animation Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ]
        ], $element);
        $this->time([
            'name' => 'entrance_anim_delay',
            'label' => __('Animation Delay', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ],
        ], $element);
        $element->end_controls_section();
    }

    /**
     * Register Loop Animation Controls.
     */
    protected function register_steelnova_sticky_controls( $element, $args ) {
        $this->start_steelnova_section([
            'label'   => __( 'Is Sticky', 'steelnova' ),
            'name' => 'section_steelnova_sticky',
        ], $element);
                // Sticky   
        $this->select([
            'name' => 'is_sticky',
            'label' => esc_html__( 'Is Sticky', 'steelnova' ),
            'frontend_available' => true,
            'render_type' => 'template',
            'options'      => array(
                'on'  => esc_html__( 'On', 'steelnova' ),           
                'off' => esc_html__( 'Off', 'steelnova' )
            ),
            'default'      => 'off',
        ], $element);
        $this->select([
            'name' => 'sticky_position',
            'label' => esc_html__( 'Position', 'steelnova' ),
            'frontend_available' => true,
            'render_type' => 'none',
            'options'      => array(
                'top'         => esc_html__( 'Top', 'steelnova' ),           
                'bottom'      => esc_html__( 'Bottom', 'steelnova' )
            ),
            'default'      => 'top',
            'condition' => [
                'is_sticky' => 'on',
            ]
        ], $element);
        $this->number([
            'name' => 'sticky_offset',
            'label' => esc_html__( 'Offset(px)', 'steelnova' ),
            'default' => 0,
            'min' => 0,
            'max' => 500,
            'condition' => [
                'is_sticky' => 'on',
            ],
        ], $element); 
        $this->switcher([
            'name' => 'sticky_spacing',
            'label' => __('Spacing', 'steelnova'),
            'default' => '',
            'condition' => [
                'is_sticky' => 'on',
            ],
        ], $element);
        $this->text([
            'name' => 'sticky_trigger',
            'label' => esc_html__( 'Trigger', 'steelnova' ),
            'placeholder' => esc_html__( 'e.g: .my-class', 'steelnova' ),
            'description' => __('This is a number(px) or .class, #id.', 'steelnova'),
            'condition' => [
                'is_sticky' => 'on',
            ],
        ], $element);  
        $this->select([
            'name' => 'sticky_responsive',
            'label' => esc_html__( 'Break On', 'steelnova' ),
            'default' => '',
            'options' => Static_Options::elementor_divice_options(),
            'render_type' => 'none',
            'frontend_available' => true,
            'condition' => [
                'is_sticky' => 'on',
            ],
        ], $element);   
        $this->number([
            'name' => 'sticky_responsive_screen_w',
            'label' => __('Screen Width', 'steelnova'),
            'min' => 0,
            'default' => 767,
            'max' => 2400,
            'condition' => [
                'sticky_responsive' => 'custom',
            ]
        ], $element);
        $element->end_controls_section();
    }

    public function before_render( $element ) {
        $settings = $element->get_settings_for_display();
        wp_enqueue_script('steelnova-sticky');
        /**
         * Add sticky attributes if sticky is enabled
         */
        if ( ! empty( $settings['is_sticky'] ) && $settings['is_sticky'] === 'on' ) {
            $sticky_settings = [
                'position' => ! empty( $settings['sticky_position'] ) ? $settings['sticky_position'] : 'top',
                'offset'   => isset( $settings['sticky_offset'] ) ? (int) $settings['sticky_offset'] : 0,
                'spacing'  => ! empty( $settings['sticky_spacing'] ) ? true : false,
                'trigger'  => ! empty( $settings['sticky_trigger'] ) ? $settings['sticky_trigger'] : '',
                'breakOn'  => ! empty( $settings['sticky_responsive_screen_w'] ) ? (int) $settings['sticky_responsive_screen_w'] : 767,
            ];

            $element->add_render_attribute(
                '_wrapper',
                'data-sticky-settings',
                wp_json_encode( $sticky_settings )
            );
        }
    }
}