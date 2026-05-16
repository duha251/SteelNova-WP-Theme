<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Steps_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-steps-carousel',
            'title'      => __( 'CS Steps Carousel', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper', 'steelnova-widget-steps-carousel']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Settings Controls
        $this->register_display_settings_controls();
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->text([
            'name'    => 'title',
            'label'   => __('Title', 'steelnova'),
            'separator' => 'before',
            'default' => __('Your Title', 'steelnova'),
        ], $repeater);
        $this->textarea([
            'name'  => 'description',
            'label' => __('Description', 'steelnova'),
            'separator' => 'before',
            'rows'  => 10,
            'default' => __('Lorem ipsum dolor sit amet', 'steelnova')
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