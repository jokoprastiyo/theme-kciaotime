<?php
/**
 * Template Name: Sitemap
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
            
                <div class="clearfix">
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Pages', 'kciao'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_pages('title_li='); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Categories', 'kciao'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_categories('title_li='); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Archives', 'kciao'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_get_archives('type=monthly&show_post_count=0'); ?>
                        </ul>
                    </div>
                </div>
                
                <div>
                    <h2><?php _e('Posts per category', 'kciao'); ?></h2>
                    
                    <?php
			    
			            $cats = get_categories();
			            foreach ( $cats as $cat ) {
			    
			            query_posts( 'cat=' . $cat->cat_ID );
			
			        ?>
	        
	        			<h3><?php echo $cat->cat_name; ?></h3>
			        	<ul class="sitemap-list">	
	    	        	    <?php while ( have_posts() ) { the_post(); ?>
	        	    	    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	            		    <?php } wp_reset_query(); ?>
			        	</ul>
	    
	    		    <?php } ?>
                    
                </div>
                
            </div>
        
        </div><!-- #content -->
    
        <?php get_sidebar(); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>