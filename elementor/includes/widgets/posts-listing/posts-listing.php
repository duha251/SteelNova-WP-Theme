<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Posts_Listing extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-posts-listing',
            'title'      => __( 'CS Posts Listing', 'steelnova' ),
            'icon'       => 'eicon-post-list',
            'keywords'   => [ 'posts', 'grid', 'blog', 'news', 'steelnova', 'cs', 'casetheme', 'list', 'recent', 'featured', 'popular' ],
            'script'     => [],
            'style'      => ['steelnova-widget-post-listing'],
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
        $this->register_grid_settings_controls();
        $this->register_post_display_settings_controls();
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
                    'title' => esc_attr__( 'Post Listing 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-listing-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Post Listing 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-listing-2.webp'),
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
        $post_types = [
            'post'        => __('Post', 'steelnova'),
            'project'     => __('Project', 'steelnova'),
            'service'     => __('Service', 'steelnova'),
        ];
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Source', 'steelnova' ),
        ]);
        $this->select([
            'name'    => 'post_type',
            'label'   => __('Post Type', 'steelnova'),
            'default' => 'post',
            'options' => $post_types
        ]);
        $this->select([
            'name'    => 'query_type',
            'label'   => __('Query Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''             => __('Default', 'steelnova'),
                'popular'      => __('Popular', 'steelnova'),
                'featured'     => __('Featured', 'steelnova'),
                'random'       => __('Random', 'steelnova'),
                'recent'       => __('Recent', 'steelnova'),
            ],
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

        foreach ($post_types as $key => $value) {        
            $this->select2([
                'name' =>$key.'_ids',
                'label_block' => true,
                'label' => __('List ', 'steelnova') . $value,
                'options' => steelnova()->post_manager->get_cpt_post_list( $key ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'id',
                    'post_type' => $key
                ]
            ]);
            $this->select2([
                'name' =>$key.'_categories',
                'label_block' => true,
                'label' => __('Categories', 'steelnova'),
                'options' => steelnova()->post_manager->get_cpt_category_list( $key === 'post' ? 'category' : $key . '_category' ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'category',
                    'post_type' => $key
                ]
            ]);
        }
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
        $this->text([
            'name' => 'date_format',
            'label' => __('Date Format', 'steelnova'),
            'description' => '<a href="https://www.php.net/manual/en/function.date.php" target="_blank">Learn More.<a/>',
            'placeholder' => __('d M, Y', 'steelnova'),
        ]);
        $this->end_controls_section();
    }

}