<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Products_Listing extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-products-listing',
            'title'      => __( 'CS Posts Listing', 'steelnova' ),
            'categories' => ['steelnova-woo'],
            'icon'       => 'eicon-post-list',
            'keywords'   => [ 'posts', 'grid', 'blog', 'news', 'steelnova', 'cs', 'casetheme' ],
            'script'     => [],
            'style'      => ['steelnova-widget-product'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        // $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        // $this->register_style_controls();
        // Settings Controls
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
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
            'default' => 'product',
        ]);

        $this->select([
            'name'    => 'query_type',
            'label'   => __('Query Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''             => __('Default', 'steelnova'),
                'popular'      => __('Popular', 'steelnova'),
                'featured'     => __('Featured', 'steelnova'),
                'on_sale'      => __('On Sale', 'steelnova'),
                'best_selling' => __('Best Selling', 'steelnova'),
                'top_rated'    => __('Top Rated', 'steelnova'),
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
        $this->select2([
            'name' =>'ids',
            'label_block' => true,
            'label' => __('List Post', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_post_list( 'product' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'id',
            ]
        ]);
        $this->select2([
            'name' =>'categories',
            'label_block' => true,
            'label' => __('Categories', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_category_list( 'product_cat' ),
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


}