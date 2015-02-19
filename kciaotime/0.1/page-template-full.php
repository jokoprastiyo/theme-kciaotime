<?php
/**
 * Template Name: Full Width, no sidebar(s)
*/

?>
  
<?php get_header(); ?>

    <div id="main-fullwidth">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['page'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['page'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>
            
        <?php 
            if (have_posts()) : while (have_posts()) : the_post();
                get_template_part('post', 'page');
                
                if(comments_open( get_the_ID() ))  {
                    comments_template('', true); 
                }
            endwhile;
            
            else :
                get_template_part('post', 'noresults');
            endif; 
        ?>
        
    </div><!-- #main-fullwidth -->
    
<?php get_footer(); ?>