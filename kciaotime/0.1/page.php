<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['page'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['page'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>

        <div id="content">
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['page'] ) ) :
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
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>