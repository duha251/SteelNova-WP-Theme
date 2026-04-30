<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Author extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-post-author',
            'title'      => __( 'CS Post Author', 'steelnova' ),
            'icon'       => 'eicon-user-circle-o',
            'keywords'   => [ 'steelnova', 'author', 'post' ],
            'style'      => ['steelnova-widget-post-author']
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        $this->register_layout_controls();
        // Content
        $this->register_content_controls();
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
                    'title' => esc_attr__( 'Post Author 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Post Author 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Author', 'steelnova')
        ]);
        $this->number([
            'name' => 'avatar_size',
            'label' => __( 'Avatar Size', 'steelnova' ),
            'default' => 133,
            'min' => 16,
            'max' => 512,
            'step' => 1,
            'description' => __( 'Set the size of the author avatar in pixels.', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }
}