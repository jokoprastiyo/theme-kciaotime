<?php

class Kciao_Menu_Walker extends Walker_Nav_Menu {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }

    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .'>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
  
	public static function fallback( $args ) {
		$fb_output = null;
  
		extract( $args );
  
		// Show Home in the menu
		$home_class = '';
		if ( is_front_page() && !is_paged() )
			$home_class = ' class="current_page_item active"';
		$fb_output .= '<li' . $home_class . '>' . $link_before . '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . $before . '<span class="fa fa-home"></span> ' . __( 'Home', 'kciao' ) . $after . '</a>' . $link_after . '</li>';
  
		if ( current_user_can( 'manage_options' ) )
			$fb_output .= '<li><a class="fa fa-pencil" href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Add a menu', 'kciao' ) . '</a></li>';
  
		$fb_output = sprintf( $items_wrap, $menu_id, $menu_class, $fb_output );
  
		if ( ! empty( $container ) )
			$fb_output = '<' . $container . ' class="' . $container_class . '" id="' . $container_id . '">' . $fb_output . '</' . $container . '>';
		if ( $echo )
			echo $fb_output;
		else
			return $fb_output;
	}
  
}

?>
