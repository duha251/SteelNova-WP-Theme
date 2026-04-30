<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Testimonial_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-testimonial-carousel',
            'title'      => __( 'CS Testimonial Carousel', 'steelnova' ),
            'icon'       => 'eicon-testimonial-carousel',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'testimonial', 'quote', 'review', 'client', 'feedback', 'comment', 'text', 'typography', 'carousel', 'swiper', 'slider' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-widget-testimonial']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_main_content_controls();
        $this->register_author_content_controls();
        $this->register_rating_content_controls();
        $this->register_icon_content_controls();
        $this->register_images_content_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**  
     * Register Layout Controls
    */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'steelnova')
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'steelnova'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Testimonial 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Testimonial 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_main_content_controls() {
        $this->start_content_section([
            'name' => 'section_main_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->textarea([
            'name'  => 'content',
            'label' => __('Content', 'steelnova'),
            'rows' => 10,
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'steelnova'),
        ], $repeater);
        $this->repeater([
            'name' => 'content_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Rating Content Controls.
     */
    protected function register_rating_content_controls() {
        $this->start_content_section([
            'name' => 'section_rating_content',
            'label' => __( 'Rating', 'steelnova' ),
        ]);
        $this->text([
            'name' => 'rating_label',
            'label' => __('Label', 'steelnova'),
            'default' => __('Rating', 'steelnova'),
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $repeater = new \Elementor\Repeater();
        $this->number([
            'name'  => 'rating',
            'label' => __('Rating', 'steelnova'),
            'min' => 1,
            'max' => 5,
            'default' => 5,
        ], $repeater);
        $this->repeater([
            'name' => 'rating_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Icon Controls.
     */
    protected function register_icon_content_controls() {
        $this->start_content_section([
            'name' => 'section_icon_content',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ], $repeater);
        $this->repeater([
            'name' => 'icon_items',
            'label' => __('Own Icons', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Icon Controls.
     */
    protected function register_images_content_controls() {
        $this->start_content_section([
            'name' => 'section_image_content',
            'label' => __( 'Image', 'steelnova' ),
            'condition' => [
                'layout' => ['2']
            ]
        ]);
        $this->switcher([
            'name' => 'show_image',
            'label' => __('Show Image', 'steelnova'),
            'default' => 'yes'
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
            'condition' => [
                'show_image' => 'yes'
            ]
        ]);
        $repeater = new \Elementor\Repeater();
        $this->media([
            'name'  => 'img',
            'label' => __('Image', 'steelnova'),
            'default' => [
                'id' => 0
            ]
        ], $repeater);
        $this->repeater([
            'name' => 'img_items',
            'label' => __('Images', 'steelnova'),
            'fields' => $repeater->get_controls(),
            'condition' => [
                'show_image' => 'yes'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Author Content Controls.
     */
    protected function register_author_content_controls() {
        $this->start_content_section([
            'name' => 'section_author_content',
            'label' => __( 'Author', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->media([
            'name' => 'author_image',
            'label' => __('Image', 'steelnova'),
            'default' => [
                'id' => 0
            ]
        ], $repeater);
        $this->text([
            'name' => 'author_name',
            'label' => __('Name', 'steelnova'),
            'default' => __('John Doe', 'steelnova'),
        ], $repeater);
        $this->text([
            'name' => 'author_title',
            'label' => __('Title', 'steelnova'),
            'default' => __('Web Developer', 'steelnova'),
        ], $repeater);

        $this->repeater([
            'name' => 'author_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

}