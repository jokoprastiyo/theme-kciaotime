<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

    // This gets the theme name from the stylesheet
    $themename = get_option( 'stylesheet' );
    $themename = preg_replace("/\W/", "_", strtolower($themename) );
    $optionsframework_settings = get_option( 'optionsframework' );
    $optionsframework_settings['id'] = $themename;
    update_option( 'optionsframework', $optionsframework_settings );
}
  
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
 
    // Home Page layout
    $kciao_layout = array(
        '1' => __('Three column with full width slides', 'kciao'),
        '2' => __('Two column with full width slides', 'kciao'),
        '3' => __('Two column with large slides', 'kciao')
    );
  
    // Display slider
    $kciao_slide = array(
        'home' => __('Home', 'kciao'),
        'single' => __('Single', 'kciao'),
        'page' => __('Page', 'kciao'),
        'archives' => __('Archives', 'kciao'),
        'tags' => __('Tags', 'kciao'),
        'categories' => __('Categories', 'kciao'),
        'search' => __('Search Page', 'kciao'),
        'author' => __('Author', 'kciao'),
        '404' => __('404', 'kciao')
    );
    
    // Display slider array
    $kciao_slide_array = array(
        'home' => 0,
        'single' => 0,
        'page' => 0,
        'archives' => 0,
        'tags' => 0,
        'categories' => 0,
        'search' => 0,
        'author' => 0,
        '404' => 0
    );
  
    // Sidebar layout
    $kciao_sidebar = array(
        '1' => __('Left Sidebar', 'kciao'),
        '2' => __('Right Sidebar', 'kciao'),
        '0' => __('No Sidebar', 'kciao')
    );
  
    // Pull all the categories into an array
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }

    // Pull all the pages into an array
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }
    
    // Background Defaults
    $background_defaults = array(
        'color'      => '',
        'image'      => '',
        'repeat'     => 'repeat',
        'position'   => 'top center',
        'attachment' => 'scroll'
    );
    
    // Typography Defaults
    $typography_defaults=array(
        'size' => '',
        'face' => '',
        'style' => '',
        'color' => ''
    );
    
    // The Options Array
    $options = array();
    
    $options[] = array( 'name' => __('Homepage & Slides', 'kciao'),
                        'type' 
=> 'heading'
    );

    $options[] = array( 'name' => __('Display type column design and custom slides', 'kciao'),
                        'desc' => __('Select type column design and custom slides at homepage', 'kciao'),
                        'std' => 1,
                        'id' => 'kciao_homepage_layout',
                        'type' => 'select',
                        'options' => $kciao_layout
    );
    
    $options[] = array( 'name' => __('Display the slider', 'kciao'),
                        'desc' => __('Unchecked, if there is no image, to eliminate the blank column in the area', 'kciao'),
                        'id' => 'kciao_display_flexslider',
                        'std' => 0,
                        'type' => 'checkbox'
    );
    
    $options[] = array( 'name' => __('Select page, that you want to display slider', 'kciao'),
                        'desc' => __('These slider will be display at the page selected', 'kciao'),
                        'id' => 'kciao_display_slider',
                        'std' => $kciao_slide_array,
                        'type' => 'multicheck',
                        'options' => $kciao_slide
    );
    
    $options[] = array( 'name'  => __('Post Type of Custom Slider', 'kciao'),
                        'desc'  => __('Input post type just for custom slider, separated by commas if use more than one of post type. This support post type from plugin installed. Example: ( default blog: "post", "page" )', 'kciao'),
                        'id'    => 'kciao_posttype_slide',
                        'std'   => 'page',
                        'type'  => 'text'
    );
  
    $options[] = array( 'name' => __('Do You just want to use thumbnail?', 'kciao'),
                        'desc'             => __('If you just want to display a thumbnail on a post in the home, this require resizing images. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
    );
  
    $options[] = array( 'name'  => __('Layout Options', 'kciao'),
                        'type'  => 'heading'
    );
    
    $options[] = array( 'name' => __('Do You want to use custom favicon?', 'kciao'),
                        'id' => 'kciao_display_favicon',
                        'std' => 0,
                        'type' => 'checkbox'
    );
    
    $options[] = array( 'name' => __('Favicon URL', 'kciao'),
                        'desc' => __('If You choose to use custom favicon, input here full URL or upload to the favicon.ico image', 'kciao'),
                        'id' => 'kciao_favicon',
                        'type' => 'upload',
                        'class' => 'hidden'
    );
    
    $options[] = array( 'name'  => __('Header Banner', 'kciao'),
                        'desc' => __('Input here full URL or upload to the banner image, this display at the top right on every page', 'kciao'),
                        'id'    => 'kciao_heading_img',
                        'class' => 'medium',
                        'type'  => 'upload'
    );
    
    $options[] = array( 'name'  => __('Header Banner Link', 'kciao'),
                        'desc'  => __('Input Full URL Link of image header banner.', 'kciao'),
                        'id'    => 'kciao_heading_img_link',
                        'std'   => __('http://', 'kciao'),
                        'class' => 'medium',
                        'type'  => 'textarea'
    );
    
    $options[]= array('name'=> __('Sidebar Layout', 'kciao'),
                        'desc' => __('Use this option to set the layout of the sidebar. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
    );
    
    $options[] = array( 'name' => __('Excerpt length the post in the home', 'kciao'),
                        'desc' => __('Set the excerpt length for the post in the home. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
    );
    
    $options[] = array( 'name' => __('Display text of the read more link', 'kciao'),
                        'desc' => __('Input text to display of the read more link', 'kciao'),
                        'id' => 'kciao_display_readmore_text',
                        'std' => __('Read more &raquo;', 'kciao'),
                        'type' => 'textarea'
    );
    
    $options[] = array( 'name' => __('Display Footer Widget', 'kciao'),
                        'desc'  => __('Select the checkbox to display footer widget. In this area there are three column widgets: Footer Left, Footer Middle, Footer Right.', 'kciao'),
                        'id'  => 'kciao_display_footer_widget',
                        'std'  => 0,
                        'type'  => 'checkbox'
    );
    
    $options[] = array( 'name'  => __('Footer Bottom Tagline', 'kciao'),
                        'desc'  => __('Change the tagline about your site, which will display on the bottom section of the footer. This section supports html tags if desired. The text is wrapped in a paragraph element for formatting. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type'  => 'info'
    );
  
    $options[]= array('name'=> __('Images Resize','kciao'),
                        'type'=>'heading'
    );
  
    $options[]= array('name'=> __('Kciaotime Pro Options!', 'kciao'),
                        'desc' => __('Allows you to change the size of images in posts on every page of your blog. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type'=>'info'
    );
  
    $options[] = array( 'name' => __('Tracking Code & CSS', 'kciao'),
                        'type' 
=> 'heading'
    );
  
    $options[] = array( 'name' => __('Kciaotime Pro Options!', 'kciao'),
                        'desc' => __('Add your site in Google Webmaster by attaching a tracking code, analitycs, and tagmanager. You can also add code your own scripts and css, that will added into header and footer. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
    );
    
    $options[] = array( 'name' => __('Background Color', 'kciao'),
                        'type' => 'heading'
);
  
        $options[] = array( 'name' => __('Kciaotime Pro Options!', 'kciao'),
                        'desc' => __('Allows you to change the background in each area on your blog page. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
);
    
    $options[] = array( 'name' => __('Text & Links Color', 'kciao'),
                        'type' => 'heading'
);
    
    $options[] = array( 'name' => __('Kciaotime Pro Options!', 'kciao'),
                        'desc' => __('With this option, you can change the color of text and links in almost all parts of the area of the blog, or align with the background that you change. <a href="' . esc_url( __('http://generasite.tk/', 'kciao') ) . '">Upgrade Now!</a>', 'kciao'),
                        'type' => 'info'
);
    
    return $options;
}
 
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    if ($('#kciao_display_heading:checked').val() !== undefined) {
        $('#section-kciao_heading_img').show();
    }
    
    $('#kciao_display_heading').click(function() {
          $('#section-kciao_heading_img').fadeToggle(400);
    });

    if ($('#kciao_display_favicon:checked').val() !== undefined) {
        $('#section-kciao_favicon').show();
    }
    
    $('#kciao_display_favicon').click(function() {
          $('#section-kciao_favicon').fadeToggle(400);
    });
     
    if ($('#kciao_display_footer_bottom:checked').val() !== undefined) {
        $('#section-kciao_footer_bottom_tagline').show();
    }
    
    $('#kciao_display_footer_bottom').click(function() {
          $('#section-kciao_footer_bottom_tagline').fadeToggle(400);
    });
    
});
</script>

<?php } ?>
