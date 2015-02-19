<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/ie.css'; ?>" type="text/css" media="screen, projection" /><![endif]-->
<?php  wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<div id="container-wrap">
  
<div id="top-widgets">
    <div id="top-social-profiles">            <?php
                if(!dynamic_sidebar('top-widget')) :
                   dynamic_sidebar('top-widget');
                endif;
            ?>
    </div>
</div>
    
    <div id="header">
        <div class="nav-menu">
            <?php wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu' => 'wp_page_menu',
        'container' => false,
        'depth' => 2,
        'fallback_cb' => 'Kciao_Menu_Walker::fallback', //Process nav menu using our custom nav walker
         'walker' => new Walker_Nav_Menu()
    ) );
            ?>
        </div>
  </div>
  
    <div id="header">
    
        <div class="branding">
        <?php if ( get_header_image() ) : ?> 
            <a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo get_header_image(); ?>" alt="<?php echo esc_attr( bloginfo('name', 'display') ); ?>" title="<?php echo esc_attr( bloginfo('name', 'display') ); ?>" /></a>
        <?php else : ?>
                <h1 class="site_title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
                <h2 class="site_description"><?php bloginfo('description'); ?></h2>
            <?php endif; ?>
        </div><!-- .branding -->
    
        <div class="header-right">
            <?php if ( of_get_option( 'kciao_heading_img' ) ) : ?>
                <div class="header-banner">
                    <a href="<?php echo of_get_option( 'kciao_heading_img_link' ); ?>">
            <?php if ( of_get_option( 'kciao_heading_img' ) ) : ?>
                <img src="<?php echo of_get_option( 'kciao_heading_img' ); ?>" alt="<?php echo get_bloginfo('name'); ?>" />
            <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
                <div id="topsearch">
                   <?php get_search_form(); ?>
                </div>
            </div>
        </div>
                <nav id="site-navigation">

<?php
      wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => ''
      ));
?>
  
                </nav>
