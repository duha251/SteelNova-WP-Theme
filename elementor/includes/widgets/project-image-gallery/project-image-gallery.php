<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Project_Image_Gallery extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-project-image-gallery',
            'title'      => __( 'CS Project Gallery', 'steelnova' ),
            'icon'       => 'eicon-featured-image',
            'keywords'   => [ 'cs', 'steelnova', 'image', 'img', 'featured image', 'post' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper'],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style Controls
        $this->register_gallery_container_style_controls();
        $this->register_gallery_slide_style_controls();
        $this->register_gallery_image_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
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
            'label' => __('Image' , 'steelnova')
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    /**
     * Gallery Container (.cs-project-image-garelly)
     * CSS: border-radius: 20px
     */
    protected function register_gallery_container_style_controls() {
        $this->start_style_section([
            'name'  => 'section_gallery_container_style',
            'label' => __( 'Container', 'steelnova' ),
        ]);

        $this->dimensions([
            'name'      => 'gallery_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
        ]);

        $this->group_background([
            'name'     => 'gallery_bg',
            'selector' => '{{WRAPPER}} .cs-project-image-garelly',
        ]);

        $this->group_box_css([
            'name'     => 'gallery_container_',
            'selector' => '{{WRAPPER}} .cs-project-image-garelly',
        ]);

        $this->end_controls_section();
    }

    /**
     * Slide Item (.cs-project-image-garelly .carousel__item)
     * CSS: height: auto
     */
    protected function register_gallery_slide_style_controls() {
        $this->start_style_section([
            'name'  => 'section_gallery_slide_style',
            'label' => __( 'Slide Item', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'slide_height',
            'label'     => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly .carousel__item' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->dimensions([
            'name'      => 'slide_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly .carousel__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
        ]);

        $this->group_background([
            'name'     => 'slide_bg',
            'selector' => '{{WRAPPER}} .cs-project-image-garelly .carousel__item',
        ]);

        $this->end_controls_section();
    }

    /**
     * Image (.cs-project-image-garelly img)
     * CSS: width: 100%, height: 100%
     */
    protected function register_gallery_image_style_controls() {
        $this->start_style_section([
            'name'  => 'section_gallery_image_style',
            'label' => __( 'Image', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'image_width',
            'label'     => __( 'Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'image_height',
            'label'     => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly img' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->select([
            'name'      => 'image_object_fit',
            'label'     => __( 'Object Fit', 'steelnova' ),
            'options'   => [
                ''        => __( 'Default', 'steelnova' ),
                'cover'   => __( 'Cover', 'steelnova' ),
                'contain' => __( 'Contain', 'steelnova' ),
                'fill'    => __( 'Fill', 'steelnova' ),
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly img' => 'object-fit: {{VALUE}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'image_filter_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'image_filter_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_css_filter([
            'name'     => 'image_css_filter',
            'selector' => '{{WRAPPER}} .cs-project-image-garelly img',
        ]);
        $this->opacity([
            'name'      => 'image_opacity',
            'label'     => __( 'Opacity', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'image_filter_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_css_filter([
            'name'     => 'image_css_filter_hover',
            'selector' => '{{WRAPPER}} .cs-project-image-garelly .carousel__item:hover img',
        ]);
        $this->opacity([
            'name'      => 'image_opacity_hover',
            'label'     => __( 'Opacity', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly .carousel__item:hover img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->time([
            'name'      => 'image_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-project-image-garelly img' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}