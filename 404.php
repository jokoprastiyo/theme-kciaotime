<?php get_header(); ?>

    <div id="main">
    
        <?php
        $img_slide = of_get_option( 'kciao_display_slider', 'none' );
        if ( of_get_option( 'kciao_homepage_layout' ) == 1 && ( $img_slide['404'] ) ) :
        get_template_part( 'post', 'slider' );
        endif;
        if ( of_get_option( 'kciao_homepage_layout' ) == 2 && ( $img_slide['404'] ) ) :
        get_template_part( 'post', 'slider' );
        endif; ?>

        <div id="content">
        
            <?php
            if ( of_get_option( 'kciao_homepage_layout' ) == 3 && ( $img_slide['404'] ) ) :
           get_template_part( 'post', 'slider' );
           endif; ?>
            
            <div class="entry">
                <?php _e('The page you requested could not be found.','kciao'); ?>
            </div>
            
            <div id="content-search">
                <?php get_search_form(); ?>
            </div>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>