<?php
$wrapper_attrs_tmp = [
    'class' => 'counter-box',
    'data-layout' => '2'
];
$wrapper_attrs = array_merge($wrapper_attrs_tmp, $wrapper_attrs);
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$this->add_render_attribute( 'counter-number', [
    'class' => 'counter-box__number-value counter__number',
    'data-starting_number' => $settings['starting_number'] ?: 1,
    'data-ending_number' => $settings['ending_number'] ?: 1,
]);
if( !empty($settings['number_delimiter']) ) {
    $this->add_render_attribute( 'counter-number', 'data-delimiter', $settings['number_delimiter'] );
}
$title_tag = $settings['title_tag'] ?: 'h5';
?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php if( !empty( $settings['icon'] ) ) : ?>
        <div class="counter-box__icon">
            <?php steelnova_elementor_print_icon($settings['icon']); ?>
        </div>
    <?php endif; ?>
    <div class="counter-box__content">
        <div class="counter-box__number counter">
            <?php if(!empty($settings['number_prefix'])) : ?>
                <span class="counter-box__number-prefix counter__number-prefix">
                    <?php echo esc_html($settings['number_prefix']); ?>
                </span>
            <?php endif;?>
            <span <?php echo $this->get_render_attribute_string('counter-number'); ?>>
                <?php echo esc_html($settings['ending_number'] ?: 1); ?>
            </span>
            <?php if(!empty($settings['number_suffix'])) : ?>
                <span class="counter-box__number-suffix counter__number-suffix">
                    <?php echo esc_html($settings['number_suffix']); ?>
                </span>
            <?php endif; ?> 
        </div>
        <?php if (!empty($settings['title'])) : ?>
            <<?php echo esc_attr($title_tag); ?> class="counter-box__title">
                <?php echo esc_html($settings['title']); ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
        <?php if (!empty($settings['description'])) : ?>
            <p class="counter-box__description">
                <?php echo esc_html($settings['description']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>