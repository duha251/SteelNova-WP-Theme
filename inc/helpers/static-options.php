<?php
namespace SteelNova\Inc\Helpers;

class Static_Options {

	public static function get_templates_by_type($template_type = 'df', $meta_type = null){
		$post_list = ['' => 'None'];

		$meta_query = [
			[
				'key'     => 'template_type',
				'value'   => $template_type,
				'compare' => '='
			]
		];

		if( !is_null($meta_type) ) {
			switch ($template_type) {
				case 'header':
					$meta_query[] = [
						'key'     => 'header_type',
						'value'   => $meta_type,
						'compare' => '='
					];
					break;
				case 'hero' :
					$meta_query[] = [
						'key'     => 'hero_display_on',
						'value'   => $meta_type,
						'compare' => 'LIKE'
					];
					break;
			}
		}

		$args = [
			'post_type'      => 'pxl-template',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'posts_per_page' => -1,
			'meta_query'     => $meta_query,
		];

        $posts = get_posts($args);
        foreach($posts as $post){  
        	$template_type = get_post_meta( $post->ID, 'template_type', true );
        	if($template_type == 'df') {
				continue;
			}
            $post_list[$post->ID] = $post->post_title;
        }
         
        return $post_list;
    }

    public static function header_options( $args = [] ){	
        $args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );
        extract( $args );

        $mode_options = [
            'default' => __('Default', 'steelnova'),
            'builder' => __('Builder', 'steelnova'),
            'hide'    => __('Hide', 'steelnova')
        ];
    
        if ( $scope === 'private' ) {
            unset($mode_options['default']);
            $mode_options = ['inherit' => __('Inherit', 'steelnova')] + $mode_options;
        }
    
        return array(
			array(
				'id' => 'header_desktop_heading',
				'title' => __('Header Desktop', 'steelnova'),
				'type'  => 'section',
				'indent' => true,
			),
            array(
                'id'      => $prefix_id.'header_mode',
                'type'    => 'button_set',
                'title'   => __( 'Header Mode', 'steelnova' ),
                'options' => $mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default'
            ),
            array(
                'id'      => $prefix_id.'header_layout',
                'type'    => 'select',
                'title'   => __('Header Layout', 'steelnova'),
                'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
                'options' => self::get_templates_by_type('header'),
                'select2'  => [ 'allowClear' => false ],
                'required' => [ $prefix_id.'header_mode', '=', 'builder' ],
            ),
            array(
                'id'       => $prefix_id.'header_logo',
                'type'     => 'media',
                'title'    => __('Header Logo', 'steelnova'),
                'default' => array(
                    'url' => get_template_directory_uri() . '/assets/imgs/logo.webp'
                ),
                'url'      => false,
                'required' => [ $prefix_id.'header_mode', '=', 'default' ],
            ),
        );    
    }

	public static function header_sticky_options( $args = [] ){	
        $args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );
        extract( $args );

        $mode_options = [
            'default' => __('Default', 'steelnova'),
            'builder' => __('Builder', 'steelnova'),
            'hide'    => __('Hide', 'steelnova')
        ];
    
        if ( $scope === 'private' ) {
            unset($mode_options['default']);
            $mode_options = ['inherit' => __('Inherit', 'steelnova')] + $mode_options;
        }
    
        return array(
			array(
				'id' => 'header_sticky_heading',
				'title' => __('Header Sticky', 'steelnova'),
				'type'  => 'section',
				'indent' => true,
			),
            array(
                'id'      => $prefix_id.'header_sticky_mode',
                'type'    => 'button_set',
                'title'   => __( 'Header Sticky Mode', 'steelnova' ),
                'options' => $mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default',
            ),
            array(
                'id'      => $prefix_id.'header_sticky_layout',
                'type'    => 'select',
                'title'   => __('Header Sticky Layout', 'steelnova'),
                'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
                'options' => self::get_templates_by_type('header', 'sticky'),
                'select2'  => [ 'allowClear' => false ],
                'required' => [
                    [ $prefix_id.'header_sticky_mode', '=', 'builder' ],
                ],
            ),
            array(
                'id'      => $prefix_id.'header_sticky_display_on',
                'type'    => 'button_set',
                'title'   => __( 'Display on', 'steelnova' ),
                'options' => [
                    'up'   => __('Scroll Up', 'steelnova'),
                    'down'   => __('Scroll Down', 'steelnova'),
                ], 
                'default' => 'up',
                'required' => [ $prefix_id.'header_sticky_mode', '!=', 'hide' ],
            ),
        );    
    }

	public static function header_mobile_options( $args = [] ){	
		$args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );
        extract( $args );

        $mode_options = [
			'default' => __('Default', 'steelnova'),
            'builder' => __('Builder', 'steelnova'),
            'hide'    => __('Hide', 'steelnova')
        ];
    
        if ( $scope === 'private' ) {
			unset($mode_options['default']);
            $mode_options = ['inherit' => __('Inherit', 'steelnova')] + $mode_options;
        }
    
        return array(
			array(
				'id' => 'header_mobile_heading',
				'title' => __('Header Mobile', 'steelnova'),
				'type'  => 'section',
				'indent' => true,
			),
            array(
                'id'      => $prefix_id.'header_mobile_mode',
                'type'    => 'button_set',
                'title'   => __( 'Header Mobile Mode', 'steelnova' ),
                'options' => $mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default'
            ),
            array(
                'id'      => $prefix_id.'header_mobile_layout',
                'type'    => 'select',
                'title'   => __('Header Mobile Layout', 'steelnova'),
                'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
                'options' => self::get_templates_by_type('header-mobile'),
                'select2'  => [ 'allowClear' => false ],
                'required' => [ $prefix_id.'header_mobile_mode', '=', 'builder' ],
            ),
					array(
                'id'       => $prefix_id.'header_mobile_logo',
                'type'     => 'media',
                'title'    => __('Header Mobile Logo', 'steelnova'),
                'default' => array(
                    'url' => get_template_directory_uri() . '/assets/imgs/logo.webp'
                ),
                'url'      => false,
                'required' => [ $prefix_id.'header_mobile_mode', '=', 'default' ],
            ),
        );    
    }

	public static function hero_options( $args = [] ){
        $args = array_merge([
            'scope'     => 'global',
            'prefix_id' => '', 
            'meta_key'  => 'page',    
            'title'     => '',
            'note'      => '',
        ], $args );

        extract( $args );

		$mode_options = [
			'default'   => __('Default', 'steelnova'),
			'builder'   => __('Builder', 'steelnova'),
			'hide'      => __('Hide', 'steelnova'),
		];

		if( $scope === 'private' ) {
			unset($mode_options['default']);
			$mode_options = ['inherit' => __('Inherit', 'steelnova')] + $mode_options;
		}

		$final_options = array(
			array(
				'id' => $prefix_id.'hero_heading',
				'title' => __('Hero', 'steelnova'),
				'type'  => 'section',
				'indent' => true,
			),
	        array(
	            'id'      => $prefix_id.'hero_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Hero Mode', 'steelnova' ),
	            'options' => $mode_options, 
                'default' => ($scope === 'private') ? 'inherit' : 'default',
	        ),
	        array(
	            'id'       => $prefix_id.'hero_layout',
	            'type'     => 'select',
	            'title'    => __('Hero Layout', 'steelnova'),
	            'desc'     => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
	            'options'  => self::get_templates_by_type( 'hero', $meta_key ),
	            'required' => [ $prefix_id.'hero_mode', '=', 'builder' ],
				'select2'  => [ 'allowClear' => false ],
	        ),
	    ); 
        if( $scope === 'private' ) {
            $final_options[] = array(
                'id'       => $prefix_id.'hero_title',
                'type'     => 'text',
                'title'    => __('Hero Title', 'steelnova'),
                'required' => [ $prefix_id.'hero_mode', '!=', 'hide' ],
                'default'  => $title
            );
        }
        $final_options[] = array(
            'id'       => $prefix_id.'hero_note',
            'type'     => 'textarea',
            'title'    => __('Hero Note', 'steelnova'),
            'required' => [ $prefix_id.'hero_mode', '!=', 'hide' ],
            'default'  => $note
        );

		return $final_options;
	}

    public static function footer_options( $args = [] ){
        $args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );

        extract( $args );

		$mode_options = [
			'default' => __('Default', 'steelnova'),
			'builder' => __('Builder', 'steelnova'),
			'hide'    => __('Hide', 'steelnova'),
		];

		if ($scope === 'private') {
			unset($mode_options['default']);
			$mode_options = ['inherit' => __('Inherit', 'steelnova')] + $mode_options;
		}

		$final_options = [
            array(
                'id' => $prefix_id.'footer_heading',
                'title' => __('Footer', 'steelnova'),
                'type'  => 'section',
                'indent' => true,
            ),
			array(
	            'id'      => $prefix_id.'footer_mode',
	            'type'    => 'button_set',
	            'title'   => __( 'Footer Mode', 'steelnova' ),
	            'options' => $mode_options, 
                'default' => $scope === 'private' ? 'inherit' : 'default'
	        ),
	        array(
				'id'      => $prefix_id.'footer_layout',
				'type'    => 'select',
				'title'   => __('Footer Layout', 'steelnova'),
				'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
				'options' => self::get_templates_by_type('footer'),
				'default' => 0,
				'select2'  => [ 'allowClear' => false ],
				'required' => [ $prefix_id.'footer_mode', '=', 'builder'],
	        ),
		];
		return $final_options;
	}

    public static function sidebar_options( $args = [] ) {
        $args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );

        extract( $args );

		$mode_options = [
			'none' => __('None', 'steelnova'),
			'left'    => __('Left', 'steelnova'),
			'right' => __('Right', 'steelnova'),
		];

        if( $scope === 'private' ) {
            $mode_options = [
                'inherit' => __('Inherit', 'steelnova'),
                'none'    => __('None', 'steelnova'),
                'left'    => __('Left', 'steelnova'),
                'right'   => __('Right', 'steelnova'),
            ];
        }

        return [
            array(
                'id' => $prefix_id.'sidebar_mode_heading',
                'title' => esc_html__('Sidebar', 'steelnova'),
                'type'  => 'section',
                'indent' => true,
            ),
            array(
                'id'      => $prefix_id.'sidebar_mode',
                'type'    => 'button_set',
                'title'   => __( 'Sidebar Mode', 'steelnova' ),
                'options' => $mode_options,
                'default' => $scope === 'private' ? 'inherit' : 'none',
            ),
            array(
                'id'       => $prefix_id.'sidebar_template_id',
                'type'     => 'select',
                'title'    => __('Sidebar Template', 'steelnova'),
                'options'  => Static_Options::get_templates_by_type('sidebar'),
                'select2'  => [ 'allowClear' => false ],
                'default'  => '',
                'required' => [
                    [ $prefix_id.'sidebar_mode', '!=', 'none' ],
                    [ $prefix_id.'sidebar_mode', '!=', 'inherit' ]
                ]
            ),
        ];
    }

    public static function breadcrumnb_options( $args = [] ) {
        $args = array_merge([
            'scope' => 'global',
            'prefix_id' => '', 
        ], $args );

        extract( $args );

        $final_options = array(
            array(
                'id'       => 'show_home_label',
                'type'     => 'button_set',
                'title'    => __('Home Label Display', 'steelnova'),
                'options'  => [
                    '1'    => __('Show' , 'steelnova'),
                    '0'    => __('Hide', 'steelnova'),
                ],
                'default'  => '1',
            ),
            array(
                'id'       => 'home_label_text',
                'type'     => 'text',
                'title'    => __('Home Label Text', 'steelnova'),
                'default'  => __('Home', 'steelnova'),
                'required' => [ 'show_home_label', '=', '1' ]
            ),
            array(
                'id'       => 'show_page_label',
                'type'     => 'button_set',
                'title'    => __('Page Label Display', 'steelnova'),
                'options'  => [
                    '1'    => __('Show' , 'steelnova'),
                    '0'    => __('Hide', 'steelnova'),
                ],
                'default'  => '1',
            ),
            array(
                'id'       => 'page_label_text',
                'type'     => 'text',
                'title'    => __('Page Label Text', 'steelnova'),
                'default'  => __('Pages', 'steelnova'),
                'required' => [ 'show_page_label', '=', '1' ]
            )
        );

        if( $scope === 'private' ) {
            $final_options = [
                array(
                    'id' => $prefix_id . 'breadcrumb_heading',
                    'title' => __('Breadcrumb', 'steelnova'),
                    'type'  => 'section',
                    'indent' => true,
                ),
                array(
                    'id'      => $prefix_id . 'breadcrumb_text_mode',
                    'type'    => 'button_set',
                    'title'   => __( 'Label Mode', 'steelnova' ),
                    'options' => [
                        'default'   => __( 'Default', 'steelnova' ),
                        'custom'    => __( 'Custom', 'steelnova' ),
                    ], 
                    'default' => 'default',
                ),
                array(
                    'id' => $prefix_id . 'breadcrumb_label_text',
                    'title' => __('Label Text', 'steelnova'),
                    'type'  => 'text',
                    'required' => [ $prefix_id . 'breadcrumb_text_mode', '=', 'custom' ]
                ),
            ];
        }

        return $final_options;
    }

    public static function get_navigation_menu_options() {
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        $pxl_menus = '';
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            $pxl_menus = array(
                '' => __('Default', 'steelnova')
            );
            foreach ( $menus as $value ) {
                if ( is_object( $value ) && isset( $value->name, $value->slug ) ) {
                    $pxl_menus[ $value->slug ] = $value->name;
                }
            }
        }
        return $pxl_menus;
    }

    public static function get_wpcf7_options() {
        $forms = [ 0  => 'Choose Form' ];
        if ( class_exists( 'WPCF7' ) ) {
            $cf7_posts = get_posts([
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            if ( ! empty( $cf7_posts ) ) {
                foreach ( $cf7_posts as $form ) {
                    $forms[ $form->ID ] = $form->post_title;
                }
            } 
        }
        return $forms;
    }

    public static function title_html_tag_options( $has_default = false ) {
        if(  $has_default ) {
            return [
                ''    => __( 'Default', 'steelnova' ),
                'h1'  => __( 'H1', 'steelnova' ),
                'h2'  => __( 'H2', 'steelnova' ),
                'h3'  => __( 'H3', 'steelnova' ),
                'h4'  => __( 'H4', 'steelnova' ),
                'h5'  => __( 'H5', 'steelnova' ),
                'h6'  => __( 'H6', 'steelnova' ),
                'p'   => __( 'Paragraph', 'steelnova' ),
                'div' => __( 'Div', 'steelnova' ),
                'span'=> __( 'Span', 'steelnova' ),
            ];
        }
        return [
            'h1'  => __( 'H1', 'steelnova' ),
            'h2'  => __( 'H2', 'steelnova' ),
            'h3'  => __( 'H3', 'steelnova' ),
            'h4'  => __( 'H4', 'steelnova' ),
            'h5'  => __( 'H5', 'steelnova' ),
            'h6'  => __( 'H6', 'steelnova' ),
            'p'   => __( 'Paragraph', 'steelnova' ),
            'div' => __( 'Div', 'steelnova' ),
            'span'=> __( 'Span', 'steelnova' ),
        ];
    }

    public static function text_align_css_options() {
        return [
            'left' =>  [
                'title' => __('Left', 'steelnova'),
                'icon' => 'eicon-text-align-left',
            ],
            'center' =>  [
                'title' => __('Center', 'steelnova'),
                'icon' => 'eicon-text-align-center',
            ],
            'right' =>  [
                'title' => __('Right', 'steelnova'),
                'icon' => 'eicon-text-align-right',
            ],
            'justify' =>  [
                'title' => __('Justify', 'steelnova'),
                'icon' => 'eicon-text-align-justify',
            ],
        ];
    }

    public static function wpcf7_form_options() {
        $forms = [ 0  => 'Choose Form' ];

        if ( class_exists( 'WPCF7' ) ) {
            $cf7_posts = get_posts([
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            if ( ! empty( $cf7_posts ) ) {
                foreach ( $cf7_posts as $form ) {
                    $forms[ $form->ID ] = $form->post_title;
                }
            } 
        }
        return $forms;
    }

    public static function object_fit_css_options() {
        return [
            ''        => __('Default', 'steelnova'),
            'cover'   => __('Cover', 'steelnova'),
            'contain' => __('Contain', 'steelnova'),
            'fill'    => __('Fill', 'steelnova'),
            'none'    => __('None', 'steelnova'),
        ];
    }

    public static function entrance_animation_options() {
        return [
            [
                'label' => esc_html__( 'None', 'textdomain' ),
                'options' => [
                    '' => esc_html__( 'None', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Bouncing Entrances', 'textdomain' ),
                'options' => [
                    'bounceIn'      => esc_html__( 'Bounce In', 'textdomain' ),
                    'bounceInDown'  => esc_html__( 'Bounce In Down', 'textdomain' ),
                    'bounceInLeft'  => esc_html__( 'Bounce In Left', 'textdomain' ),
                    'bounceInRight' => esc_html__( 'Bounce In Right', 'textdomain' ),
                    'bounceInUp'    => esc_html__( 'Bounce In Up', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Fading Entrances', 'textdomain' ),
                'options' => [
                    'fadeIn'         => esc_html__( 'Fade In', 'textdomain' ),
                    'fadeInDown'     => esc_html__( 'Fade In Down', 'textdomain' ),
                    'fadeInDownBig'  => esc_html__( 'Fade In Down Big', 'textdomain' ),
                    'fadeInLeft'     => esc_html__( 'Fade In Left', 'textdomain' ),
                    'fadeInLeftBig'  => esc_html__( 'Fade In Left Big', 'textdomain' ),
                    'fadeInRight'    => esc_html__( 'Fade In Right', 'textdomain' ),
                    'fadeInRightBig' => esc_html__( 'Fade In Right Big', 'textdomain' ),
                    'fadeInUp'       => esc_html__( 'Fade In Up', 'textdomain' ),
                    'fadeInUpBig'    => esc_html__( 'Fade In Up Big', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Flippers', 'textdomain' ),
                'options' => [
                    'flipInX' => esc_html__( 'Flip In X', 'textdomain' ),
                    'flipInY' => esc_html__( 'Flip In Y', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'LightSpeed', 'textdomain' ),
                'options' => [
                    'lightSpeedIn' => esc_html__( 'LightSpeed In', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Rotating Entrances', 'textdomain' ),
                'options' => [
                    'rotateIn'          => esc_html__( 'Rotate In', 'textdomain' ),
                    'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'textdomain' ),
                    'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'textdomain' ),
                    'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'textdomain' ),
                    'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Sliding Entrances', 'textdomain' ),
                'options' => [
                    'slideInDown'  => esc_html__( 'Slide In Down', 'textdomain' ),
                    'slideInLeft'  => esc_html__( 'Slide In Left', 'textdomain' ),
                    'slideInRight' => esc_html__( 'Slide In Right', 'textdomain' ),
                    'slideInUp'    => esc_html__( 'Slide In Up', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Zoom Entrances', 'textdomain' ),
                'options' => [
                    'zoomIn'      => esc_html__( 'Zoom In', 'textdomain' ),
                    'zoomInDown'  => esc_html__( 'Zoom In Down', 'textdomain' ),
                    'zoomInLeft'  => esc_html__( 'Zoom In Left', 'textdomain' ),
                    'zoomInRight' => esc_html__( 'Zoom In Right', 'textdomain' ),
                    'zoomInUp'    => esc_html__( 'Zoom In Up', 'textdomain' ),
                ],
            ],
            [
                'label' => esc_html__( 'Specials', 'textdomain' ),
                'options' => [
                    'rollIn' => esc_html__( 'Roll In', 'textdomain' ),
                ],
            ],
        ];
    }

    public static function text_animation_options() {
        return [
            ''                          => __('None', 'steelnova'),
            'textRevealUp'              => __('Text Reveal Up', 'steelnova'),
            'textRevealDown'            => __('Text Reveal Down', 'steelnova'),
            'textFadeIn'                => __('Text Fade In', 'steelnova'),
            'textBlurReveal'            => __('Text Blur Reveal', 'steelnova'),
            'textSplitWordsReveal'      => __('Text Split Words Reveal', 'steelnova'),
            'textSplitCharsReveal'      => __('Text Split Chars Reveal', 'steelnova'),
            'textSplitLinesReveal'      => __('Text Split Lines Reveal', 'steelnova'),
            'textMaskReveal'            => __('Text Mask Reveal', 'steelnova'),
            'textStaggerReveal'         => __('Text Stagger Reveal', 'steelnova'),
            'textRotateReveal'          => __('Text Rotate Reveal', 'steelnova'),
            'textScaleReveal'           => __('Text Scale Reveal', 'steelnova'),
            'textSkewReveal'            => __('Text Skew Reveal', 'steelnova'),
            'textClipPathReveal'        => __('Text Clip Path Reveal', 'steelnova'),
            'textColorChangeOnScroll'   => __('Text Color Change On Scroll', 'steelnova'),
            'textGradientReveal'        => __('Text Gradient Reveal', 'steelnova'),
            'textParallax'              => __('Text Parallax', 'steelnova'),
            'textScrubAnimation'        => __('Text Scrub Animation', 'steelnova'),
            'textPinReveal'             => __('Text Pin Reveal', 'steelnova'),
            'textTypewriterOnScroll'    => __('Text Typewriter On Scroll', 'steelnova'),
            'textWaveReveal'            => __('Text Wave Reveal', 'steelnova'),
            'textSlideFromLeft'         => __('Text Slide From Left', 'steelnova'),
            'textSlideFromRight'        => __('Text Slide From Right', 'steelnova'),
            'textOpacityStagger'        => __('Text Opacity Stagger', 'steelnova'),
            'textCounterOnScroll'       => __('Text Counter On Scroll', 'steelnova'),
            'textFlipReveal'            => __('Text Flip Reveal', 'steelnova'),
            'text3DRotateReveal'        => __('Text 3D Rotate Reveal', 'steelnova'),
            'textLineMaskReveal'        => __('Text Line Mask Reveal', 'steelnova'),
            'textWordMaskReveal'        => __('Text Word Mask Reveal', 'steelnova'),
            'textCharacterWaveOnScroll' => __('Text Character Wave On Scroll', 'steelnova'),
        ];
    }
}