<?php
$wrapper_attrs_tmp = [
    'class' => 'counter',
];
$wrapper_attrs = array_merge($wrapper_attrs_tmp, $wrapper_attrs);
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$this->add_render_attribute( 'counter-value', [
    'class' => 'counter__value',
    'data-starting_number' => $settings['starting_number'] ?: 1,
    'data-ending_number' => $settings['ending_number'] ?: 1,
]);
if( !empty($settings['number_delimiter']) ) {
    $this->add_render_attribute( 'counter-value', 'data-delimiter', $settings['number_delimiter'] );
}
?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php if(!empty($settings['number_prefix'])) : ?>
        <span class="counter__value-prefix">
            <?php echo esc_html($settings['number_prefix']); ?>
        </span>
    <?php endif;?>
    <span <?php echo $this->get_render_attribute_string('counter-value'); ?>>
        <?php echo esc_html($settings['ending_number'] ?: 1); ?>
    </span>
    <?php if(!empty($settings['number_suffix'])) : ?>
        <span class="counter__value-suffix">
            <?php echo esc_html($settings['number_suffix']); ?>
        </span>
    <?php endif; ?> 
</div>