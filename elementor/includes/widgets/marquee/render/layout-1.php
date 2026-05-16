<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}
$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-marquee',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="cs-marquee__inner<?php if((bool) $settings['pause_on_hover']) echo ' pause-on-hover'; ?>" data-direction="<?php echo esc_attr($settings['direction']); ?>">
        <?php for ($i=0; $i<2; $i++) : 
            $list_class = $i === 0 ? 'main' : 'clone';
        ?>
            <div class="cs-marquee__list <?php echo esc_attr($list_class); ?>">
                <?php foreach($settings['items'] as $item) : 
                    $link_attrs = steelnova_elementor_get_link_attributes($item['link']);
                    $item_tag = !empty($link_attrs) ? 'a' : 'div';
                ?>
                    <<?php echo esc_attr($item_tag); ?> class="cs-marquee__item cs-marquee__item--<?php echo esc_attr($item['type']); ?> elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>" <?php pxl_print_html($link_attrs); ?>>
                        <?php 
                            switch ($item['type']) {
                                case 'text' : 
                                    pxl_print_html($item['text']);
                                    break;
                                case 'icon' : {
                                    steelnova_elementor_print_icon( $item['icon'] );
                                    break;
                                }
                                case 'image' : {
                                    $img_w = $item['img_size']['width'] ?: null;
                                    $img_h = $item['img_size']['height'] ?: null;
                                    steelnova_print_image_by_size($item['img']['id'], $img_w, $img_h, []);
                                }
                                default :
                                    break;
                            } 
                        ?>
                    </<?php echo esc_attr($item_tag); ?>>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>