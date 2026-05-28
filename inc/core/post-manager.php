<?php
namespace SteelNova\Inc\Core;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use SteelNova\Inc\Frontend\Components;

class Post_Manager {

    /**
     * Name option in database.
     * @var string
     */
	private $component;

    public function __construct( Components $component_instance ) {
        $this->component = $component_instance;
        add_action('wp_ajax_load_posts', [$this, 'load_posts_ajax']);
        add_action('wp_ajax_nopriv_load_posts', [$this, 'load_posts_ajax']);
	}


    /**
     * Get view post count for display
     */
    public function get_post_view($post_id) {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_id, $count_key, true);

        if ( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '0' );
        } else {
            $count ++;
            update_post_meta( $post_id, $count_key, $count );
        }
        
        if ($count >= 1000000) {
            $count = round($count / 1000000, 1) . 'M';
        } elseif ($count >= 1000) {
            $count = round($count / 1000, 1) . 'k';
        }
        return $count;
    }


	/**
	 * Get post list option
	 */
    public function get_cpt_post_list( $post_type = 'post' ) {
        $posts = $this->get_posts([
            'post_type' => $post_type,
            'posts_per_page'  => -1, 
        ])['posts'];
        
        $options = [];
        foreach($posts as $post){
            $options[$post->ID] = $post->post_title;
        }
        return $options;
    }

	/**
	 * Get post category list option
	 */
	public function get_cpt_category_list( $taxonomy = 'category' ) {
		$options = [];
		$args = array(
            'taxonomy'    => $taxonomy,  
			'hide_empty'  => true,    
			'orderby'     => 'name',    
			'order'       => 'ASC'
        );
        $categories = get_terms($args);

		if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$options[ $category->term_id ] = $category->name;
			}
		}
		return $options;
	}

    public function get_cpt_tag_list( $taxonomy = 'post_tag' ) {
		$options = [];
		$args = array(
            'taxonomy'    => $taxonomy,  
			'hide_empty'  => true,    
			'orderby'     => 'name',    
			'order'       => 'ASC'
        );
        $tags = get_terms($args);

		if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
			foreach ( $tags as $category ) {
				$options[ $category->term_id ] = $category->name;
			}
		}
		return $options;
	}
    /**
     * 
     */
    public function get_posts( $custom_args = [] ) {

        $paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

        if( is_home() || is_archive() || is_search() ) {
            global $wp_query;
            $posts = $wp_query->posts;
            $query = $wp_query; 
            return [
                'query' => $query,           
                'posts' => $query->posts,    
            ];
        }

        $default_args = [
            'post_type'        => 'post',   
            'post_status'      => 'publish',
            'posts_per_page'   => 6, 
            'orderby'          => 'date',   
            'order'            => 'DESC', 
            'paged'            => $paged,    
            'suppress_filters' => false,   
            'query_type'       => '',
        ];

        $args = array_merge( $default_args, $custom_args );

        if ( !empty($args['query_type']) ) {

            switch ($args['query_type']) {

                case 'popular':
                    $args['orderby'] = 'comment_count';
                    $args['order']   = 'DESC';
                    break;

                case 'featured':
                    $args['meta_query'][] = [
                        'key'     => 'is_featured',
                        'value'   => '1',
                        'compare' => '='
                    ];
                    break;

                case 'random':
                    $args['orderby'] = 'rand';
                    break;

                case 'recent':
                    $args['orderby'] = 'date';
                    $args['order']   = 'DESC';
                    break;
            }
        }

        unset($args['query_type']);

        $query = new \WP_Query( $args );

        return [
            'query' => $query,           
            'posts' => $query->posts,    
        ];
    }

    public function load_posts_ajax() {
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $layout = isset($_POST['layout']) ? $_POST['layout'] : 1;
        $settings = isset($_POST['settings']) ? $_POST['settings'] : [];
        $cat_slug = isset($_POST['cat_slug']) ? $_POST['cat_slug'] : '';
        
        $post_type = $settings['post_type'] ?? 'post';

        $query_args = [
            'post_type'      => $post_type,
            'posts_per_page' => $settings['posts_per_page'] ?: 6, 
            'orderby'        => $settings['orderby'],   
            'order'          => $settings['order'], 
        ];   
        $query_args['paged'] = $paged;

        if( isset( $settings['post__in'] ) && !empty( $settings['post__in'] ) ) {
            $query_args['post__in'] = $settings['post__in'];
        }

        if( isset( $settings['post__not_in'] ) && !empty( $settings['post__not_in'] ) ) {
            $query_args['post__not_in'] = $settings['post__not_in'];
        }
        
        if( isset( $settings['tax_query'] ) && !empty( $settings['tax_query'] )  ) {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field'    => 'id',
                    'terms'    => $settings['tax_query'],
                    'operator' => 'IN',
                ]
            ];
        }

        if( !empty( $cat_slug ) && $cat_slug !== '*' ) {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => $query_args['post_type'] . '_category',
                    'field'    => 'slug',
                    'terms'    => (array) $cat_slug,
                    'operator' => 'IN',
                ]
            ];
        }

        extract( $this->get_posts($query_args) );

        $display_args = $settings['display_args'] ?? [];

        $html = '';
        ob_start();
        if( count( $posts ) === 0 ) {
            $html = '<div class="message">'.esc_html__('No Posts Found.', 'steelnova').'</div>';
        }else {
            foreach( $posts as $i => $post ) : 
                $display_args['post'] = $post;    
                if( $post_type === 'project' && $layout == '1' ) {
                    $display_args['is_revert'] = $i % 2 === 0;
                }
            ?>
                <div class="grid__item">
                    <?php steelnova_get_template('/elementor/includes/widgets/'.$post_type.'s-grid/templates/'.$post_type.'-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach;
        }
        $html = ob_get_clean();

        $pagination_html = $this->component->get_pagination( $query, true );

        wp_send_json_success([
            'grid_html' => $html,
            'pagination_html' => $pagination_html,
            'post_type' => $post_type
        ]);
    }
}