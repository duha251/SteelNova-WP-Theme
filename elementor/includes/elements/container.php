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
        // add_action('elementor/frontend/container/before_render', [ $this, 'before_render' ]);
    }

    public function register_controls($element, $args) {
        $this->register_steelnova_extra_controls($element, $args);
        $this->register_steelnova_animation_controls($element, $args);
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
                    'label' => esc_html__( 'None', 'textdomain' ),
                    'options' => [
                        '' => esc_html__( 'None', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Bouncing Entrances', 'textdomain' ),
                    'options' => [
                        'bounceIn'      => esc_html__( 'Bounce In', 'textdomain' ),
                        'bounceInDown'  => esc_html__( 'Bounce In Down', 'textdomain' ),
                        'bounceInLeft'  => esc_html__( 'Bounce In Left', 'textdomain' ),
                        'bounceInRight' => esc_html__( 'Bounce In Right', 'textdomain' ),
                        'bounceInUp'    => esc_html__( 'Bounce In Up', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Fading Entrances', 'textdomain' ),
                    'options' => [
                        'fadeIn'         => esc_html__( 'Fade In', 'textdomain' ),
                        'fadeInDown'     => esc_html__( 'Fade In Down', 'textdomain' ),
                        'fadeInDownBig'  => esc_html__( 'Fade In Down Big', 'textdomain' ),
                        'fadeInLeft'     => esc_html__( 'Fade In Left', 'textdomain' ),
                        'fadeInLeftBig'  => esc_html__( 'Fade In Left Big', 'textdomain' ),
                        'fadeInRight'    => esc_html__( 'Fade In Right', 'textdomain' ),
                        'fadeInRightBig' => esc_html__( 'Fade In Right Big', 'textdomain' ),
                        'fadeInUp'       => esc_html__( 'Fade In Up', 'textdomain' ),
                        'fadeInUpBig'    => esc_html__( 'Fade In Up Big', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Flippers', 'textdomain' ),
                    'options' => [
                        'flipInX' => esc_html__( 'Flip In X', 'textdomain' ),
                        'flipInY' => esc_html__( 'Flip In Y', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'LightSpeed', 'textdomain' ),
                    'options' => [
                        'lightSpeedIn' => esc_html__( 'LightSpeed In', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Rotating Entrances', 'textdomain' ),
                    'options' => [
                        'rotateIn'          => esc_html__( 'Rotate In', 'textdomain' ),
                        'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'textdomain' ),
                        'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'textdomain' ),
                        'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'textdomain' ),
                        'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Sliding Entrances', 'textdomain' ),
                    'options' => [
                        'slideInDown'  => esc_html__( 'Slide In Down', 'textdomain' ),
                        'slideInLeft'  => esc_html__( 'Slide In Left', 'textdomain' ),
                        'slideInRight' => esc_html__( 'Slide In Right', 'textdomain' ),
                        'slideInUp'    => esc_html__( 'Slide In Up', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Zoom Entrances', 'textdomain' ),
                    'options' => [
                        'zoomIn'      => esc_html__( 'Zoom In', 'textdomain' ),
                        'zoomInDown'  => esc_html__( 'Zoom In Down', 'textdomain' ),
                        'zoomInLeft'  => esc_html__( 'Zoom In Left', 'textdomain' ),
                        'zoomInRight' => esc_html__( 'Zoom In Right', 'textdomain' ),
                        'zoomInUp'    => esc_html__( 'Zoom In Up', 'textdomain' ),
                    ],
                ],
                [
                    'label' => esc_html__( 'Specials', 'textdomain' ),
                    'options' => [
                        'rollIn' => esc_html__( 'Roll In', 'textdomain' ),
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


        //     $this->group_entrance_animation([
        //     'name' => 'title_',
        //     'selector' => '{{WRAPPER}} .heading .heading__title'
        // ]);

    // public function before_render( $settings ) {
    //     if(  !empty( $settings['steelnova_bg_overlay_background'] ) ) {

    //     }
    // }
}