<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if (function_exists('wp_body_open')) {
    wp_body_open();
} else {
    do_action('wp_body_open');
}
?>

<div id="wrapper" class="hfeed">
    <header id="header" role="banner">
        <?php if (has_custom_logo()) : ?>
        <div class="site-logo"><?php the_custom_logo(); ?></div>
        <?php endif; ?>
        
        <h1 id="blog-title">
            <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home">
                <?php bloginfo('name'); ?>
            </a>
        </h1>
        
        <div id="blog-description"><?php bloginfo('description'); ?></div>
    </header><!-- #header -->

    <nav id="access" role="navigation">
        <div class="skip-link screen-reader-text">
            <a href="#content" title="<?php esc_attr_e('Skip navigation to the content', 'autofocus'); ?>">
                <?php esc_html_e('Skip to content', 'autofocus'); ?>
            </a>
        </div>
        
        <?php autofocus_nav_menu(); ?>
    </nav><!-- #access -->