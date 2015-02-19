<?php
/**
 * Template Name: Archives
*/

?>

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
                endwhile;
                
                else :
                    get_template_part('post', 'noresults');
                endif; 
            ?>
            
            <div class="sitemap">
            
                <div>
                    <h2><?php _e('The Last 20 Posts', 'kciao'); ?></h2>
                    
                    <ul class="sitemap-list">
                        <?php wp_get_archives('type=postbypost&limit=20&show_post_count=1'); ?>
                    </ul>
                    
                </div>
                
                <div class="clearfix">
                    
                    <div class="alignleft sitemap-col-archives">
                        <h2><?php _e('Categories', 'kciao'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_categories('title_li=&show_count=1'); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col-archives">
                        <h2><?php _e('Monthly Archives', 'kciao'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
                        </ul>
                    </div>
                </div>
                
            </div>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>