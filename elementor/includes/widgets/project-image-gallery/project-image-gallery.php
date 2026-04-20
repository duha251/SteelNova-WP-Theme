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
            'style'      => ['swiper'],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
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

}