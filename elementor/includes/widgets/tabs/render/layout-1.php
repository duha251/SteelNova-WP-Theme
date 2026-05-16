<?php 

if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

?>

<div class="cs-tabs" data-layout="<?php echo esc_attr( $settings['layout'] ); ?>">
    <div class="cs-tabs__nav">
        <?php foreach ($settings['items'] as $key => $value) : ?>
            <button>
                <?php echo esc_html( $value['title'] ); ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div class="cs-tabs__contents">
        <?php foreach ($settings['items'] as $key => $value) : ?>
            <div class="cs-tabs__content">
                <?php steelnova_elementor_print_builder_content( $value['content'] ); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
