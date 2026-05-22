<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Hero_Title extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-hero-title',
            'title'      => __( 'CS Hero Title', 'steelnova' ),
            'icon'       => 'eicon-site-title',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'heading', 'title', 'text', 'typography', 'content', 'h1', 'h2', 'h3', 'heading editor', 'hero', 'post', 'page' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_title_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }


    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Text Align', 'steelnova' ),
        ]);
        $this->choose([
            'name' => 'text_align',
            'label' => __('Text Align', 'steelnova'),
            'options' => Static_Options::text_align_css_options(),
            'selectors' => [
                '{{WRAPPER}} .hero-title' => 'text-align: {{VALUE}};',
            ],
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title Tag HTML', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'default' => 'h2'
        ]);
        $this->select([
            'name' => 'remove_br',
            'label' => __('Off break line', 'steelnova'),
            'options' => [
                'none'           => __('Yes', 'steelnova'),
                ''    => __('No', 'steelnova')
            ],
            'default' => '',
            'method' => 'add_responsive_control',
            'selectors' => [
                '{{WRAPPER}} .hero-title br' => 'display: {{VALUE}}'
            ]
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
            'selector' => '{{WRAPPER}} .hero-title',
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .hero-title',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'steelnova' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'steelnova' ),
					'selectors' => [
						'{{WRAPPER}} .hero-title' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .hero-title' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .hero-title' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->end_controls_section();
    }
}