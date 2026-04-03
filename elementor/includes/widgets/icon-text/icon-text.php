<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Icon_Text extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-icon-text',
            'title'      => __( 'CS Icon Text', 'steelnova' ),
            'icon'       => 'eicon-icon-box',
            'keywords'   => [ 'icon', 'text', 'header', 'steelnova', 'icon text' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        $this->register_layout_controls();
        $this->register_content_controls();
        parent::register_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name' => 'layout_style',
            'label' => __( 'Layout Style', 'steelnova' ),
            'options' => [
                '0' => [
                    'title' => __( 'Default', 'steelnova' ),
                    'image' => content_url( '/uploads/widget-layouts/layout-default.webp' ),
                ],
                // '1' => [
                //     'title' => __( 'Layout 1', 'steelnova' ),
                //     'image' => content_url( '/uploads/widget-layouts/icon-text-1.webp' ),
                // ],
            ],
            'default' => '0',
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .icon-text',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->text([
            'name' => 'text',
            'label' => __( 'Text', 'steelnova' ),
            'default' => __('Lorem ipsum dolor', 'steelnova')
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before'
        ]);        
        $this->end_controls_section();
    }

}