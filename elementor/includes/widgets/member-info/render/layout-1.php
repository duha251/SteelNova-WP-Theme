<?php 

if( !is_singular('member') ) {
    echo '<div class="message">'.esc_html__('This Widget only use Single Member!', 'steelnova').'</div>';
    return;
}
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$title_tag = $settings['title_tag'] ?: 'h3';
$post_id = get_the_ID();

$role = steelnova()->get_page_option('member_role', '');
$email = steelnova()->get_page_option('member_email', '');
$phone_number = steelnova()->get_page_option('member_phone_number', '');
$address = steelnova()->get_page_option('member_address', '');
$socials = steelnova()->get_page_option('member_socials', [])['social_icon'] ?? [];
?>

<div class="cs-member-info">
    <<?php echo esc_attr($title_tag); ?> class="cs-member-info__name">
        <?php echo get_the_title($post_id); ?>
    </<?php echo esc_attr($title_tag); ?>>
    <?php if( !empty( $role ) ) : ?>
        <div class="cs-member-info__role">
            <?php echo esc_html($role); ?>
        </div>
    <?php endif; ?>
    <ul class="cs-member-info__meta list">
        <?php if( !empty( $email ) ) : ?>
            <div class="divider"></div>
            <li class="list__item">
                <span class="list__item-label">
                    <?php echo esc_html( $settings['email_label'] ); ?>
                </span>
                <a class="list__item-link" href="<?php echo esc_url('mailto:'.$email); ?>">
                    <?php echo esc_html($email); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if( !empty( $phone_number ) ) : ?>
            <div class="divider"></div>
            <li class="list__item">
                <span class="list__item-label">
                    <?php echo esc_html( $settings['phone_number_label'] ); ?>
                </span>
                <a class="list__item-link" href="<?php echo esc_url('tel:'.$phone_number); ?>">
                    <?php echo esc_html($phone_number); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if( !empty( $address ) ) : ?>
            <div class="divider"></div>
            <li class="list__item">
                <span class="list__item-label">
                    <?php echo esc_html( $settings['address_label'] ); ?>
                </span>
                <span class="list__item-text">
                    <?php echo esc_html($address); ?>
                </span>
            </li>
        <?php endif; ?>
    </ul>
    <?php if( !empty( $socials ) ) : ?>
        <div class="divider"></div>
        <div class="cs-member-info__socials">
            <?php foreach( $socials as $i => $social_icon ) : 
                $social_link = $socials['social_link'][$i] ?? '#';    
            ?>
                <a href="<?php echo esc_url($social_link); ?>">
                    <?php steelnova_print_svg_content( $social_icon['url'] ?? '' ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
