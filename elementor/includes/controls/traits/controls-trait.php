<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

trait Controls_Trait {
    /**
     * Check validate in control trait
     */
    public static function validate_control_name($args, $function) {
        if ( !isset($args['name']) || trim($args['name']) === '' ) {
            error_log(sprintf(
                '[SteelNova Widget] Missing or empty "name" in %s() control definition.',
                $function
            ));
            return false;
        }
        return true;
    }

    /**
     * Register helpers function 
     * Use with control group name = name + group_control_name
     */
    protected function _register_control_helper( $elementor_method, $args, $defaults, $caller_function_name, $name_suffix = '' ) {
    
        if ( ! $this->validate_control_name($args, $caller_function_name) ) {
            return;
        }

        $prefix_name = $args['name']; 
        $elementor_method = isset($args['method']) && !empty($args['method']) ? $args['method'] : $elementor_method;

        if($elementor_method !== 'add_group_control') {
            unset($args['name']); 

            $final_control_name = $prefix_name . $name_suffix;
            
            $this->{$elementor_method}(
                $final_control_name, 
                array_merge($defaults, $args) 
            );
            return;
        }
        
        if ( empty($args['type']) ) {
            trigger_error('Args for _register_control_helper (group control) must include a "type" key.', E_USER_WARNING);
            return;
        }

        $control_type = $args['type']; 
        unset($args['type']);         
        
        $args['name'] = $prefix_name . $name_suffix;

        
        $this->{$elementor_method}(
            $control_type, 
            array_merge($defaults, $args)
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_CONTENT section
     */
    protected function start_content_section($args = []) {
        $defaults = [
            'tab' => Controls_Manager::TAB_CONTENT,
        ];
        
        $this->_register_control_helper(
            'start_controls_section', // Elementor function name
            $args,                    // The arguments
            $defaults,                // Default
            __FUNCTION__              // This function (start_content_section)
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_STYLE section
     */
    protected function start_style_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_STYLE,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_SETTINGS section
     */
    protected function start_settings_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_SETTINGS,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_LAYOUT section
     */
    protected function start_layout_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_LAYOUT,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_ADVANCED section
     */
    protected function start_advanced_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_ADVANCED,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start controls tab normal
     */
    public function _start_controls_tabs( $args = [] ) {
        $defaults = [];

        $this->_register_control_helper(
            'start_controls_tabs', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start controls tab normal
     */
    public function _start_controls_tab( $args = [] ) {
        $defaults = [
            'label' => __('Tab', 'steelnova')
        ];

        $this->_register_control_helper(
            'start_controls_tab', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick heading control 
     */
    protected function heading( $args = [] ) {
        $defaults = [
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick icon control
     */
    protected function icons($args = []) { 
        $defaults = [
            'label' => __( 'Icon', 'steelnova' ), 
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Quick slider control
     */
    protected function slider( $args = [] ) {
        $defaults = [
            'label' => __( 'Slider', 'steelnova' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ],
            'default' => [
                'unit' => 'px',
            ],
        ];

        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Quick divider
     */
    protected function divider( $args = [] ) {
        $defaults = [
            'type' => Controls_Manager::DIVIDER,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick color style
     */
    protected function color( $args = [] ) {
        $defaults = [
            'label' => __( 'Color', 'steelnova' ),
            'type' => Controls_Manager::COLOR,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick dimension control
     */
    protected function dimensions( $args = [] ) {
        $defaults = [
            'label' => __( 'Dimension', 'steelnova' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'custom' ],
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick media control
     */
    protected function media( $args = [] ) {
        $defaults = [
            'label' => __( 'Media', 'steelnova' ),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick link url
     */
    protected function url($args = []) {
        $defaults = [
            'label' => __( 'Link', 'steelnova' ),
            'type' => Controls_Manager::URL,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick text control
     */
    protected function text( $args = [] ) {
        $defaults = [
            'label' => __( 'Text', 'steelnova' ),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick Select Controls
     */
    protected function select( $args = [] ) {
        $defaults = [
            'label' => __( 'Select', 'steelnova' ),
            'type' => Controls_Manager::SELECT,
            'render_type' => 'template',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick Select2 Controls
     */
    protected function select2( $args = [] ) {
        $defaults = [
            'label' => __( 'Select 2', 'steelnova' ),
            'type' => Controls_Manager::SELECT2,
            'render_type' => 'template',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick textare control 
     */
    protected function textarea($args = []) {
        $defaults = [
            'label' => __( 'Textarea', 'steelnova' ),
            'type' => Controls_Manager::TEXTAREA,
            'placeholder' => __( 'Type your here', 'steelnova' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick choose control
     */
    protected function choose($args = []) {
        $defaults = [
            'label' => __( 'Choose', 'steelnova' ),
            'type' => Controls_Manager::CHOOSE,
            'toggle' => true,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick popover_
     */
    protected function popover_toggle( $args = [] ) {
        $defaults = [
            'label' => __( 'Popover Toggle', 'steelnova' ),
            'type' => 'popover_toggle',
            'return_value' => 'yes',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick text editor
     */
    protected function text_editor( $args = [] ) {
        $defaults = [
            'label' => __( 'Text Editor', 'steelnova' ),
            'type' => 'wysiwyg',
            'placeholder' => esc_html__( 'Type your description here!', 'steelnova' ),
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'steelnova'),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Repeater
     */
    protected function repeater( $args = [] ) {
        $defaults = [
            'label' => __( 'Repeater', 'steelnova' ),
            'type' => 'repeater',
            'prevent_empty' => false,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * 
     */
    protected function image_size( $args = [] ) {
        $defaults = [
            'type' => 'image_dimensions',
            'label' => __( 'Image Size', 'steelnova' ),
            'label_block' => true,
            // 'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    protected function switcher( $args = [] ) {
        $defaults = [
            'type' => 'switcher',
            'label' => __( 'Switcher', 'steelnova' ),
            'default' => '',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    } 

    protected function number( $args = [] ) {
        $defaults = [
            'type' => 'number',
            'label' => __( 'Number', 'steelnova' ),
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    } 

    /**
     * Visual Choice
     */
    protected function visual_choice( $args = [] ) {
        $defaults = [
            'type' => 'visual_choice',
            'label' => __( 'Visual Choice', 'steelnova' ),
            'label_block' => true,
            'columns' => 2,
            'toggle' => false
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Visual Choice
     */
    protected function hidden( $args = [] ) {
        $defaults = [
            'type' => 'hidden',
            'label' => __( 'Hiddden', 'steelnova' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group typography control
     */ 
    protected function group_typography($args = []) {
        $args['type'] = \Elementor\Group_Control_Typography::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_border( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Border::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_box_shadow( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Box_Shadow::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_background( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Background::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group Filter control
     */ 
    protected function group_css_filter( $args = [] ) {
        $args['type'] = \Elementor\Group_Control_Css_Filter::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group text shadow control
     */ 
    protected function group_text_shadow($args = []) {
        $args['type'] = \Elementor\Group_Control_Text_Shadow::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group text stroke control
     */ 
    protected function group_text_stroke($args = []) {
        $args['type'] = \Elementor\Group_Control_Text_Stroke::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick group flex css control
     */ 
    protected function group_flex_css($args = []) {
        $args['type'] = \SteelNova\Elementor\Controls\Group_Control_Flex_CSS::get_type();
        $defaults = [];
        $this->_register_control_helper(
            'add_group_control',
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

}