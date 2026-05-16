<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Member_Info extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-member-info',
            'title'      => __( 'CS Member Info', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => [],
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
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->text([
            'name'        => 'email_label',
            'label'       => __( 'Email Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Email Address', 'mindverse' ),
            'default'     => __( 'Email Address', 'mindverse' ) 
        ]);
        $this->text([
            'name'        => 'phone_number_label',
            'label'       => __( 'Phone Number Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Phone Number', 'mindverse' ),
            'default'     => __( 'Phone Number', 'mindverse' ) 
        ]);
        $this->text([
            'name'        => 'address_label',
            'label'       => __( 'Address Label', 'mindverse' ),
            'placeholder' => __( 'Ex: Address', 'mindverse' ),
            'default'     => __( 'Address', 'mindverse' ) 
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
            'options' => Static_Options::title_html_tag_options( true ),
            'separator' => 'before',
            'default' => ''
        ]);
        $this->end_controls_section();
    }
}