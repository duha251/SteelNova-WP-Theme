<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-countdown',
];

$date = new DateTime();
$date->modify('+3 days');
$date_time = $settings['date_time'] ?? $date->format('Y-m-d H:i:s');

$day_unit = $settings['day_unit'] ?? 'Days';
$hour_unit = $settings['hour_unit'] ?? 'Hours';
$minute_unit = $settings['minute_unit'] ?? 'Minutes';
$second_unit = $settings['second_unit'] ?? 'Seconds';

$wrapper_attrs_tmp['data-time'] = $date_time;

$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>
<ul <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <li class="cs-countdown__timer days" data-unit="<?php echo esc_attr($day_unit); ?>"></li>
    <li class="cs-countdown__separator"><?php esc_html_e(':', 'steelnova'); ?></li>
    <li class="cs-countdown__timer hours" data-unit="<?php echo esc_attr($hour_unit); ?>"></li>
    <li class="cs-countdown__separator"><?php esc_html_e(':', 'steelnova'); ?></li>
    <li class="cs-countdown__timer minutes" data-unit="<?php echo esc_attr($minute_unit); ?>"></li>
    <li class="cs-countdown__separator"><?php esc_html_e(':', 'steelnova'); ?></li>
    <li class="cs-countdown__timer seconds" data-unit="<?php echo esc_attr($second_unit); ?>"></li>
</ul>