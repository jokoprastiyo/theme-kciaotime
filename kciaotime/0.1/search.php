<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['search'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['search'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>

        <div id="content">
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['search'] ) ) :
           get_template_part( 'post', 'slider' );
           endif; ?>
            
            <h2 class="page-title"><?php _e( 'Search Results for:', 'kciao' ); ?> <span><?php echo get_search_query(); ?></span></h2>
            
            <?php 
                $post_col = 0;
                    if (have_posts()) : while (have_posts()) : the_post();

                    $post_col++;
                        if($post_col == '1') {
                            ?><div class="post-wrap clearfix"><?php
                        }
                        get_template_part('post');
                        
                    if ( of_get_option( 'kciao_display_sidebar' ) == 1 || of_get_option( 'kciao_display_sidebar' ) == 2 ) :
                        if($post_col == '2') {
                            $post_col = 0;
                            ?></div><?php
                        }
                    endif;
                if ( of_get_option( 'kciao_display_sidebar' ) == 0 ) :
                   if ( of_get_option( 'kciao_homepage_layout' ) == 2 || of_get_option( 'kciao_homepage_layout' ) == 3 || of_get_option( 'kciao_homepage_layout' ) == 0 ) :
                        if($post_col == '2') {
                            $post_col = 0;
                            ?></div><?php
                        }
                    endif;
                        if($post_col == '3') {
                            $post_col = 0;
                            ?></div><?php
                        }
                endif;
  
                endwhile;
                
                else: ?>
                    <div class="entry">
                        <p><?php printf( __('Sorry, but nothing matched your search criteria: %s. Please try again with some different keywords.','kciao'),'<strong>'. get_search_query().'</strong>'); ?></p>
                    </div>
 
                    <div id="content-search">
                        <?php get_search_form(); ?>
                    </div>
                <?php endif;
                    
                    if($post_col == '1') {
                        ?></div><?php
                    }
                if ( of_get_option( 'kciao_display_sidebar' ) == 0 ) :
                    if($post_col == '2') {
                        ?></div><?php
                    }
                endif;
                get_template_part('navigation');
            ?>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>