<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Testimonial extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-testimonial',
            'title'      => __( 'CS Testimonial', 'steelnova' ),
            'icon'       => 'eicon-testimonial',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'testimonial', 'quote', 'review', 'client', 'feedback', 'comment', 'text', 'typography' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        // $this->register_layout_controls();
        // // Content Controls
        // $this->register_main_content_controls();
        // // Steelnova Controls
        // $this->register_steelnova_extra_controls();
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
        $repeater = new Elementor\Repeater();
        // $this->number([
        //     'name'  => 'number_start',
        //     'label' => __('Rating', 'steelnova'),
        //     'min' => 1,
        //     'max' => 5,
        //     'default' => 5,
        // ], $repeater);
        // $this->textarea([
        //     'name'  => 'content',
        //     'label' => __('Content', 'steelnova'),
        //     'rows' => 10,
        //     'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'steelnova'),
        // ], $repeater);
        // $this->media([
        //     'name' => 'user_image',
        //     'label' => __('Image', 'steelnova'),
        //     'separator' => 'before',
        //     'default' => [
        //         'id' => 0
        //     ]
        // ], $repeater);
        // $this->text([
        //     'name' => 'user_name',
        //     'label' => __('Name', 'steelnova'),
        //     'default' => __('John Doe', 'steelnova'),
        // ], $repeater);
        // $this->text([
        //     'name' => 'user_title',
        //     'label' => __('Title', 'steelnova'),
        //     'default' => __('Web Developer', 'steelnova'),
        // ], $repeater);
        // $this->repeater([
        //     'name' => 'items',
        //     'label' => __('Items', 'steelnova'),
        //     'fields' => $repeater->get_controls(),
        //     'default' => [
        //         [
        //             'number_start' => 5,
        //             'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'steelnova'),
        //             'user_image' => [
        //                 'id' => 0
        //             ],
        //             'user_name' => __('John Doe', 'steelnova'),
        //             'user_title' => __('Web Developer', 'steelnova')
        //         ]
        //     ]
        // ]);
        $this->end_controls_section();
    }
}