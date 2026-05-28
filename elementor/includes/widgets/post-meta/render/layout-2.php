<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-post-meta',
        'data-layout' => '2'
    ], 
    $wrapper_attrs
);

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>

<ul <?php echo esc_attr( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php foreach ( $settings['items'] as $i => $item ) : ?>
        <?php
            $item_key = 'item-' . $i;
            $item_attrs = [
                'class' => 'cs-post-meta__item elementor-repeater-item-'.$item['_id']
            ];
            if( !empty( $settings['icon_hover_style'] ) ) {
                $item_attrs['data-hover'] = $settings['icon_hover_style'];
            }
            $this->add_render_attribute( $item_key, $item_attrs);
        ?>
        <?php if( $item['meta_type'] !== 'project_info' ) : ?>
            <li <?php pxl_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
                <?php if( !empty( $item['icon']['value'] ) ) : ?>
                    <div class="cs-post-meta__item-icon d-inline-flex-center">
                        <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
                    </div>
                <?php endif; ?>
                <div class="cs-post-meta__item-content">
                    <?php if( !empty( $item['label'] ) ) : ?>
                        <span class="cs-post-meta__item-label">
                            <?php echo esc_html( $item['label'] . ' -' ); ?>
                        </span> 
                    <?php endif; ?>
                    <span class="cs-post-meta__item-value">
                        <?php echo steelnova_get_post_meta_data( $item['meta_type'] ); ?>
                    </span>
                </div>
            </li>
        <?php else : ?>
            <?php
                $project_info = get_post_meta(get_the_ID(), 'project_info', true);
                $count = 0;
                if( ! is_array( $project_info ) ) {
                        printf( '<div style="color:red;">Preview in Single Project.</div>' );                    
                }else {
                    $count = count( $project_info['redux_repeater_data'] ) ?? 0;
                }
                if( $count > 0 ) :
                    for( $i=0; $i<$count; $i++ ) : 
                        $label = $project_info['info_label'][$i] ?? '';
                        $text  = $project_info['info_text'][$i] ?? '';
                        $icon_url  = $project_info['info_icon'][$i]['url'] ?? '';
                    ?>
                        <li <?php pxl_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
                            <?php if( !empty( $icon_url ) ) : ?>
                                <div class="cs-post-meta__item-icon d-inline-flex-center">
                                    <?php steelnova_print_svg_content( $icon_url ); ?>
                                </div>
                            <?php endif; ?>
                            <div class="cs-post-meta__item-content">
                                <?php if( !empty( $label ) ) : ?>
                                    <span class="cs-post-meta__item-label">
                                        <?php echo esc_html( $label . ' -' ); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="cs-post-meta__item-value">
                                    <?php echo esc_html( $text ); ?>
                                </span>
                            </div>
                        </li>
                        <?php
                    endfor;
                endif;
            ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>