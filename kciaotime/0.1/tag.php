<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['tags'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['tags'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>

        <div id="content">
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['tags'] ) ) :
           get_template_part( 'post', 'slider' );
           endif; ?>
            
            <h2 class="page-title"><?php printf( __( 'Tag Archives: <span>%s</span>', 'kciao' ), single_tag_title( '', false ) );  ?></h2>
            
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