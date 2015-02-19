    <div <?php post_class('post page clearfix'); ?> id="post-<?php the_ID(); ?>">
        <h2 class="title"><?php the_title(); ?></h2>
        
        <?php if( 'current-user' )  { ?>
            <div class="postmeta-primary"><span class="fa fa-edit"><?php edit_post_link(); ?></span></div>
        <?php } ?>
        
        <div class="entry clearfix">
                
            <?php
                if(has_post_thumbnail())  {
                    the_post_thumbnail();
                }
            ?>
            
            <?php
                the_content(''); 
                wp_link_pages( array( 'before' => '<p><strong>' . __( 'Pages:', 'kciao' ) . '</strong>', 'after' => '</p>' ) );
            ?>

        </div>
        
    </div><!-- Page ID <?php the_ID(); ?> -->