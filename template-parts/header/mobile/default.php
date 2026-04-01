
<header id="headerMobile" class="header header-mobible" data-layout="default">
    <div class="header-logo">
        <?php echo wp_kses_post($logo_html); ?>
    </div>
    <button class="button-hamburger" data-target=".header-drawer">
        <span class="hamburger-icon">
            <span class="line line-1"></span>
            <span class="line line-2"></span>
            <span class="line line-3"></span>
        </span>
    </button>
    <div class="drawer header-drawer">
        <button class="button-close"><span class="x-icon"></span></button>
        <div class="header-logo">
            <?php echo wp_kses_post($logo_html); ?>
        </div>
        <div class="header-searchform">
            <?php mytheme()->component->get_search_form(); ?>
        </div>
        <hr class="header-divider">
        <div class="header-navigation">
            <?php  if( has_nav_menu('primary-mobile') ) {
                mytheme()->component->get_navigation_menu(['theme_location' => 'primary-mobile']);
            } elseif( has_nav_menu('primary') ) {
                mytheme()->component->get_navigation_menu();
            } else {
                mytheme()->component->get_navigation_menu(['menu' => 'empty']);
            } ?>
        </div>
    </div>
</header>

