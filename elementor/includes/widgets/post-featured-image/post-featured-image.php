<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Featured_Image extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova_post_featured_image',
            'title'      => __( 'CS Post Featured Image', 'steelnova' ),
            'icon'       => 'eicon-featured-image',
            'keywords'   => [ 'cs', 'steelnova', 'image', 'img', 'featured image', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style 
        $this->register_image_style_controls();
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Featured Image' , 'steelnova')
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Image Style Controls
     */
    protected function register_image_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_image_style', 
            'label' => __('Image', 'steelnova'),
        ]);
        $this->group_width([
            'name' => 'box_width',
            'label' => __('Image Box', 'steelnova'),
            'selector' => '{{WRAPPER}} .cs-post-featured-image'
        ]);
        $this->select([
            'name' => 'img_width',
            'label' => __('Image Width', 'steelnova'),
            'options' => [
                'auto' => __('Auto', 'steelnova'),
                '100%' => __('Full Width', 'steelnova'),
                '' => __('Custom', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-post-featured-image img' => 'width: {{VALUE}};',
            ],
        ]);
        $this->start_controls_tabs('img_styles');

        // Normal
        $this->_start_controls_tab([
            'name' => 'img_tab_normal',
            'label' => __('Normal', 'steelnova'),
        ]);
        $this->opacity([
                'name' => 'img_opacity',
                'selectors' => [
                    '{{WRAPPER}} .cs-post-featured-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .cs-post-featured-image img'
        ]);
        $this->group_box_css([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .cs-post-featured-image img',
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'img_tab_hover',
            'label' => __('Hover', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'img_hover_opacity',
            'selectors' => [
                '{{WRAPPER}} .cs-post-featured-image:hover img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .cs-post-featured-image:hover img'
        ]);
        $this->color([
            'name' => '_img_border_color',
            'label' => __('Border Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-post-featured-image:hover img' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_box_css([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .cs-post-featured-image:hover',
        ]);
        $this->select([
            'name' => 'img_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                ''         => __('None', 'steelnova'),
                'zoomIn'  => __('Zoom In', 'steelnova'),
                'parallax' => __('Parallax', 'steelnova'),
                'tilt'     => __('Tilt', 'steelnova'),
                'distortionTransition' => __('Distortion Transition', 'steelnova'),
                'overlayShine' => __('Overlay Shine', 'steelnova'),
                'flowmapDeformation' => __('Flowmap Deformation', 'steelnova'),
                'flowmapDeformation2' => __('Flowmap Deformation 2', 'steelnova'),
            ]
        ]);
        $this->text([
            'name' => 'hover_trigger',
            'label' => __('Trigger', 'steelnova'),
            'placeholder' => __('eg: #trigger-id', 'steelnova'),
            'label_block' => false,
            'condition' => [
                'img_hover_style' => ['flowmapDeformation', 'flowmapDeformation2'],
            ]
        ]);
        $this->text([
            'name' => 'parallax_trigger',
            'label' => __('Trigger', 'steelnova'),
            'placeholder' => __('eg: #trigger-id', 'steelnova'),
            'label_block' => false,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->number([
            'name' => 'parallax_intensity',
            'label' => __('Intensity', 'steelnova'),
            'min' => 50,
            'max' => 500,
            'default' => 125,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->number([
            'name' => 'parallax_scale',
            'label' => __('Scale', 'steelnova'),
            'min' => 0,
            'max' => 5,
            'default' => 1,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}