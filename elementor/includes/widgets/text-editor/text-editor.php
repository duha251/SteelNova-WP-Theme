<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Text_Editor extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-text-editor',
            'title'      => __( 'CS Text Editor', 'steelnova' ),
            'icon'       => 'eicon-text',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'text editor', 'text with', 'content', 'typography' ],
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
        $this->register_text_style_controls();
        $this->register_link_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Text Editor', 'steelnova' ),
        ]);
        $this->choose([
            'name' => 'text_align',
            'label' => __('Text Align', 'steelnova'),
            'options' => Static_Options::text_align_css_options(),
            'selectors' => [
                '{{WRAPPER}} .text-editor' => 'text-align: {{VALUE}};',
            ],
        ]);
        $this->wysiwyg([
            'name' => 'text',
            'label' => __( 'Text Editor', 'steelnova' ),
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'steelnova')
        ]);       
        $this->end_controls_section();
    }


    /**
     * Register Text Style Controls
     */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __( 'Text', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .text-editor',
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .text-editor',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'steelnova' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'steelnova' ),
					'selectors' => [
						'{{WRAPPER}} .text-editor' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .text-editor' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .text-editor' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->end_controls_section();
    }

    /**
     * Register Link Style Controls
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __( 'Link', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .text-editor a',
        ]);

        $this->_start_controls_tabs([
            'name' => 'link_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'link_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'link_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .text-editor a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'link_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'link_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .text-editor a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'link_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .text-editor a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}