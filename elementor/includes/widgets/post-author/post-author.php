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
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
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