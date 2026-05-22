<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Tabs extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-tabs',
            'title'      => __( 'CS Tabs', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'tab', 'site tab', 'brand', 'branding', 'header tab', 'website tab', 'company tab', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => ['steelnova-tabs'],
            'style'      => ['steelnova-widget-tabs']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Settings Controls
        $this->register_display_settings_controls();
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
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
            'name' => 'layout',
            'label' => __( 'Choose Layout', 'steelnova' ),
            'options' => [
                '1' => [
                    'title' => __('Layout 1', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/tabs-1.webp'),
                ],
                '2' => [
                    'title' => __('Layout 2', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/tabs-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse') 
        ]);
        $repeater = new \Elementor\Repeater();
        $this->text([
            'name'    => 'title',
            'label'   => __('Tab Title', 'steelnova'),
            'separator' => 'before',
            'default' => __('Tab Title', 'steelnova'),
        ], $repeater);
        $this->select([
            'name' => 'content',
            'label' => __('Tab Content', 'steelnova'),
            'options' => Static_Options::get_templates_by_type('tab'),
            'default' => ''
        ], $repeater);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

            /**
     * Register Grid Source Content Controls
     */
    protected function register_display_settings_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_archive_display', 
            'label' => __('Display', 'steelnova') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title HTML Tag', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'separator' => 'before',
            'default' => 'div'
        ]);
        $this->end_controls_section();
    }
}