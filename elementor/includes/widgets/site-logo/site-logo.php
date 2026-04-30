<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Site_Logo extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-site-logo',
            'title'      => __( 'CS Site Logo', 'steelnova' ),
            'icon'       => 'eicon-site-logo',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Site Logo', 'steelnova' ),
        ]);
        $this->media([
            'name' => 'image',
            'label' => __( 'Choose Logo', 'steelnova' ),
            'default' => [
                'id' => 0
            ]
        ]);
        $this->group_width([
            'name' => 'image_width',
            'label' => __( 'Logo Width', 'steelnova' ),
            'selector' => '{{WRAPPER}} .cs-site-logo .cs-site-logo__image',
        ]);
        $this->group_height([
            'name' => 'image_height',
            'label' => __( 'Logo Height', 'steelnova' ),
            'selector' => '{{WRAPPER}} .cs-site-logo .cs-site-logo__image',
        ]);
        $this->select([
            'name' => 'oj_fit',
            'label' => __('Object Fit', 'steelnova'),
            'options' => Static_Options::object_fit_css_options(),
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .cs-site-logo .cs-site-logo__image' => 'object-fit: {{VALUE}};'
            ]
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before',
            'default' => [
                'url' => home_url('/')
            ]
        ]);        
        $this->end_controls_section();
    }
}