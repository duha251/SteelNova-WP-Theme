<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Widget_Post_Social_Share extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova_post_social_share',
            'title'      => __( 'CS Post Social Share', 'steelnova' ),
            'icon'       => 'eicon-share',
            'keywords'   => [ 'steelnova', 'social share', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Social Share', 'steelnova')
        ]);
        $this->text([
            'name' => 'share_label',
            'label' => __('Share Label', 'steelnova'),
            'default' => __('Share:', 'steelnova'),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name' => 'icon',
            'label' => __('Social Icon', 'steelnova'),
        ], $repeater);
        $this->select([
            'name' => 'social',
            'label' => __('Social Network', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'facebook'   => __('Facebook', 'steelnova'),
                'X'           => __('X', 'steelnova'),
                'linkedin'   => __('LinkedIn', 'steelnova'),
                'pinterest'  => __('Pinterest', 'steelnova'),
                'reddit'     => __('Reddit', 'steelnova'),
                'tumblr'     => __('Tumblr', 'steelnova'),
                'whatsapp'   => __('WhatsApp', 'steelnova'),
                'telegram'   => __('Telegram', 'steelnova'),
                'email'      => __('Email', 'steelnova'),
                'instagram'  => __('Instagram', 'steelnova'),
                'youtube'    => __('YouTube', 'steelnova'),
            ],
            'default' => [ 'facebook' ],
        ], $repeater );
        $this->url([
            'name' => 'instagram_url',
            'label' => __('Instagram Profile URL', 'steelnova'),
            'placeholder' => __('https://www.instagram.com/yourprofile', 'steelnova'),
            'default' => [
                'url' => 'https://www.instagram.com/',
            ],
            'condition' => [
                'social_networks' => 'instagram',
            ],
        ], $repeater);
        $this->url([
            'name' => 'youtube_url',
            'label' => __('YouTube Channel URL', 'steelnova'),
            'placeholder' => __('https://www.youtube.com/yourchannel', 'steelnova'),
            'default' => [
                'url' => 'https://www.youtube.com/',
            ],
            'condition' => [
                'social_networks' => 'youtube',
            ],
        ], $repeater);
        $this->repeater([
            'name' => 'items',
            'label' => __('Social Share', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

}