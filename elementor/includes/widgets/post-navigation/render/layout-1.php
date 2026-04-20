<?php
$post_id = get_the_ID();
$prev_post = get_previous_post();
$next_post = get_next_post();

$this->add_render_attribute('prev_link', 'class', ['cs-button', 'cs-post-navigation__button', 'cs-post-navigation__button--prev']);
if( $prev_post ) {
    $this->add_render_attribute('prev_link', 'href',  get_permalink( $prev_post->ID ));
}else {
    $this->add_render_attribute('prev_link', 'class',  'cs-button--disable');
}

$this->add_render_attribute('next_link', 'class', ['cs-button', 'cs-post-navigation__button', 'cs-post-navigation__button--next']);
if( $prev_post ) {
    $this->add_render_attribute('next_link', 'href',  get_permalink( $prev_post->ID ));
}else {
    $this->add_render_attribute('next_link', 'class',  'cs-button--disable');
}
?>
<div class="cs-post-navigation">
    <a <?php echo $this->get_render_attribute_string('prev_link'); ?>> 
        <span class="cs-button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7.70699 0.292897C7.31646 -0.0976323 6.68344 -0.0976323 6.29292 0.292897L0.292876 6.29298C-0.0976124 6.68351 -0.0976382 7.31654 0.292876 7.70706L6.29292 13.7071C6.68343 14.0976 7.31647 14.0976 7.70699 13.7071C8.0975 13.3166 8.09748 12.6836 7.70699 12.2931L3.41399 8.00003H13C13.5523 8.00003 14 7.55228 14 7.00002C14 6.44773 13.5523 6.00001 13 6.00001H3.41399L7.70699 1.70698C8.0975 1.31646 8.09748 0.68343 7.70699 0.292897Z" fill="#0A1119"/>
            </svg>
        </span>
        <span class="cs-button__text">
            <?php esc_html_e( 'Previous Project', 'steelnova' ); ?>
        </span>
    </a>
    <div class="divider"></div>
    <a <?php echo $this->get_render_attribute_string('next_link'); ?>> 
        <span class="cs-button__text">
            <?php esc_html_e( 'Next Project', 'steelnova' ); ?>
        </span>
        <span class="cs-button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M6.29301 0.292897C6.68354 -0.0976323 7.31656 -0.0976323 7.70708 0.292897L13.7071 6.29298C14.0976 6.68351 14.0976 7.31654 13.7071 7.70706L7.70708 13.7071C7.31657 14.0976 6.68353 14.0976 6.29301 13.7071C5.9025 13.3166 5.90252 12.6836 6.29301 12.2931L10.586 8.00003H1.00001C0.447743 8.00003 4.08116e-05 7.55228 0 7.00002C3.22132e-08 6.44773 0.447718 6.00001 1.00001 6.00001H10.586L6.29301 1.70698C5.9025 1.31646 5.90252 0.68343 6.29301 0.292897Z" fill="#0A1119"/>
            </svg>
        </span>
    </a>
</div>