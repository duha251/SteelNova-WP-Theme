<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Link extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-link',
            'title'      => __( 'CS Link', 'steelnova' ),
            'icon'       => 'eicon-editor-link',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'button', 'click', 'cta', 'call to action', 'link', 'steelnova', 'btn', 'url', 'href', 'anchor', 'navigation', 'redirect', 'external', 'internal', 'text link', 'icon link', 'button link', 'hover effect', 'toggle', 'submit', 'play' ],
            'script'     => [],
            'style'      => ['steelnova-widget-link']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_style_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_style_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_style_controls() {
        $this->start_layout_section([
            'name' => 'section_layout_style',
            'label' => __( 'Layout Style', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'gap',
            'label' => __('Gap', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-link' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Link', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'link_style',
            'label' => __('Link Style', 'steelnova'),
            'default' => '',
            'options' => [
                '' => __('Text Link', 'steelnova'),
                'underline' => __('Underline', 'steelnova'),
            ]
        ]);
        $this->size([
            'name' => 'line_thickness',
            'label' => __('Thickness', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-link--underline::before' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'link_style' => ['underline'],
            ]
        ]);
        $this->text([
            'name' => 'text',
            'label' => __('Link Text', 'steelnova'),
            'default' => __('Click here', 'steelnova'),
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __('Link Icon', 'steelnova'),
            'default' => [
            ],
        ]);

        $this->url([
            'name' => 'link',
            'separator' => 'before',
            'default' => [
                'url' => '#'
            ]
        ]);
        $this->select([
            'name' => 'link_type',
            'label' => __('Link Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''        => __('Redirect', 'steelnova'),
                'toggle'  => __('Toggle', 'steelnova'),
                'submit'  => __('Submit', 'steelnova'),
                'play'    => __('Play', 'steelnova'),
                'anchor'  => __('Anchor', 'steelnova'),
            ]
        ]);
        $this->select([
            'name'  => 'wpcf7_id',
            'label' => __('Submit To Form', 'steelnova'),
            'default' => '0',
            'options' => Static_Options::get_wpcf7_options(),
            'condition' => [
                'link_type' => ['submit'],
            ]
        ]);
        $this->text([
            'name' => 'target',
            'label' => __('Target ID or Class', 'steelnova'),
            'placeholder' => __('Eg: #id-name', 'steelnova'),
            'condition' => [
                'link_type' => ['toggle', 'anchor'],
            ]
        ]);
        $this->number([
            'name' => 'offset',
            'label' => __('Offset(px)', 'steelnova'),
            'default' => 0,
            'min' => 0,
            'condition' => [
                'link_type' => ['anchor'],
            ]
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Button Style Controls
     */
    protected function register_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __( 'Link', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .cs-link',
            'separator' => 'before'
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
                '{{WRAPPER}} .cs-link' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_box_css([
            'name' => 'link_box_css',
            'selector' => '{{WRAPPER}} .cs-link',
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
                '{{WRAPPER}} .cs-link:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_box_css([
            'name' => 'link_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-link:hover',
        ]);
        $this->select([
            'name' => 'link_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'options' => [
                ''    => __('None', 'steelnova'),
            ],
        ]);
        $this->time([
            'name' => 'link_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}