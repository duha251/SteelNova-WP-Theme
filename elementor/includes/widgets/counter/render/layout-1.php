<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-counter',
];
$wrapper_attrs = array_merge($wrapper_attrs_tmp, $wrapper_attrs);
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$this->add_render_attribute( 'counter-number', [
    'class' => 'cs-counter__number',
    'data-starting_number' => $settings['starting_number'] ?: 1,
    'data-ending_number' => $settings['ending_number'] ?: 1,
]);
if( !empty($settings['number_delimiter']) ) {
    $this->add_render_attribute( 'counter-number', 'data-delimiter', $settings['number_delimiter'] );
}
?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <?php if(!empty($settings['number_prefix'])) : ?>
        <span class="cs-counter__number-prefix">
            <?php echo esc_html($settings['number_prefix']); ?>
        </span>
    <?php endif;?>
    <span <?php pxl_print_html( $this->get_render_attribute_string('counter-number') ); ?>>
        <?php echo esc_html($settings['ending_number'] ?: 1); ?>
    </span>
    <?php if(!empty($settings['number_suffix'])) : ?>
        <span class="cs-counter__number-suffix">
            <?php echo esc_html($settings['number_suffix']); ?>
        </span>
    <?php endif; ?> 
</div>