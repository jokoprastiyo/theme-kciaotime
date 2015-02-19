<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['archives'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['archives'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>

        <div id="content">
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['archives'] ) ) :
           get_template_part( 'post', 'slider' );
           endif; ?>
            
            <h2 class="page-title"><?php
    
               // If this is a daily archive
               if (is_day()) { printf( __( 'Daily Archives: <span>%s</span>', 'kciao' ), get_the_date() ); 
                
                // If this is a monthly archive
                } elseif (is_month()) { printf( __( 'Monthly Archives: <span>%s</span>', 'kciao' ), get_the_date('F Y') );
                  
                // If this is a yearly archive
                } elseif (is_year()) { printf( __( 'Yearly Archives: <span>%s</span>', 'kciao' ), get_the_date('Y') );
                
                // If this is a general archive
                } else { _e( 'Blog Archives', 'kciao' ); } 
            ?></h2>
        
            <?php 
                $post_col = 0;
                    if (have_posts()) : while (have_posts()) : the_post();
                        
                    $post_col++;
                        if($post_col == '1') {
                            ?><div class="post-wrap clearfix"><?php
                        }
                        get_template_part('post');
                        
                        if($post_col == '2') {
                            $post_col = 0;
                            ?></div><?php
                        }
                    
                endwhile;
                
                else :
                    get_template_part('post', 'noresults');
                endif; 
                    
                    if($post_col == '1') {
                        ?></div><?php
                    } 
                
                get_template_part('navigation');
            ?>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
   
    </div><!-- #main -->
    
<?php get_footer(); ?>