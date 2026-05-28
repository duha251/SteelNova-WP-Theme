<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-counter-box',
    'data-layout' => '1'
];
$wrapper_attrs = array_merge($wrapper_attrs_tmp, $wrapper_attrs);
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$this->add_render_attribute( 'counter-number', [
    'class' => 'cs-counter-box__number-value cs-counter__number',
    'data-starting_number' => $settings['starting_number'] ?: 1,
    'data-ending_number' => $settings['ending_number'] ?: 1,
]);
if( !empty($settings['number_delimiter']) ) {
    $this->add_render_attribute( 'counter-number', 'data-delimiter', $settings['number_delimiter'] );
}
$title_tag = $settings['title_tag'] ?: 'h5';
?>
<div <?php echo esc_attr( $this->get_render_attribute_string('wrapper')); ?>>
    <div class="cs-counter-box__number cs-counter">
        <?php if(!empty($settings['number_prefix'])) : ?>
            <span class="cs-counter-box__number-prefix cs-counter__number-prefix">
                <?php echo esc_html($settings['number_prefix']); ?>
            </span>
        <?php endif;?>
        <span <?php pxl_print_html( $this->get_render_attribute_string('counter-number') ); ?>>
            <?php echo esc_html($settings['ending_number'] ?: 1); ?>
        </span>
        <?php if(!empty($settings['number_suffix'])) : ?>
            <span class="cs-counter-box__number-suffix cs-counter__number-suffix">
                <?php echo esc_html($settings['number_suffix']); ?>
            </span>
        <?php endif; ?> 
    </div>
    <div class="cs-counter-box__content">
        <?php if (!empty($settings['title'])) : ?>
            <<?php echo esc_attr($title_tag); ?> class="cs-counter-box__title">
                <?php echo esc_html($settings['title']); ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
        <?php if (!empty($settings['description'])) : ?>
            <p class="cs-counter-box__description">
                <?php echo esc_html($settings['description']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>