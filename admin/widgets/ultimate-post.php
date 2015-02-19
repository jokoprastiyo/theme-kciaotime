<?php
/*
Plugin Name: Ultimate Posts Widget
Plugin URI: http://wordpress.org/plugins/ultimate-posts-widget/
Description: The ultimate widget for displaying posts, custom post types or sticky posts with an array of options.
Version: 2.0.3
Author: Boston Dell-Vandenberg
Author URI: http://pomelodesign.com
Text Domain: upw
Domain Path: /languages/
License: GPLv3

Ultimate Posts Widget Plugin
Copyright (C) 2012-2014, Boston Dell-Vandenberg - boston@pomelodesign.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

  class WP_Widget_Ultimate_Posts extends WP_Widget {
 
    function WP_Widget_Ultimate_Posts() {
 
      $widget_options = array( 
        'classname' => 'widget_ultimate_posts', 
        'description' => __( 'Displays list of posts with an array of options', 'kciao' ) 
      );
 
      $control_options = array(
        'width' => 150
      );
 
      $this->WP_Widget( 
        'sticky-posts', 
        __( 'Kciao :: Ultimate Posts Widget', 'kciao' ), 
        $widget_options,
        $control_options
      );
 
      $this->alt_option_name = 'widget_ultimate_posts';
  
}
  
    function widget( $args, $instance ) {
 
      global $post;
      $current_post_id =  $post->ID;
  
      ob_start();
      extract( $args );
 
      $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
      $title_link = $instance['title_link'];
      $class = $instance['class'];
      $number = empty($instance['number']) ? -1 : $instance['number'];
      $types = empty($instance['types']) ? 'any' : explode(',', $instance['types']);
      $cats = empty($instance['cats']) ? '' : explode(',', $instance['cats']);
      $tags = empty($instance['tags']) ? '' : explode(',', $instance['tags']);
      $atcat = $instance['atcat'] ? true : false;
      $thumb_size = $instance['thumb_size'];
      $attag = $instance['attag'] ? true : false;
      $excerpt_length = $instance['excerpt_length'];
      $excerpt_readmore = $instance['excerpt_readmore'];
      $sticky = $instance['sticky'];
      $order = $instance['order'];
      $orderby = $instance['orderby'];
      $meta_key = $instance['meta_key'];
      $custom_fields = $instance['custom_fields'];
       
      // Sticky posts
      if ($sticky == 'only') {
        $sticky_query = array( 'post__in' => get_option( 'sticky_posts' ) );
      } elseif ($sticky == 'hide') {
        $sticky_query = array( 'post__not_in' => get_option( 'sticky_posts' ) );
      } else {
        $sticky_query = null;
      }
 
      // If $atcat true and in category
      if ($atcat && is_category()) {
        $cats = get_query_var('cat');
      }
 
      // If $atcat true and is single post
      if ($atcat && is_single()) {
        $cats = '';
        foreach (get_the_category() as $catt) {
          $cats .= $catt->term_id.' ';
        }
        $cats = str_replace(' ', ',', trim($cats));
      }
 
      // If $attag true and in tag
      if ($attag && is_tag()) {
        $tags = get_query_var('tag_id');
      }
 
      // If $attag true and is single post
      if ($attag && is_single()) {
        $tags = '';
        foreach (get_the_tags() as $tagg) {
          $tags .= $tagg->term_id.' ';
        }
        $tags = str_replace(' ', ',', trim($tags));
      }
 
      // Excerpt more filter
      $new_excerpt_more = create_function('$more', 'return "...";');
      add_filter('excerpt_more', $new_excerpt_more);
 
      // Excerpt length filter
      $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
      if ( $instance['excerpt_length'] > 0 ) add_filter('excerpt_length', $new_excerpt_length);
 
      if( $class ) {
        $before_widget = str_replace('class="', 'class="'. $class . ' ', $before_widget);
      }
 
      echo $before_widget;
 
      if ( $title ) {
        echo $before_title;
        if ( $title_link ) echo "<a href='$title_link'>";
        echo $title;
        if ( $title_link ) echo '</a>';
        echo $after_title;
      }
 
      $args = array(
        'posts_per_page' => $number,
        'order' => $order,
        'orderby' => $orderby,
        'category__in' => $cats,
        'tag__in' => $tags,
        'post_type' => $types
      );
 
      if ($orderby === 'meta_value') {
        $args['meta_key'] = $meta_key;
      }
 
      if (!empty($sticky_query)) {
        $args[key($sticky_query)] = reset($sticky_query);
      }
 
      $args = apply_filters('upw_wp_query_args', $args, $instance, $this->id_base);
 
      $loop = new WP_Query($args);
      ?>
   
      <div class="posts-widget">

<?php if ($loop->have_posts()) : ?>

  <ul>

  <?php while ($loop->have_posts()) : $loop->the_post(); ?>

    <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'current-post-item' : ''; ?>

    <li>
  
        <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail($instance['thumb_size']); ?>
          </a>
      <?php endif; ?>


          <?php if (get_the_title() && $instance['show_title']) : ?>
            <a class="posts-widgettitle" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <?php the_title(); ?>
            </a>
          <?php endif; ?>

      <div class="posts-widget-meta">
        <?php if ($instance['show_date']) : ?>
            <?php the_time($instance['date_format']); ?>
        <?php endif; ?>

        <?php if ($instance['show_author']) : ?>
            <span><?php _e('By', 'kciao'); ?>:</span>
            <?php the_author_posts_link(); ?>
        <?php endif; ?>

        <?php if ($instance['show_comments']) : ?>
            <?php comments_number(__('No responses', 'kciao'), __('One response', 'kciao'), __('% responses', 'kciao')); ?>
        <?php endif; ?>
      </div>

        <?php if ($instance['show_excerpt']) : ?>
          <?php
          $linkmore = '';
          if ($instance['show_readmore']) {
            $linkmore = ' <a href="'.get_permalink().'" class="posts-widget-more">'.$excerpt_readmore.'</a>';
          }
          ?>
          <div class="posts-widget-entry"><?php echo get_the_excerpt() . $linkmore; ?>
        <?php endif; ?>

        <?php if ($instance['show_content']) : ?>
          <?php the_content() ?>
        <?php endif; ?>

      <p>
        <?php
        $categories = get_the_term_list($post->ID, 'category', '', ', ');
        if ($instance['show_cats'] && $categories) :
        ?>
            <span><?php _e('Categories', 'kciao'); ?>:</span>
            <span><?php echo $categories; ?></span>
        <?php endif; ?>

        <?php
        $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
        if ($instance['show_tags'] && $tags) :
        ?>
            <span><?php _e('Tags', 'kciao'); ?>:</span>
            <span><?php echo $tags; ?></span>
        <?php endif; ?>

        <?php if ($custom_fields) {
          $custom_field_name = explode(',', $custom_fields);
          foreach ($custom_field_name as $name) { 
            $name = trim($name);
            $custom_field_values = get_post_meta($post->ID, $name, true);
            if ($custom_field_values) {
              echo '<span>';
              if (!is_array($custom_field_values)) {
                echo $custom_field_values;
              } else {
                $last_value = end($custom_field_values);
                foreach ($custom_field_values as $value) {
                  echo $value;
                  if ($value != $last_value) echo ', ';
                }
              }
              echo '</span>';
            }
          } 
        } ?>
      </p>

        </div>
  
    </li>

  <?php endwhile; ?>
  
  </ul>

<?php else : ?>

  <div class="posts-widget-entry><?php _e('No posts found.', 'kciao'); ?></div>

<?php endif; ?>

      </div>
  
      <?php
  
      // Reset the global $the_post as this query will have stomped on it
      wp_reset_postdata();
 
      echo $after_widget;
  
    }
 
    function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
 
      $instance['title'] = strip_tags( $new_instance['title'] );
      $instance['class'] = strip_tags( $new_instance['class']);
      $instance['title_link'] = strip_tags( $new_instance['title_link'] );
      $instance['number'] = strip_tags( $new_instance['number'] );
      $instance['types'] = (isset( $new_instance['types'] )) ? implode(',', (array) $new_instance['types']) : '';
      $instance['cats'] = (isset( $new_instance['cats'] )) ? implode(',', (array) $new_instance['cats']) : '';
      $instance['tags'] = (isset( $new_instance['tags'] )) ? implode(',', (array) $new_instance['tags']) : '';
      $instance['atcat'] = isset( $new_instance['atcat'] );
      $instance['attag'] = isset( $new_instance['attag'] );
      $instance['show_excerpt'] = isset( $new_instance['show_excerpt'] );
      $instance['show_content'] = isset( $new_instance['show_content'] );
      $instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] );
      $instance['show_date'] = isset( $new_instance['show_date'] );
      $instance['date_format'] = strip_tags( $new_instance['date_format'] );
      $instance['show_title'] = isset( $new_instance['show_title'] );
      $instance['show_author'] = isset( $new_instance['show_author'] );
      $instance['show_comments'] = isset( $new_instance['show_comments'] );
      $instance['thumb_size'] = strip_tags( $new_instance['thumb_size'] );
      $instance['show_readmore'] = isset( $new_instance['show_readmore']);
      $instance['excerpt_length'] = strip_tags( $new_instance['excerpt_length'] );
      $instance['excerpt_readmore'] = strip_tags( $new_instance['excerpt_readmore'] );
      $instance['sticky'] = $new_instance['sticky'];
      $instance['order'] = $new_instance['order'];
      $instance['orderby'] = $new_instance['orderby'];
      $instance['meta_key'] = $new_instance['meta_key'];
      $instance['show_cats'] = isset( $new_instance['show_cats'] );
      $instance['show_tags'] = isset( $new_instance['show_tags'] );
      $instance['custom_fields'] = strip_tags( $new_instance['custom_fields'] );
 
  
      return $instance;
 
    }
  
    function form( $instance ) {
 
      // Set default arguments
      $instance = wp_parse_args( (array) $instance, array(
        'title' => __('Ultimate Posts', 'kciao'),
        'class' => '',
        'title_link' => '' ,
        'number' => '5',
        'types' => 'post',
        'cats' => '',
        'tags' => '',
        'atcat' => false,
        'thumb_size' => 'thumbnail',
        'attag' => false,
        'excerpt_length' => 10,
        'excerpt_readmore' => __('Read more &rarr;', 'kciao'),
        'order' => 'DESC',
        'orderby' => 'date',
        'meta_key' => '',
        'sticky' => 'show',
        'show_cats' => false,
        'show_tags' => false,
        'show_title' => true,
        'show_date' => true,
        'date_format' => get_option('date_format') . ' ' . get_option('time_format'),
        'show_author' => true,
        'show_comments' => false,
        'show_excerpt' => true,
        'show_content' => false,
        'show_readmore' => true,
        'show_thumbnail' => true,
        'custom_fields' => ''
      ) );
 
      // Or use the instance
      $title  = strip_tags($instance['title']);
      $class  = strip_tags($instance['class']);
      $title_link  = strip_tags($instance['title_link']);
      $number = strip_tags($instance['number']);
      $types  = $instance['types'];
      $cats = $instance['cats'];
      $tags = $instance['tags'];
      $atcat = $instance['atcat'];
      $thumb_size = $instance['thumb_size'];
      $attag = $instance['attag'];
      $excerpt_length = strip_tags($instance['excerpt_length']);
      $excerpt_readmore = strip_tags($instance['excerpt_readmore']);
      $order = $instance['order'];
      $orderby = $instance['orderby'];
      $meta_key = $instance['meta_key'];
      $sticky = $instance['sticky'];
      $show_cats = $instance['show_cats'];
      $show_tags = $instance['show_tags'];
      $show_title = $instance['show_title'];
      $show_date = $instance['show_date'];
      $date_format = $instance['date_format'];
      $show_author = $instance['show_author'];
      $show_comments = $instance['show_comments'];
      $show_excerpt = $instance['show_excerpt'];
      $show_content = $instance['show_content'];
      $show_readmore = $instance['show_readmore'];
      $show_thumbnail = $instance['show_thumbnail'];
      $custom_fields = strip_tags($instance['custom_fields']);
 
      // Let's turn $types, $cats, and $tags into an array if they are set
      if (!empty($types)) $types = explode(',', $types);
      if (!empty($cats)) $cats = explode(',', $cats);
      if (!empty($tags)) $tags = explode(',', $tags);
 
      // Count number of post types for select box sizing
      $cpt_types = get_post_types( array( 'public' => true ), 'names' );
      if ($cpt_types) {
        foreach ($cpt_types as $cpt ) {
          $cpt_ar[] = $cpt;
        }
        $n = count($cpt_ar);
        if($n > 6) { $n = 6; }
      } else {
        $n = 3;
      }
 
      // Count number of categories for select box sizing
      $cat_list = get_categories( 'hide_empty=0' );
      if ($cat_list) {
        foreach ($cat_list as $cat) {
          $cat_ar[] = $cat;
        }
        $c = count($cat_ar);
        if($c > 6) { $c = 6; }
      } else {
        $c = 3;
      }
 
      // Count number of tags for select box sizing
      $tag_list = get_tags( 'hide_empty=0' );
      if ($tag_list) {
        foreach ($tag_list as $tag) {
          $tag_ar[] = $tag;
        }
        $t = count($tag_ar);
        if($t > 6) { $t = 6; }
      } else {
        $t = 3;
      }
 
      ?>
  
        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'kciao' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
 
        <p>
          <label for="<?php echo $this->get_field_id( 'title_link' ); ?>"><?php _e( 'Title URL', 'kciao' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title_link' ); ?>" name="<?php echo $this->get_field_name( 'title_link' ); ?>" type="text" value="<?php echo $title_link; ?>" />
        </p>
 
        <p>
          <label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'CSS class', 'kciao' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo $class; ?>" />
        </p>
  
        <p>
          <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts', 'kciao' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>" min="-1" />
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" <?php checked( (bool) $show_title, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show title', 'kciao' ); ?></label>
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" <?php checked( (bool) $show_date, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show published date', 'kciao' ); ?></label>
        </p>
 
        <p<?php if (!$show_date) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('date_format'); ?>"><?php _e( 'Date format', 'kciao' ); ?>:</label>
          <input class="widefat" type="text" id="<?php echo $this->get_field_id('date_format'); ?>" name="<?php echo $this->get_field_name('date_format'); ?>" value="<?php echo $date_format; ?>" />
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" type="checkbox" <?php checked( (bool) $show_author, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show post author', 'kciao' ); ?></label>
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_comments' ); ?>" name="<?php echo $this->get_field_name( 'show_comments' ); ?>" type="checkbox" <?php checked( (bool) $show_comments, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_comments' ); ?>"><?php _e( 'Show comments count', 'kciao' ); ?></label>
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" type="checkbox" <?php checked( (bool) $show_excerpt, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show excerpt', 'kciao' ); ?></label>
        </p>
 
        <p<?php if (!$show_excerpt) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e( 'Excerpt length (in words)', 'kciao' ); ?>:</label>
          <input class="widefat" type="number" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" value="<?php echo $excerpt_length; ?>" min="-1" />
        </p>
 
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>" type="checkbox" <?php checked( (bool) $show_content, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Show content', 'kciao' ); ?></label>
        </p>
 
        <p<?php if (!$show_excerpt && !$show_content) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('show_readmore'); ?>">
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_readmore'); ?>" name="<?php echo $this->get_field_name('show_readmore'); ?>"<?php checked( (bool) $show_readmore, true ); ?> />
          <?php _e( 'Show read more link', 'kciao' ); ?>
          </label>
        </p>
 
        <p<?php if (!$show_readmore  || (!$show_excerpt && !$show_content)) echo ' style="display:none;"'; ?>>
          <input class="widefat" type="text" id="<?php echo $this->get_field_id('excerpt_readmore'); ?>" name="<?php echo $this->get_field_name('excerpt_readmore'); ?>" value="<?php echo $excerpt_readmore; ?>" />
        </p>
 
        <?php if ( function_exists('the_post_thumbnail') && current_theme_supports( 'post-thumbnails' ) ) : ?>
 
          <?php $sizes = get_intermediate_image_sizes(); ?>
 
          <p>
            <input class="checkbox" id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" type="checkbox" <?php checked( (bool) $show_thumbnail, true ); ?> />
 
            <label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show thumbnail', 'kciao' ); ?></label>
          </p>
 
          <p<?php if (!$show_thumbnail) echo ' style="display:none;"'; ?>>
            <select id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" class="widefat">
              <?php foreach ($sizes as $size) : ?>
                <option value="<?php echo $size; ?>"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php echo $size; ?></option>
              <?php endforeach; ?>
              <option value="full"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php _e('full', 'kciao'); ?></option>
            </select>
          </p>
 
        <?php endif; ?>
 
        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_cats'); ?>" name="<?php echo $this->get_field_name('show_cats'); ?>" <?php checked( (bool) $show_cats, true ); ?> />
          <label for="<?php echo $this->get_field_id('show_cats'); ?>"> <?php _e('Show post categories', 'kciao'); ?></label>
        </p>
 
        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_tags'); ?>" name="<?php echo $this->get_field_name('show_tags'); ?>" <?php checked( (bool) $show_tags, true ); ?> />
          <label for="<?php echo $this->get_field_id('show_tags'); ?>"> <?php _e('Show post tags', 'kciao'); ?></label>
        </p>
 
        <p>
          <label for="<?php echo $this->get_field_id( 'custom_fields' ); ?>"><?php _e( 'Show custom fields (comma separated)', 'kciao' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'custom_fields' ); ?>" name="<?php echo $this->get_field_name( 'custom_fields' ); ?>" type="text" value="<?php echo $custom_fields; ?>" />
        </p>
  
        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('atcat'); ?>" name="<?php echo $this->get_field_name('atcat'); ?>" <?php checked( (bool) $atcat, true ); ?> />
          <label for="<?php echo $this->get_field_id('atcat'); ?>"> <?php _e('Show posts only from current category', 'kciao');?></label>
        </p>
 
        <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e( 'Categories', 'kciao' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('cats'); ?>[]" id="<?php echo $this->get_field_id('cats'); ?>" class="widefat" style="height: auto;" size="<?php echo $c ?>" multiple>
            <option value="" <?php if (empty($cats)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;', 'kciao') ?></option>
            <?php
            $categories = get_categories( 'hide_empty=0' );
            foreach ($categories as $category ) { ?>
              <option value="<?php echo $category->term_id; ?>" <?php if(is_array($cats) && in_array($category->term_id, $cats)) echo 'selected="selected"'; ?>><?php echo $category->cat_name;?></option>
            <?php } ?>
          </select>
        </p>
 
        <?php if ($tag_list) : ?>
          <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('attag'); ?>" name="<?php echo $this->get_field_name('attag'); ?>" <?php checked( (bool) $attag, true ); ?> />
            <label for="<?php echo $this->get_field_id('attag'); ?>"> <?php _e('Show posts only from current tag', 'kciao');?></label>
          </p>
 
          <p>
            <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e( 'Tags', 'kciao' ); ?>:</label>
            <select name="<?php echo $this->get_field_name('tags'); ?>[]" id="<?php echo $this->get_field_id('tags'); ?>" class="widefat" style="height: auto;" size="<?php echo $t ?>" multiple>
              <option value="" <?php if (empty($tags)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;', 'kciao') ?></option>
              <?php
              foreach ($tag_list as $tag) { ?>
                <option value="<?php echo $tag->term_id; ?>" <?php if (is_array($tags) && in_array($tag->term_id, $tags)) echo 'selected="selected"'; ?>><?php echo $tag->name;?></option>
              <?php } ?>
            </select>
          </p>
        <?php endif; ?>
 
        <p>
          <label for="<?php echo $this->get_field_id('types'); ?>"><?php _e( 'Post types', 'kciao' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('types'); ?>[]" id="<?php echo $this->get_field_id('types'); ?>" class="widefat" style="height: auto;" size="<?php echo $n ?>" multiple>
            <option value="" <?php if (empty($types)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;', 'kciao') ?></option>
            <?php
            $args = array( 'public' => true );
            $post_types = get_post_types( $args, 'names' );
            foreach ($post_types as $post_type ) { ?>
              <option value="<?php echo $post_type; ?>" <?php if(is_array($types) && in_array($post_type, $types)) { echo 'selected="selected"'; } ?>><?php echo $post_type;?></option>
            <?php } ?>
          </select>
        </p>
 
        <p>
          <label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e( 'Sticky posts', 'kciao' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('sticky'); ?>" id="<?php echo $this->get_field_id('sticky'); ?>" class="widefat">
            <option value="show"<?php if( $sticky === 'show') echo ' selected'; ?>><?php _e('Show All Posts', 'kciao'); ?></option>
            <option value="hide"<?php if( $sticky == 'hide') echo ' selected'; ?>><?php _e('Hide Sticky Posts', 'kciao'); ?></option>
            <option value="only"<?php if( $sticky == 'only') echo ' selected'; ?>><?php _e('Show Only Sticky Posts', 'kciao'); ?></option>
          </select>
        </p>
  
        <p>
          <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by', 'kciao'); ?>:</label>
          <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
            <option value="date"<?php if( $orderby == 'date') echo ' selected'; ?>><?php _e('Published Date', 'kciao'); ?></option>
            <option value="title"<?php if( $orderby == 'title') echo ' selected'; ?>><?php _e('Title', 'kciao'); ?></option>
            <option value="comment_count"<?php if( $orderby == 'comment_count') echo ' selected'; ?>><?php _e('Comment Count', 'kciao'); ?></option>
            <option value="rand"<?php if( $orderby == 'rand') echo ' selected'; ?>><?php _e('Random', 'kciao'); ?></option>
            <option value="meta_value"<?php if( $orderby == 'meta_value') echo ' selected'; ?>><?php _e('Custom Field', 'kciao'); ?></option>
          </select>
        </p>
 
        <p<?php if ($orderby !== 'meta_value') echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id( 'meta_key' ); ?>"><?php _e('Custom field', 'kciao'); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id('meta_key'); ?>" name="<?php echo $this->get_field_name('meta_key'); ?>" type="text" value="<?php echo $meta_key; ?>" />
        </p>
         
        <p>
          <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'kciao'); ?>:</label>
          <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
            <option value="DESC"<?php if( $order == 'DESC') echo ' selected'; ?>><?php _e('Descending', 'kciao'); ?></option>
            <option value="ASC"<?php if( $order == 'ASC') echo ' selected'; ?>><?php _e('Ascending', 'kciao'); ?></option>
          </select>
        </p>
  
      <?php
    }
 
   }
     
  add_action( 'widgets_init', 'kciao_register_ultimate_posts' );
   
  function kciao_register_ultimate_posts() {
    register_widget( 'WP_Widget_Ultimate_Posts' );
  }
