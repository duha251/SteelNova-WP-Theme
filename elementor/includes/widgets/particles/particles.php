<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Particles extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-particles',
            'title'      => __( 'CS Particles', 'steelnova' ),
            'icon'       => 'eicon-ellipsis-h',
            'script'     => ['steelnova-particles'],
            'keywords'   => [ 'cs', 'steelnova', 'particles', 'par', 'seed', 'nasa', 'star'],
        ];
    }

    protected function register_controls() {
        $this->content_section();
        // Settings
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    protected function content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => 'Content' 
        ]);
        $this->number([
            'name' => 'number',
            'label' => __('Number', 'steelnova'),
        ]);
        $this->number([
            'name' => 'size',
            'label' => __('Size', 'steelnova'),
        ]);
        $this->color([
            'name' => 'color',
            'label' => __('Color' , 'steelnova'),
        ]);
        $this->select([
            'name' => 'shape',
            'label' => __('Shape', 'steelnova'),
            'default' => 'circle',
            'options' => [
                'circle' => __('Circle', 'steelnova'),
                'star'   => __('Star'  , 'steelnova'),
                'image'    => __('Image' , 'steelnova'),
            ]
        ]);
        $this->media([
            'name' => 'shape_img',
            'label' => __('Shape Image', 'steelnova'),
            'condition' => [
                'shape' => ['image']
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Apply all items)', 'steelnova' ),
            'condition' => [
                'shape' => ['image']
            ]
        ]);
        $this->select([
            'name' => 'dir',
            'label' => __('Direction', 'steelnova'),
            'default' => 'none',
            'options' => [
                'none'         => __('Random', 'steelnova'),
                'top'          => __('Top'  , 'steelnova'),
                'top-right'    => __('Top Right' , 'steelnova'),
                'right'        => __('Right', 'steelnova'),
                'bottom-right' => __('Bottom Right', 'steelnova'),
                'bottom'       => __('Bottom', 'steelnova'),
                'bottom-left'  => __('Bottom Left', 'steelnova'),
                'left'         => __('Left', 'steelnova'),
                'top-left'     => __('Top Left', 'steelnova'),
            ]
        ]);

        $this->slider([
            'name' => 'layout_width',
            'label' => __('Width', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-particles' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'layout_max_width',
            'label' => __('Max Width', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-particles' => 'max-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'layout_height',
            'label' => __('Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-particles' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Render */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'particles-js-' . $this->get_id();
        $particles_settings = [
            'number' => $settings['number'] ?? 30,
            'color'  => $settings['color'] ?? '#FFF',
            'dir'    => $settings['dir'],
            'size'   => $settings['size'] ?? 5,
            'shape'  => [
                'type' => $settings['shape'] ??' circle',
                'image' => [
                    'src'    => $settings['shape_img']['url'] ?? '' ,
                    'width'  => $settings['img_size']['width'] ?? 10,
                    'height' => $settings['img_size']['height'] ?? 10 
                ], 
            ],
        ];
        ?>
        <div id="<?php echo esc_attr($widget_id); ?>" class="cs-particles" data-particles-settings="<?php echo esc_attr( wp_json_encode( $particles_settings ) ); ?>"></div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var imgSrc = ( settings.shape_img && settings.shape_img.url ) ? settings.shape_img.url : '';
        
        var imgWidth = 10; 
        var imgHeight = 10;
        if ( settings.img_size && settings.img_size.width ) {
            imgWidth = settings.img_size.width;
        }
        if ( settings.img_size && settings.img_size.height ) {
            imgHeight = settings.img_size.height;
        }

        var particlesSettings = {
            'number': settings.number || 30,
            'color':  settings.color || '#FFF',
            'dir':    settings.dir, 
            'size':   settings.size || 5,
            'shape': {
                'type': settings.shape || 'circle',
                'image': {
                    'src':    imgSrc,
                    'width':  imgWidth,
                    'height': imgHeight
                }
            }
        };
        #>
        <div id="particles-js-{{ view.getID() }}"
             class="cs-particles"
             data-settings='{{ JSON.stringify(particlesSettings) }}'></div>
        <?php
    }
}