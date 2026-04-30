<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Image extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-image',
            'title'      => __( 'CS Image', 'steelnova' ),
            'icon'       => 'eicon-e-image',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'image', 'photo', 'picture', 'gallery', 'responsive', 'media', 'visual', 'image widget', 'content image' ],
            'script'     => [],
        ];

    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        $this->register_loop_animation_controls();
        // Style Controls
        $this->register_image_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Image', 'steelnova' ),
        ]);
        $this->media([
            'name' => 'img',
            'label' => __('Choose Image', 'steelnova'),
            'default' => [
                'id' => 0
            ]
        ]);  
        $this->image_size([
            'name' => 'img_size',
            'label' => __('Image Size', 'steelnova'),
        ]);  
        $this->url([
            'name' => 'link',
            'label' => __('Link', 'steelnova'),
            'separator' => 'before',
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
            'selector' => '{{WRAPPER}} .image-wrapper'
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
                '{{WRAPPER}} .image-wrapper img' => 'width: {{VALUE}};',
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
                    '{{WRAPPER}} .image-wrapper img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .image-wrapper img'
        ]);
        $this->group_box_css([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .image-wrapper img',
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
                '{{WRAPPER}} .image-wrapper:hover img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .image-wrapper:hover img'
        ]);
        $this->color([
            'name' => '_img_border_color',
            'label' => __('Border Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .image-wrapper:hover img' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_box_css([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .image-wrapper:hover',
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