<?php if (  $wp_query->max_num_pages > 1 ) { ?>

    <div class="navigation clearfix">
        
        <?php
            if(function_exists('wp_pagenavi')) {
                wp_pagenavi();
            } else {
        ?><div class="alignleft"><?php next_posts_link( __( '<span class="fa fa-chevron-left"></span> Older posts', 'kciao' ) );?></div>
        <div class="alignright"><?php previous_posts_link( __( 'Newer posts <span class"fa fa-chevron-right"></span>', 'kciao' ) );?></div><?php
        } ?> 
        
    </div><!-- .navigation -->
    
<?php } ?>