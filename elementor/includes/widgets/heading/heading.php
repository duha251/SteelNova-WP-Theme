<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Heading extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-heading',
            'title'      => __( 'CS Heading', 'steelnova' ),
            'icon'       => 'eicon-heading',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'heading', 'title', 'text', 'typography', 'content', 'h1', 'h2', 'h3', 'heading editor' ],
            'script'     => [],
            'style'      => ['steelnova-widget-heading'],
            'style'      => ['steelnova-widget-heading']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_subtitle_content_controls();
        $this->register_title_content_controls();
        // Style Controls
        $this->register_title_style_controls();
        $this->register_subtitle_style_controls();
        $this->register_subtitle_icon_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->choose([
            'name' => 'text_align',
            'label' => __('Text Align', 'steelnova'),
            'options' => Static_Options::text_align_css_options(),
            'selectors' => [
                '{{WRAPPER}} .heading' => 'text-align: {{VALUE}};',
            ],
        ]);
        $this->size([
            'name' => 'subtitle_spacing_bottom',
            'label' => __('Subtitle Spacing', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Subtitle Content Controls.
     */
    protected function register_subtitle_content_controls() {
        $this->start_content_section([
            'name' => 'section_subtitle_content',
            'label' => __( 'Subtitle', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'subtitle_style',
            'label' => __('Subtitle Style', 'steelnova'),
            'options' => [
                'primary'  => __('Primary', 'steelnova'),
                '0'         => __('Custom', 'steelnova')
            ],
            'default' => 'primary'
        ]);
        $this->textarea([
            'name' => 'subtitle_text',
            'label' => __( 'Subtitle Text', 'steelnova' ),
            'rows' => 5,
            'default' => __('Subtitle', 'steelnova')
        ]);       
        $this->icons([
            'name' => 'subtitle_icon',
            'label' => __( 'Subtitle Icon', 'steelnova' ),
            'default' => []
        ]);  
        $this->end_controls_section();
    }

    /**
     * Register Title Content Controls.
     */
    protected function register_title_content_controls() {
        $this->start_content_section([
            'name'  => 'section_title_content',
            'label' => __( 'Title', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_style',
            'label' => __('Title Style', 'steelnova'),
            'options' => [
                ''    => __('Default', 'steelnova'),
                'underline'    => __('Underline', 'steelnova'),
            ],
            'default' => ''
        ]);
        $this->textarea([
            'name'    => 'title_text',
            'label'   => __( 'Title Text', 'steelnova' ),
            'rows'    => 5,
            'default' => __('Title', 'steelnova')
        ]);     
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title Tag HTML', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'default' => 'h3'
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Text Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .heading .heading__title',
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .heading .heading__title',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'steelnova' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'steelnova' ),
					'selectors' => [
						'{{WRAPPER}} .heading .heading__title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading__title' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading__title' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls
     */
    protected function register_subtitle_style_controls() {
        $this->start_style_section([
            'name' => 'section_subtitle_style',
            'label' => __( 'Subtitle', 'steelnova' ),
            'condition' => [
                'subtitle_text!' => '',
            ],
        ]);
        $this->group_typography([
            'name' => 'subtitle_typography',
            'selector' => '{{WRAPPER}} .heading .heading__subtitle',
        ]);
        $this->group_background([
			'name' => 'subtitle_fill',
			'selector' => '{{WRAPPER}} .heading .heading__subtitle',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'steelnova' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'steelnova' ),
					'selectors' => [
						'{{WRAPPER}} .heading .heading__subtitle' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading__subtitle' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading__subtitle' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_background([
            'name' => 'subtitle_background',
            'selector' => '{{WRAPPER}} .heading .heading__subtitle',
        ]);
        $this->group_box_css([
            'name' => 'subtitle_',
            'selector' => '{{WRAPPER}} .heading .heading__subtitle',
        ]);
        $this->end_controls_section();
    }

        /**
     * Register Text Style Controls
     */
    protected function register_subtitle_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_subtitle_icon_style',
            'label' => __( 'Subtitle Icon', 'steelnova' ),
            'condition' => [
                'subtitle_text!' => '',
            ],
        ]);

        $this->color([
            'name' => 'subtitle_icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .heading .heading__subtitle-icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->group_background([
            'name' => 'subtitle_icon_background',
            'selector' => '{{WRAPPER}} .heading .heading__subtitle-icon',
        ]);
        $this->group_box_css([
            'name' => 'subtitle_icon',
            'selector' => '{{WRAPPER}} .heading .heading__subtitle-icon',
        ]);
        $this->end_controls_section();
    }
}