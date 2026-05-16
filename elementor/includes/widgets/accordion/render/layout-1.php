<?php
$wrapper_attrs_tmp = [
    'class'  => 'cs-accordion',
    'data-mode'  => $settings['mode'],
    'data-toggle' => $settings['toggle'], 
    'data-layout' => '1'
];

if( $settings['show_divider'] === 'yes' ) {
    $wrapper_attrs_tmp['class'] .= ' has-divider';
}
$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
    <?php foreach($settings['items'] as $i => $item) : 
        $default_active = $settings['default_active'] === ( $i + 1 ) ? ' is-active' : '';

        $this->add_render_attribute('item_wrapper_'.$i, 'class', 'cs-accordion__item' . $default_active  );

        $index_content = $settings['show_index'] === 'yes' ? $settings['index_prefix'] . ( $i + 1 ) . $settings['index_suffix'] : '';
    ?>
        <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
            <div class="cs-accordion__header">
                <<?php echo esc_attr($settings['title_tag']); ?> class="cs-accordion__title">
                    <?php if( $settings['show_index'] === 'yes' ) : ?>
                        <span class="cs-accordion__title-index">
                            <?php echo esc_html( $index_content ); ?>
                        </span>
                    <?php endif; ?>
                    <span class="cs-accordion__title-text">
                        <?php echo esc_html( $item['title'] ); ?>
                    </span>
                </<?php echo esc_attr($settings['title_tag']); ?>>
                <div class="cs-accordion__icon icon-plus">
                </div>
            </div>
            <div class="cs-accordion__content">
                <?php pxl_print_html( $item['content'] ); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>