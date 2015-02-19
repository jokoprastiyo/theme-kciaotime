<?php

// Set the content width
if ( ! isset( $content_width ) )
	$content_width = 975; /* pixels */
  

/*-----------------------------------------------------------------------------------*/
/* Nav Walker
/* see http://codex.wordpress.org/Function_Reference/wp_nav_menu
/*-----------------------------------------------------------------------------------*/
          // Our nav walker
          include_once get_template_directory() . '/lib/walker-menu.php';
    
/*-----------------------------------------------------------------------------------*/
/* Theme setup
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kciao_setup' ) ):

function kciao_setup() {
   
	// Enable theme translations
	load_theme_textdomain( 'kciao', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
  
              // The title tag, only works on WordPress 4.1 or later
              add_theme_support( 'title-tag' );
  
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add stylesheet for the WYSIWYG editor
	add_editor_style();
    
              // Support Woocommerce
              add_theme_support('woocommerce');
      
	// Image thumbnails
              if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support('post-thumbnails');
                           set_post_thumbnail_size(300, 300, true);
                           add_image_size('full-slides', 960, 316);
              }
	
	// Register menu
	register_nav_menus( array(
		'primary' => __('Menu Primary','kciao'),
                            'top-menu' => __('Menu Top','kciao')
	) );
              
 	// Clean up the <head>
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
   
          // Custom backgrounds support
          $defaults_bg = array(
              'default-color'            => '#F4F4F4',
              'default-image'             => get_template_directory_uri() . '/images/background.png',
              'wp-head-callback'       => 'kciao_custom_background_callback',
              'admin_head_callback'     => '',
              'admin_preview_callback' => ''
          );
          add_theme_support ( 'custom-background', $defaults_bg );
  
          // Custom header support
          $defaults_hd = array(
              'default-color'            => '#F4F4F4',
              'default-image'           => '',
              'wp-head-callback'       => '',
              'upload'                         => true,
              'admin_head_callback'     => '',
              'admin_preview_callback' => 'kciao_admin_header_img'
          );
          add_theme_support ( 'custom-header', $defaults_hd );
           		
}
endif;

add_action( 'after_setup_theme', 'kciao_setup' );
    
/*----------------------------------------------------------------------------------------*/
/* Function custom background callback 
/*----------------------------------------------------------------------------------------*/
  
function kciao_custom_background_callback() {
    // Get the background image.
    $image_bg = get_background_image();
    // If there's an image, just call the normal WordPress callback. We won't do anything here.
    if ( !empty( $image_bg ) ) {
_custom_background_cb();
    return;
    // Get the background color.
    $color_bg = get_background_color();
    // If no background color, return.
    if ( empty( $color_bg ) )
return;
    // Use 'background' instead of 'background-color'.
    $style_bg = "background: {color};";
?>
<style type="text/css">body { <?php echo trim( $style_bg ); ?> }</style>
   <?php }
}
 
/*----------------------------------------------------------------------------------------*/
/* function admin header img
/*----------------------------------------------------------------------------------------*/
  
if ( !function_exists( 'kciao_admin_header_img' ) ) :
  
function kciao_admin_header_img() { ?>
        <div id="headimg">
<?php
    $color = get_header_textcolor();
    $image = get_header_image();
    if ( $color && $color != 'blank' )
$style = 'style="color: ' . $color . '"';
else
    $style = 'style="display:none"';
?>
<h1><a id="name"<?php echo $style; ?>
onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
          <div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
        <?php if ( $image ) : ?>
      <img src="<?php echo esc_url( $image ); ?>" alt="" />
    <?php endif; ?>
  </div>
<?php }
endif;
  
/*-----------------------------------------------------------------------------------*/
/* JavaScript & CSS
/*-----------------------------------------------------------------------------------*/
function kciao_enqueue_scripts()
 {
          wp_enqueue_script('jquery');
          wp_register_script('dropdown', get_template_directory_uri() . '/lib/js/dropdown.js', array('jquery'));
          wp_enqueue_script('dropdown');
          wp_register_script('touchdown', get_template_directory_uri() . '/lib/js/touchdown.js', array('jquery'));
          wp_enqueue_script('touchdown');
          wp_register_script('script_js', get_template_directory_uri() . '/lib/js/script.js', array('jquery'), '2015', true);
          wp_enqueue_script('script_js');
          wp_register_script('flexslider', get_template_directory_uri() . '/lib/js/jquery.flexslider.js', array('jquery'));
          wp_enqueue_script('flexslider');
          wp_register_script('scripts_min', get_template_directory_uri() . '/lib/js/scripts.min.js', array('jquery'));
          wp_enqueue_script('scripts_min');
          wp_register_script('hoverIntent', get_template_directory_uri() . '/lib/js/hoverIntent.js');
          wp_enqueue_script('hoverIntent');
          
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'kciao_enqueue_scripts');

function kciao_enqueue_css() {
          wp_register_style('fontawesome', get_template_directory_uri() . '/lib/css/font-awesome.css');
          wp_enqueue_style('fontawesome');
          wp_register_style('top_menu', get_template_directory_uri() . '/top-menu.css');
          wp_enqueue_style('top_menu');
          wp_register_style('fauna-one', '//fonts.googleapis.com/css?family=Fauna+One');
          wp_enqueue_style('fauna-one');
          wp_register_style('default_css', get_template_directory_uri() . '/lib/css/defaults.css');
          wp_enqueue_style('default_css');
          wp_register_style('default_stylesheet', get_stylesheet_directory_uri() . '/style.css');
          wp_enqueue_style('default_stylesheet');
}
add_action('wp_print_styles', 'kciao_enqueue_css');

/*-----------------------------------------------------------------------------------*/
/* Display <title> tag
/*-----------------------------------------------------------------------------------*/
  
    if( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
  
    // filter function for wp_title
function kciao_filter_wp_title( $old_title, $sep, $sep_location ){
 
    // add padding to the sep
    $ssep = ' ' . $sep . ' ';
     
    // find the type of index page this is
    if( is_category() ) $insert = $ssep . __('Category','kciao');
    elseif( is_tag() ) $insert = $ssep . __('Tag','kciao');
    elseif( is_author() ) $insert = $ssep . __('Author','kciao');
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __('Archives','kciao');
    elseif( is_home() ) $insert = $ssep . get_bloginfo('description');
    else $insert = NULL;
     
    // get the page number we're on (index)
    if( get_query_var( 'paged' ) )
    $num = $ssep . __('Page ','kciao') . get_query_var( 'paged' );
     
    // get the page number we're on (multipage post)
    elseif( get_query_var( 'page' ) )
    $num = $ssep . __('Page ','kciao') . get_query_var( 'page' );
     
    // else
    else $num = NULL;
     
    // concoct and return new title
    return get_bloginfo( 'name' ) . $insert . $old_title . $num;
}

add_filter( 'wp_title', 'kciao_filter_wp_title', 10, 3 );

function kciao_rss_title($title) {
    /* need to fix our add a | blog name to wp_title */
    $ft = str_replace(' | ','',$title);
    return str_replace(get_bloginfo('name'),'',$ft);
}
add_filter('get_wp_title_rss', 'kciao_rss_title',10,1);
  
    // Adding Title for site older than WordPress 4.1
function kciao_render_title() {

	?>
	<title><?php wp_title(); ?></title>
	<?php
	}
add_action( 'wp_head', 'kciao_render_title' );
    endif;
  
/*-----------------------------------------------------------------------------------*/
/* Excerpt config
/*-----------------------------------------------------------------------------------*/
function kciao_excerptlength_themes($length) {
    return 60;
}
function kciao_excerptmore($more)
{
              $kciao_more = of_get_option( 'kciao_display_readmore_text' );
              if ( ! of_get_option( 'kciao_display_readmore_text' ) ) :
              $kciao_more = 'Read more &raquo;';
              endif;
              global $post;
	return '... <div class="readmore"><a  rel="bookmark" href="' . get_permalink($post->ID) . '">' . $kciao_more . '</a></div>';
}

function kciao_excerpt($length_callback='kciao_excerptlength_themes', $more_callback='kciao_excerptmore') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}
    
/*-----------------------------------------------------------------------------------*/
/* Append post content pagination right after post content
/*-----------------------------------------------------------------------------------*/
function kciao_post_pagination($content) {
    
    if ( is_single() ) {
        $content .= wp_link_pages( array( 'before' => '<div class="navigation clearfix">' . __( 'Pages:', 'kciao' ), 'after' => '</div>', 'echo' => 1 ) );
    }
	return $content;
}
add_filter('the_content','kciao_post_pagination', 10);
  
add_filter('use_default_gallery_style', '__return_false' ); // Remove inline style of WordPress Gallery Shortcode
  
/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/
function kciao_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'kciao_page_menu_args' );
  
/*-----------------------------------------------------------------------------------*/
/* Disable Auto Formating on Posts
/*-----------------------------------------------------------------------------------*/
function kciao_formating($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
  
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
  
	return $new_content;
}
add_filter('the_content', 'kciao_formating', 99);
  
/*-----------------------------------------------------------------------------------*/
/* Fix wp-caption width
/*-----------------------------------------------------------------------------------*/
  
add_filter( 'img_caption_shortcode', 'kciao_caption', 10, 3 );
  
function kciao_caption( $output, $attr, $content ) {
  
	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;
  
	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);
  
	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );
  
	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;
  
	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';
  
	/* Open the caption <div>. */
	$output = '<div' . $attributes .'>';
  
	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );
  
	/* Append the caption text. */
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';
  
	/* Close the caption </div>. */
	$output .= '</div>';
  
	/* Return the formatted, clean caption. */
	return $output;
}
  
/*-----------------------------------------------------------------------------------*/
/* Register widgetized area and update sidebar with default widgets
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
		'name' => __('Main Sidebar', 'kciao'),
                             'id' => 'main-sidebar',
		'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
              register_sidebar( array(
                            'name' => __('Top Widget', 'kciao'),
                            'id' => 'top-widget',
                            'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
                            'after_widget' => '</li></ul>',
                            'before_title' => '<h3 class="widgettitle">',
                            'after_title' => '</h3>',
              ));
	register_sidebar( array(
		'name' => __('Footer Left', 'kciao'),
                            'id' => 'footer-left',
		'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __('Footer Middle', 'kciao'),
                             'id' => 'footer-middle',
		'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
             register_sidebar( array(
                           'name' => __('Footer Right', 'kciao'),
                            'id' => 'footer-right',
                           'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
                           'after_widget' => '</li></ul>',
                           'before_title' => '<h3 class="widgettitle">',
                           'after_title' => '</h3>',
              ));
}
 
// Include functions
include(get_template_directory() . "/admin/widgets/social-widget.php");
include(get_template_directory() . "/admin/widgets/contact-info.php");
include(get_template_directory() . "/admin/widgets/ultimate-post.php");
  
/*-----------------------------------------------------------------------------------*/
/* Comments
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kciao_comment' ) ) :

function kciao_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        ?>
            <li <?php comment_class(); ?> class="depth-1" id="<?php comment_ID(); ?>">
                <div id="<?php comment_ID(); ?>" class="comment-body">
                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment, 32 ); ?>
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <em><?php _e( 'Your comment is awaiting moderation.', 'kciao' ); ?></em>
                            <?php endif; ?>
                                <cite class="fn"><?php echo get_comment_author_link(); ?></cite>
                    </div>
                    <div class="comment-meta commentmetadata"><a href="<?php comment_ID(); ?>"><?php comment_time( 'F j, Y g:i a' ); ?></a>
                    </div>
                        <p><?php the_comment(); ?></p>                                     <div class="reply">
                        <?php comment_replay_link( array_merge( $args, array( 'depth' => $depth, 'max-depth' => $args['max-depth'] ) ) ); ?>
                    </div>
                </div>
            </li>
        <?php
}
endif;
    
/*-----------------------------------------------------------------------------------*/
/*	Add buttons to tinyMCE
/*-----------------------------------------------------------------------------------*/		
add_action('init', 'kciao_add_button');
  
function kciao_add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'kciao_add_plugin');  
     add_filter('mce_buttons', 'kciao_register_button');  
   }  
}  
  
function kciao_register_button($buttons) {  
   array_push($buttons, "button", "list", "tabs", "accordion");  
   return $buttons;  
}  
  
function kciao_add_plugin($plugin_array) {  
   $plugin_array['button'] = get_template_directory_uri().'/admin/tinymce/customcodes.js';
   $plugin_array['list'] = get_template_directory_uri().'/admin/tinymce/customcodes.js';
   $plugin_array['tabs'] = get_template_directory_uri().'/admin/tinymce/customcodes.js';
   $plugin_array['accordion'] = get_template_directory_uri().'/admin/tinymce/customcodes.js';
   return $plugin_array;  
}
   
/*-----------------------------------------------------------------------------------*/
/* Favicon image
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kciao_favicon_img' ) ) :
  
function kciao_favicon_img() {
    if ( of_get_option( 'kciao_display_favicon' ) == 1 ) : ?>
        <link rel="shortcut icon" href="<?php echo of_get_option( 'kciao_favicon' ); ?>" type="image/x-icon" />
    <?php endif;
}
  
endif;
// Load in header blog page
add_action('wp_head', 'kciao_favicon_img');
// Load in the header admin
add_action('admin_head', 'kciao_favicon_img');
  
/*-----------------------------------------------------------------------------------*/
/* Options framework
/*-----------------------------------------------------------------------------------*/

    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/options-framework/' );
    require_once dirname( __FILE__ ) . '/admin/options-framework/options-framework.php';
 
    // Load options.php
    $optionfile = locate_template( 'options.php' );
    load_template( $optionfile );
   
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea_custom' );
}

function of_sanitize_textarea_custom($input) {
	global $allowedtags;
        $custom_allowedtags["embed"] = array(
            "src" => array(),
            "type" => array(),
            "allowfullscreen" => array(),
            "allowscriptaccess" => array(),
            "height" => array(),
            "width" => array()
        );
        $custom_allowedtags["script"] = array(
            "type" =>array(),
            "src" => array()
        );
        $custom_allowedtags["img"] = array(
            "alt" =>array(),
            "src" => array()
        );
        $custom_allowedtags["a"] = array(
            "href" =>array(),
            "title" => array()
        );
        $custom_allowedtags["iframe"] = array(
            "src" => array(),
            "height" => array(),
            "width" => array(),
            "frameborder" => array(),
            "allowfullscreen" => array()
        );
        $custom_allowedtags["object"] = array(
            "height" => array(),
            "width" => array()
        );
        $custom_allowedtags["param"] = array(
            "name" => array(),
            "value" => array()
        );
        $custom_allowedtags["noscript"] = array();
        $custom_allowedtags["style"] = array(
        "type" => array(),
        "href" => array()
        );
        $of_custom_allowedtags = array_merge($custom_allowedtags, $allowedtags);
        $output = wp_kses( $input, $custom_allowedtags);
	return $output;
}
    
   // Theme Options sidebar
add_action( 'optionsframework_after','kciao_options_display_sidebar' );

function kciao_options_display_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e('Support','kciao') ?></h3>
					<div class="inside">
                        <p><?php _e('The best way to contact me with <b>support questions</b> and <b>bug reports</b> is via the','kciao') ?> <a href="http://wordpress.org/support/"><?php _e('WordPress support forums','kciao') ?></a>.</p>
                        <p><?php _e('If you like this theme, I\'d appreciate any of the following:','kciao') ?></p>
                        <ul>
                            <li><a href="http://wordpress.org/extend/themes/kciaotime"><?php _e('Rate Kciaotime at WordPress.org','kciao') ?></a></li>
                        </ul>
					</div>
			</div>
		</div>
	</div>
<?php }
