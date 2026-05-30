<?php

if ( ! function_exists( 'steelnova_debug' ) ) {
    function steelnova_debug( $data, $die = false, $label = null ) {
        echo '<pre style="
            background: #1e1e1e;
            color: #dcdcdc;
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.4;
            overflow: auto;
            z-index: 999999;
            position: relative;
        ">';

        if ( $label ) {
            echo "<strong style='color:#9cdcfe;'>[{$label}]</strong>\n";
        }

        if ( is_array( $data ) || is_object( $data ) ) {
            print_r( $data );
        } else {
            var_dump( $data );
        }

        echo '</pre>';

        if ( $die ) {
            die();
        }
    }
}

if ( ! function_exists( 'steelnova_get_template' ) ) {
    function steelnova_get_template( $slug, $args = [] ) {
        $template_file = $slug . '.php';
        $template_path = locate_template( $template_file );

        if ( ! $template_path ) {
            return;
        }

        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args, EXTR_SKIP );
        }

        include $template_path;
    }
}

if( ! function_exists( 'steelnova_elementor_get_icon' ) ) {
    function steelnova_elementor_get_icon( $icon_attrs = [] ) {
        if( ! did_action( 'elementor/loaded' ) || empty( $icon_attrs ) ) {
            return '';
        }
        ob_start();
        \Elementor\Icons_Manager::render_icon( $icon_attrs, [ 'aria-hidden' => 'true' ] );
        return ob_get_clean();
    }
}

if( ! function_exists( 'steelnova_elementor_print_icon' ) ) {
    function steelnova_elementor_print_icon( $icon_attrs = [] ) {
        if( ! did_action( 'elementor/loaded' ) || empty( $icon_attrs ) ) {
            return '';
        }
        \Elementor\Icons_Manager::render_icon( $icon_attrs, [ 'aria-hidden' => 'true' ] );
    }
}

if( ! function_exists( 'steelnova_elementor_get_link_attributes' ) ) {
    function steelnova_elementor_get_link_attributes( $link ) {
        if( !isset ($link['url'] ) || empty( $link['url'] ) ) {
            return '';
        }
        $ouput = 'href="' . esc_url(trim($link['url'])) . '"';
        if ($link['is_external']) {
            $ouput .= ' target="_blank"';
        }
        if ($link['nofollow']) {
            $ouput .= ' rel="nofollow"';
        }
        if (!empty($link['custom_attributes'])) {
            $custom_attributes = explode(',', $link["custom_attributes"]);
            foreach ($custom_attributes as $attr) {
                list($key, $value) = explode('|', $attr);
                $ouput .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
            }
        }
        return $ouput;
    }
}

if( ! function_exists( 'steelnova_elementor_print_link_attributes' ) ) {
    function steelnova_elementor_print_link_attributes( $link ) {
        pxl_print_html( steelnova_elementor_get_link_attributes( $link ) );
    }
}

if( ! function_exists( 'steelnova_elementor_get_builder_content' ) ) {
    function steelnova_elementor_get_builder_content( $id = '' ) {
        $id = empty( $id ) ? 0 : $id;
        if( $id === 0 || !is_numeric( $id ) || !class_exists('Pxltheme_Core') || !class_exists('\Elementor\Plugin') ) {
            return '';
        }
        return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
    }
}

if( ! function_exists( 'steelnova_elementor_print_builder_content' ) ) {
    function steelnova_elementor_print_builder_content( $id = 0 ) {
        echo steelnova_elementor_get_builder_content( $id );
    }
}

if( ! function_exists( 'steelnova_get_carousel_settings' ) ) {
    function steelnova_get_carousel_settings( $settings = [], $args = [] ) {
        if( empty( $settings ) ) {
            return '';
        }
        $params = [];
        $params['effect']    = 'slide';
        $params['direction'] = $settings['swiper_direction'];
        $params['loop']      = $settings['loop'] === 'yes';
        $params['centeredSlides'] = $settings['centered_slides'] === 'yes';
        $params['allowTouchMove'] = $settings['allow_touch_move'] === 'yes';
        $params['autoPlay'] = $settings['auto_play'] === 'yes' ? 
        [
            'enable' => true,
            'delay'  => $settings['delay'] ?: 3000 ,
            'disableOnInteraction' => $settings['disable_on_interaction'] === 'yes',
            'pauseOnMouseEnter' => $settings['pause_on_mouse_enter'] === 'yes',
            'reverseDirection' => $settings['reverse_direction'] === 'yes',
        ] : false ;
        $params['free_mode'] = $settings['free_mode'] === 'yes' ? 
        [
            'enable' => true,
            'sticky' => $settings['free_mode_sticky'] === 'yes',
            'momentum' => $settings['momentum'] === 'yes',
        ] : false;
        $params['initialSlide'] = $settings['initial_slide'] ?: 0;
        $params['mousewheel'] = $settings['mousewheel'] === 'yes';
        $params['speed']      = $settings['speed'] ?: 500;
        $params['navigation'] = $settings['swiper_nav'] === 'yes' ? [
            'prevEl' => $settings['nav_widget_id'] !== '' ? '#' . esc_attr( $settings['nav_widget_id'] ) . ' .cs-navigation-carousel__button--prev' : '#carousel-' . $args['_id'] . ' .carousel__navigation-prev',
            'nextEl' => $settings['nav_widget_id'] !== '' ? '#' . esc_attr( $settings['nav_widget_id'] ) . ' .cs-navigation-carousel__button--next' : '#carousel-' . $args['_id'] . ' .carousel__navigation-next',
        ] : false;
        $params['pagination'] = !empty( $settings['swiper_pagination'] ) ? $settings['swiper_pagination'] : false;
        $params['scrollBar'] = $settings['swiper_scrollbar'] === 'yes';
        

        $params['breakpoints'] = [
            'xs' => [
                'slidesPerView' => $settings['slides_per_view_xs'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows_xs'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between_xs']['column'] ?: 0,
            ],
            'sm' => [
                'slidesPerView' => $settings['slides_per_view_sm'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows_sm'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between_sm']['column'] ?: 0,
            ],
            'md' => [
                'slidesPerView' => $settings['slides_per_view_md'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows_md'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between_md']['column'] ?: 0,
            ],
            'lg' => [
                'slidesPerView' => $settings['slides_per_view_lg'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows_lg'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between_lg']['column'] ?: 0,
            ],
            'xl' => [
                'slidesPerView' => $settings['slides_per_view_xl'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows_xl'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between_xl']['column'] ?: 0,
            ],
            'xxl' => [
                'slidesPerView' => $settings['slides_per_view'],
                'grid' =>  [
                    'rows' => $settings['swiper_grid_rows'],
                    'fill' => 'row'
                ],
                'spaceBetween' => $settings['space_between']['column'] ?: 30,
            ],
        ];

        $params = array_merge($params, $args);

        return $params;
    }
}

if( ! function_exists( 'steelnova_print_carousel_settings') ) {
    function steelnova_print_carousel_settings( $settings = [], $args = []) {
        echo esc_attr( json_encode( steelnova_get_carousel_settings( $settings, $args ) ) );
    }
}

if( ! function_exists( 'steelnova_get_post_meta_data') ) {
    function steelnova_get_post_meta_data( $type = '' ) {

        $post_id = get_the_ID();

        if ( empty( $post_id ) || empty( $type ) ) {
            return '';
        }

        switch ( $type ) {

            // Categories
            case 'categories':
                $post_type = get_post_type( $post_id );
                $category_slug = $post_type === 'post' ? 'category' : $post_type.'-category';
                ob_start();
                the_terms( $post_id, $category_slug, '', ', ' );
                return ob_get_clean();

            // Tags
            case 'tags':
                $post_type = get_post_type( $post_id );
                $tag_slug = $post_type === 'post' ? 'tag' : $post_type.'-tag';
                ob_start();
                the_terms( $post_id, $tag_slug, '', ', ' );
                return ob_get_clean();

            // Date
            case 'date':
                return get_the_date( '', $post_id );

            // Comment Count
            case 'comment' : 
                return get_comments_number( $post_id );

            // View Count
            case 'view_count' : 
                return steelnova()->post_manager->get_post_view( $post_id );

            // Author
            case 'author':
                $author_id = get_post_field( 'post_author', $post_id );
                $author_url  = get_author_posts_url($author_id);
                $author_name = get_the_author_meta('display_name', $author_id);
                return '<a class="'. esc_url( $author_url ) .'">'.esc_html( $author_name ).'</a>';
            case 'project_info' :
                return '';
            // Custom Meta
            default:
                $value = get_post_meta( $post_id, $type, true );

                if ( is_array( $value ) ) {
                    return implode( ', ', $value );
                }

                return esc_html( $value );
        }
    }
}

/**
 * Get user profile picture
 */
if ( ! function_exists( 'steelnova_get_user_avatar' ) ) {
    function steelnova_get_user_avatar( $user_id = 0, $img_size = 96 ) {
        // Nếu không có ID user, không làm gì cả
        if ( empty( $user_id ) || $user_id === 0 ) {
            return get_avatar( $user_id, $img_size );
        }

        $user_avatar_id = get_user_meta( $user_id, 'steelnova_user_avatar_id', true );

        if ( ! empty( $user_avatar_id ) ) {
            $custom_avatar = steelnova_get_image_by_size( $user_avatar_id, $img_size, $img_size );
            if ( $custom_avatar ) {
                return $custom_avatar;
            }
        }

        return get_avatar( $user_id, $img_size );
    }
}

if ( ! function_exists( 'steelnova_print_user_avatar' ) ) {
    function steelnova_print_user_avatar( $user_id = 0, $img_size = 96 ) {
        echo wp_kses_post( steelnova_get_user_avatar( $user_id, $img_size ) );
    }
}

/**
 * Get SVG Content By Image SVG
 */
if( ! function_exists( 'steelnova_get_svg_content') ) {
    function steelnova_get_svg_content( $url ) { 
        if ( empty( $url ) ) {
            return '';
        }

        $content = '';
        
        if ( pathinfo( $url, PATHINFO_EXTENSION ) === 'svg' ) {
            $upload_dir = wp_upload_dir();
            $base_url   = $upload_dir['baseurl'];
            $base_dir   = $upload_dir['basedir'];
            
            $path = wp_normalize_path( str_replace( $base_url, $base_dir, $url ) );
            
            if ( file_exists( $path ) ) {
                $content = file_get_contents( $path );
            }
        } else {
            $attachment_id = attachment_url_to_postid( $url );
            $content = steelnova_get_image_by_size( $attachment_id, null, null, [] );
        }

        return $content;
    }
}

if( ! function_exists( 'steelnova_print_svg_content') ) {
    function steelnova_print_svg_content( $url ) {
        echo steelnova_get_svg_content( $url );
    }
}

if( ! function_exists( 'steelnova_get_prefix_id_option') ) {
    function steelnova_get_prefix_id_option() {
        if( is_404() ) {
            return '404_';
        }elseif( is_single() && !is_singular( 'pxl-template' ) ) {
            return 'single_' . get_post_type() . '_';
        }
        // elseif( is_home() ) {
        //     return 'blog_';
        // }
        return '';
    }
}

if( ! function_exists( 'steelnova_get_swiper_controls' ) ) {    
    function steelnova_get_swiper_controls( $settings = [] ) {
        ob_start();
        if( !empty( $settings['swiper_pagination'] ) ) : ?>
            <div class="carousel__pagination"></div>
        <?php endif; ?>
        <?php
        if( (bool) $settings['swiper_nav'] ) : 
            $use_nav_widget = $settings['use_nav_widget'] === 'yes';
            $nav_class = $use_nav_widget ? ' carousel__navigation--hide' : '';
            $box_gradient_class = !empty( $settings['swiper_nav_btn_background_color_b'] ) || 
                    !empty( $settings['swiper_nav_btn_background_image'] ) ||  
                    !empty( $settings['swiper_nav_btn_hover_background_color_b'] ) || 
                    !empty( $settings['swiper_nav_btn_hover_background_image'] ) ? ' box-gradient' : '';
        ?>
            <div class="carousel__navigation<?php echo esc_attr($nav_class); ?>">
                <div class="cs-button carousel__button carousel__button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                        <path d="M1.03125 7.21875L0 8.25L8.25 16.5L9.28125 15.4687L2.0625 8.25L9.28125 1.03125L8.25 -1.90735e-06L4.125 4.125L1.03125 7.21875Z" fill="#2B2B2B"/>
                    </svg>
                </div>
                <div class="cs-button carousel__button carousel__button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                        <path d="M8.33594 9.28125L9.36719 8.25L1.03125 -1.90735e-06L0 1.03125L7.21875 8.25L0 15.4687L1.03125 16.5L5.24219 12.375L8.33594 9.28125Z" fill="#2B2B2B"/>
                    </svg>
                </div>
            </div>
        <?php endif; ?>
        <?php
        if( (bool) $settings['swiper_scrollbar'] ) : ?>
            <div class="carousel__scrollbar"></div>
        <?php endif; 
        $html = ob_get_clean();
        return $html;
    }
}

if( ! function_exists( 'steelnova_print_swiper_controls' ) ) {
    function steelnova_print_swiper_controls( $settings = [] ) {
        echo steelnova_get_swiper_controls( $settings );
    }
}

if ( ! function_exists( 'steelnova_print_html' ) ) {
	function steelnova_print_html( $html ) {
		echo wp_kses(
			$html,
			[
				'svg' => [
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewBox'     => true,
					'fill'        => true,
					'stroke'      => true,
					'stroke-width' => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true,
				],
				'path' => [
					'd'            => true,
					'fill'         => true,
					'stroke'       => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
					'stroke-linejoin' => true,
				],
				'g' => [
					'fill'      => true,
					'stroke'    => true,
					'clip-path' => true,
				],
				'circle' => [
					'cx'     => true,
					'cy'     => true,
					'r'      => true,
					'fill'   => true,
					'stroke' => true,
				],
				'rect' => [
					'x'      => true,
					'y'      => true,
					'width'  => true,
					'height' => true,
					'rx'     => true,
					'fill'   => true,
					'stroke' => true,
				],
				'line' => [
					'x1'     => true,
					'y1'     => true,
					'x2'     => true,
					'y2'     => true,
					'stroke' => true,
				],
				'polyline' => [
					'points' => true,
					'fill'   => true,
					'stroke' => true,
				],
				'polygon' => [
					'points' => true,
					'fill'   => true,
					'stroke' => true,
				],
				'use' => [
					'href'       => true,
					'xlink:href' => true,
				],
				'defs' => [],
				'clipPath' => [
					'id' => true,
				],
			]
		);
	}
}