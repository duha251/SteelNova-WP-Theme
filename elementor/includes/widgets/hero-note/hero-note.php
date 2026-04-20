<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Hero_Note extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-hero-note',
            'title'      => __( 'CS Hero Note', 'steelnova' ),
            'icon'       => 'eicon-notes',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'heading', 'note', 'text', 'typography', 'content', 'h1', 'h2', 'h3', 'heading editor', 'hero', 'post', 'page' ],
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
        $this->register_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
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
                '{{WRAPPER}} .hero-note' => 'text-align: {{VALUE}};',
            ],
        ]);
        $this->select([
            'name' => 'remove_br',
            'label' => __('Off break line', 'steelnova'),
            'options' => [
                'none' => __('Yes', 'steelnova'),
                ''     => __('No', 'steelnova')
            ],
            'default' => '',
            'method' => 'add_responsive_control',
            'render_type' . 'template',
            'selectors' => [
                '{{WRAPPER}} .hero-note br' => 'display: {{VALUE}}'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls
     */
    protected function register_style_controls() {
        $this->start_style_section([
            'name' => 'section_style',
            'label' => __( 'Note', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .hero-note' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .hero-note',
        ]);
        $this->end_controls_section();
    }
}