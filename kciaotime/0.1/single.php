<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['single'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['single'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>
  
    <?php if( of_get_option('kciao_of_display_sidebar') == 0 ) : ?>
        <div id="content">
    <?php endif; ?>
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['single'] ) ) :
           get_template_part( 'post', 'slider' );
           endif; ?>
            
            <?php 
                if (have_posts()) : while (have_posts()) : the_post();
                    get_template_part('post', 'single');
                endwhile;
                
                else :
                    get_template_part('post', 'noresults');
                endif; 
            ?>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>