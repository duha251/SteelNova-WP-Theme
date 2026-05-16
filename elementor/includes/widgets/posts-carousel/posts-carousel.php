<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Posts_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-posts-carousel',
            'title'      => __( 'CS Posts Carousel', 'steelnova' ),
            'icon'       => 'eicon-posts-carousel',
            'keywords'   => [ 'posts', 'carousel', 'blog', 'news', 'steelnova', 'cs', 'casetheme' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper', 'steelnova-widget-post'],
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
        // $this->register_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        $this->register_post_display_settings_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __( 'Choose Layout', 'steelnova' ),
            'options' => [
                '1' => [
                    'title' => __('Layout 1', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/posts-1.webp'),
                ],
                '2' => [
                    'title' => __('Layout 2', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/posts-2.webp'),
                ],
                '3' => [
                    'title' => __('Layout 3', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/posts-3.webp'),
                ],
                '4' => [
                    'title' => __('Layout 4', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/posts-4.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Source', 'steelnova' ),
        ]);
        $this->hidden([
            'name' => 'post_type',
            'default' => 'post',
        ]);
        $this->select([
            'name' => 'source_type',
            'label' => __('Source Type', 'steelnova'),
            'default' => 'id' ,
            'options' => [
                'id'       => __('ID', 'steelnova'),
                'category' => __('Category', 'steelnova'),
            ]
        ]);
        $this->select2([
            'name' =>'ids',
            'label_block' => true,
            'label' => __('List Post', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_post_list( 'post' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'id',
            ]
        ]);
        $this->select2([
            'name' =>'categories',
            'label_block' => true,
            'label' => __('Categories', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_category_list( 'category' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'category',
            ]
        ]);
        $this->select([
            'name' => 'orderby',
            'label' => __('Order By', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'date'  => __('Date', 'steelnova'),
                'title' => __('Title', 'steelnova'),
                'author'=> __('Author', 'steelnova'),
                'id'    => __('ID', 'steelnova'),
                'rand'  => __('Random', 'steelnova'),
            ],
            'default' => 'date'
        ]);
        $this->select([
            'name' => 'order',
            'label' => __('Order', 'steelnova'),
            'options' => [
                'ASC'  => __('Ascending', 'steelnova'),
                'DESC' => __('Descending', 'steelnova'),
            ],
            'default' => 'DESC'
        ]);
        $this->number([
            'name' => 'posts_per_page',
            'label' => __('Posts Per Page', 'steelnova'),
            'min'   => -1,
            'default' => 6,
            'method' => 'add_control',
            'description' => __('To get all posts leave the value as -1', 'steelnova')
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Grid Source Content Controls
     */
    protected function register_post_display_settings_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_archive_display', 
            'label' => __('Display', 'steelnova') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title HTML Tag', 'steelnova'),
            'options' => Static_Options::title_html_tag_options( true ),
            'separator' => 'before',
            'default' => ''
        ]);
        $this->switcher([
            'name' => 'show_btn',
            'label' => __('Show Button', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '2', '3']
            ]
        ]);
        $this->text([
            'name' => 'btn_text',
            'label' => __('Button Text', 'steelnova'),
            'condition' => [
                'layout' => ['1', '2', '3'],
                'show_button' => 'yes', 
            ]
        ]);
        $this->switcher([
            'name' => 'show_layout_feature',
            'label' => __('Show Layout Feature', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->switcher([
            'name' => 'show_date',
            'label' => __('Show Date', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '2', '3', '4']
            ]
        ]);
        $this->text([
            'name' => 'date_format',
            'label' => __('Date Format', 'steelnova'),
            'description' => '<a href="https://www.php.net/manual/en/function.date.php" target="_blank">Learn More.<a/>',
            'placeholder' => __('F d, Y', 'steelnova'),
            'condition' => [
                'layout' => ['2', '4'],
                'show_date' => 'yes'
            ]
        ]);
        $this->switcher([
            'name' => 'show_excerpt',
            'label' => __('Show Excerpt', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '2']
            ]
        ]);
        $this->number([
            'name' => 'num_of_words',
            'label' => __( 'Number of Words', 'steelnova' ),
            'min' => -1,
            'description' => __('Show Full Excerpt with value = -1', 'steelnova'),
            'condition' => [
                'layout' => ['1', '2'],
                'show_excerpt' => 'yes'
            ]
        ]);
        
        $this->switcher([
            'name' => 'show_author',
            'label' => __('Show Author', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '4']
            ]
        ]);

        $this->switcher([
            'name' => 'show_category',
            'label' => __('Show Category', 'steelnova'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '2', '3', '4']
            ]
        ]);
        
        $this->end_controls_section();
    }

}