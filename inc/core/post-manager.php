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

    public function get_archive_context() {
        $context = [
            'type'     => '',
            'taxonomy' => '',
            'term'     => '',
            'author'   => '',
            'year'     => '',
            'month'    => '',
            'day'      => '',
            'search'   => '',
        ];

        if ( is_category() || is_tag() || is_tax() ) {
            $term = get_queried_object();

            if ( $term && ! is_wp_error( $term ) && ! empty( $term->taxonomy ) ) {
                $context['type']     = 'taxonomy';
                $context['taxonomy'] = $term->taxonomy;
                $context['term']     = $term->slug;
            }

            return $context;
        }

        if ( is_author() ) {
            $author = get_queried_object();

            if ( $author && ! empty( $author->ID ) ) {
                $context['type']   = 'author';
                $context['author'] = (int) $author->ID;
            }

            return $context;
        }

        if ( is_search() ) {
            $context['type']   = 'search';
            $context['search'] = get_search_query();

            return $context;
        }

        if ( is_date() ) {
            $context['type']  = 'date';
            $context['year']  = get_query_var( 'year' );
            $context['month'] = get_query_var( 'monthnum' );
            $context['day']   = get_query_var( 'day' );

            return $context;
        }

        if ( is_home() ) {
            $context['type'] = 'home';
        }

        return $context;
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

    private function apply_archive_context_to_query_args( &$query_args, $archive_context ) {
        if ( empty( $archive_context ) || ! is_array( $archive_context ) ) {
            return;
        }

        $type = isset( $archive_context['type'] )
            ? sanitize_key( $archive_context['type'] )
            : '';

        switch ( $type ) {
            case 'taxonomy':
                $taxonomy = isset( $archive_context['taxonomy'] )
                    ? sanitize_key( $archive_context['taxonomy'] )
                    : '';

                $term = isset( $archive_context['term'] )
                    ? sanitize_text_field( $archive_context['term'] )
                    : '';

                if ( $taxonomy && $term ) {
                    if ( empty( $query_args['tax_query'] ) ) {
                        $query_args['tax_query'] = [];
                    }

                    $query_args['tax_query'][] = [
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => [ $term ],
                        'operator' => 'IN',
                    ];

                    $query_args['tax_query']['relation'] = 'AND';
                }

                break;

            case 'author':
                if ( ! empty( $archive_context['author'] ) ) {
                    $query_args['author'] = absint( $archive_context['author'] );
                }

                break;

            case 'search':
                if ( ! empty( $archive_context['search'] ) ) {
                    $query_args['s'] = sanitize_text_field( $archive_context['search'] );
                }

                break;

            case 'date':
                $date_query = [];

                if ( ! empty( $archive_context['year'] ) ) {
                    $date_query['year'] = absint( $archive_context['year'] );
                }

                if ( ! empty( $archive_context['month'] ) ) {
                    $date_query['month'] = absint( $archive_context['month'] );
                }

                if ( ! empty( $archive_context['day'] ) ) {
                    $date_query['day'] = absint( $archive_context['day'] );
                }

                if ( ! empty( $date_query ) ) {
                    $query_args['date_query'] = [ $date_query ];
                }

                break;
        }
    }

    public function load_posts_ajax() {
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        check_ajax_referer( 'steelnova_ajax_nonce', '_ajax_nonce' );

        $paged = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
        $layout = isset( $_POST['layout'] ) ? sanitize_text_field( wp_unslash( $_POST['layout'] ) ) : 1;

        $settings = isset( $_POST['settings'] ) && is_array( $_POST['settings'] )
            ? wp_unslash( $_POST['settings'] )
            : [];

        $archive_context = isset( $_POST['archive_context'] ) && is_array( $_POST['archive_context'] )
            ? wp_unslash( $_POST['archive_context'] )
            : [];

        $cat_slug = isset( $_POST['cat_slug'] )
            ? sanitize_text_field( wp_unslash( $_POST['cat_slug'] ) )
            : '';

        $post_type = $settings['post_type'] ?? 'post';

        $query_args = [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => ! empty( $settings['posts_per_page'] ) ? absint( $settings['posts_per_page'] ) : 6,
            'orderby'        => ! empty( $settings['orderby'] ) ? sanitize_key( $settings['orderby'] ) : 'date',
            'order'          => ! empty( $settings['order'] ) ? sanitize_key( $settings['order'] ) : 'DESC',
            'paged'          => $paged,
        ];

        $this->apply_archive_context_to_query_args( $query_args, $archive_context );

        if ( isset( $settings['post__in'] ) && ! empty( $settings['post__in'] ) ) {
            $query_args['post__in'] = array_map( 'absint', (array) $settings['post__in'] );
        }

        if ( isset( $settings['post__not_in'] ) && ! empty( $settings['post__not_in'] ) ) {
            $query_args['post__not_in'] = array_map( 'absint', (array) $settings['post__not_in'] );
        }

        if ( isset( $settings['tax_query'] ) && ! empty( $settings['tax_query'] ) ) {
            if ( empty( $query_args['tax_query'] ) ) {
                $query_args['tax_query'] = [];
            }

            $query_args['tax_query'][] = [
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => array_map( 'absint', (array) $settings['tax_query'] ),
                'operator' => 'IN',
            ];

            $query_args['tax_query']['relation'] = 'AND';
        }

        if ( ! empty( $cat_slug ) && $cat_slug !== '*' ) {
            if ( empty( $query_args['tax_query'] ) ) {
                $query_args['tax_query'] = [];
            }

            $category_taxonomy = $query_args['post_type'] === 'post'
                ? 'category'
                : $query_args['post_type'] . '_category';

            $query_args['tax_query'][] = [
                'taxonomy' => $category_taxonomy,
                'field'    => 'slug',
                'terms'    => (array) $cat_slug,
                'operator' => 'IN',
            ];

            $query_args['tax_query']['relation'] = 'AND';
        }

        extract( $this->get_posts( $query_args ) );

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