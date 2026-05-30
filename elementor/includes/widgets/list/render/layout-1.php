<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$wrapper_attrs = array_merge( 
    [
        'class' => 'icon-text',
    ], 
    $wrapper_attrs
);

?>

<ul class="cs-list">
    <?php foreach ( $settings['items'] as $i => $item ) : ?>
        <?php
            $item_key = 'item-' . $i;
            $item_attrs = [
                'class' => 'cs-list__item elementor-repeater-item-'.$item['_id']
            ];

            if( !empty( $item['hover_style'] ) ) {
                $item_attrs['data-hover'] = $item['hover_style'];
            }

            if( !empty( $item['item_entrance_anim'] ) ) {
                $item_attrs['class'] .= ' '.$item['item_entrance_anim'];
            }

            $item_link_attrs = steelnova_elementor_get_link_attributes( $item['link'] );
            $item_text_tag = 'span';
            $item_text_class = 'cs-list__item-text';
            if( !empty( $item_link_attrs ) ) {
                $item_text_tag = 'a';
                $item_text_class = 'cs-list__item-link';
            }
            $this->add_render_attribute( $item_key, $item_attrs);
        ?>
        <?php if( $settings['has_divider'] && $i !== 0 ) : ?>
            <span class="divider"></span>
        <?php endif; ?>
        <li <?php pxl_print_html($this->get_render_attribute_string( $item_key )); ?>>
            <?php if( !empty( $item['icon']['value'] ) ) : ?>
                <span class="cs-list__item-icon">
                    <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
                </span>
            <?php endif; ?>
            <<?php echo esc_attr( $item_text_tag ); ?> <?php pxl_print_html( $item_link_attrs ); ?> class="<?php echo esc_attr(  $item_text_class); ?>">
                <?php echo esc_html( $item['text'] ); ?>
            </<?php echo esc_attr( $item_text_tag ); ?>>
        </li>
    <?php endforeach; ?>
</ul>