<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Image_Gallery extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-image-gallery',
            'title'      => __( 'CS Image Garelly', 'steelnova' ),
            'icon'       => 'eicon-gallery-grid',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'gallery', 'image', 'image gallery', 'grid', 'lightbox', 'photos', 'portfolio', 'carousel', 'slider', 'images', 'album', 'collection', 'media' ],
            'script'     => [],
            'style'   => ['swiper']
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
        // Style Controls
        $this->register_image_style_controls();
        // Settings Controls
        $this->register_grid_settings_controls();
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
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .social-icons',
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
        $this->gallery([
            'name' => 'imgs',
            'default' => [
                [ 'id' => 0 ],
                [ 'id' => 0 ],
                [ 'id' => 0 ],
            ]
        ]);
        $this->image_size([
            'name' => 'img_size'
        ]);
        $this->select([
            'name' => 'action',
            'label' => __('Action', 'steelnova'),
            'options' => [
                'link'        => __('Media Link', 'steelnoval'),
                'lightbox'    => __('Lightbox', 'steelnoval'),
                'none'        => __('None', 'steelnoval'),
            ],
            'default' => 'lightbox'
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Image Style
     */
    protected function register_image_style_controls() {
        $this->start_style_section([
            'name' => 'section_image_style',
            'label' => __( 'Style', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'box_img_max_w',
            'label' => __( 'Max Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__item ' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([
            'name' => 'img_controls_tabs'
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'img_normal_tab',
            'label' => __('Normal', 'steelnova')
        ]);
        $this->opacity([
            'name' => 'img_opacity',
            'selectors' => [
                '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image' => 'opacity: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image'
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'img_hover_tab',
            'label' => __('Hover', 'steelnova')
        ]);
        $this->opacity([
            'name' => 'img_opacity_hover',
            'selectors' => [
                '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image:hover' => 'opacity: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_css_filter([
            'name' => 'img_css_filter_hover',
            'selector' => '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image:hover'
        ]);
        $this->group_box_css([
            'name' => 'img_css_hover',
            'selector' => '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image:hover',
        ]);
        $this->time([
            'name' => 'img_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-image-gallery .cs-image-gallery__image' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}