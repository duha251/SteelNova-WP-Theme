<?php
$wrapper_attrs_tmp = [
    'class'  => 'cs-accordion',
    'data-mode'  => $settings['mode'],
    'data-toggle' => $settings['toggle'], 
    'data-layout' => '3'
];

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
                <div class="cs-accordion__icon d-inline-flex-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M5.39401 0.251055C5.72875 -0.083685 6.27133 -0.083685 6.60607 0.251055L11.749 5.39398C12.0837 5.72872 12.0837 6.27132 11.749 6.60605L6.60607 11.749C6.27134 12.0837 5.72874 12.0837 5.39401 11.749C5.05928 11.4142 5.0593 10.8717 5.39401 10.5369L9.07372 6.85717H0.857149C0.38378 6.85717 3.49814e-05 6.47338 0 6.00002C2.76113e-08 5.52662 0.383759 5.14286 0.857149 5.14286H9.07372L5.39401 1.46312C5.05928 1.1284 5.0593 0.585797 5.39401 0.251055Z" fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="cs-accordion__content">
                <?php pxl_print_html( $item['content'] ); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>