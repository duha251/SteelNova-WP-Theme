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
                <span class="cs-button__text">
                    <?php echo esc_html( $value['title'] ); ?>
                </span>
                <span class="cs-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M9.88902 0.460267C10.5027 -0.153422 11.4974 -0.153422 12.1111 0.460267L21.5398 9.88896C22.1535 10.5027 22.1535 11.4974 21.5398 12.1111L12.1111 21.5398C11.4975 22.1535 10.5027 22.1535 9.88902 21.5398C9.27535 20.926 9.27538 19.9314 9.88902 19.3176L16.6352 12.5715H1.57144C0.703597 12.5715 6.41326e-05 11.8679 0 11C5.06207e-08 10.1321 0.703558 9.42858 1.57144 9.42858H16.6352L9.88902 2.68239C9.27535 2.06873 9.27538 1.07396 9.88902 0.460267Z" fill="#0A1119"/>
                    </svg>
                </span>
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
