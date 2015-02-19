    <div <?php post_class('post post-single clearfix'); ?> id="post-<?php the_ID(); ?>">
    
        <h2 class="title"><?php the_title(); ?></h2>
        
        <div class="postmeta-primary">
    
            <span class="fa fa-calendar"><?php echo get_the_date(); ?></span>
           &nbsp; <span class="fa fa-link"><?php the_category(', '); ?></span>
    
                <?php if(comments_open( get_the_ID() ))  {
                    ?> &nbsp; <span class="fa fa-comments"><?php comments_popup_link( __( 'No comments', 'kciao' ), __( '1 Comment', 'kciao' ), __( '% Comments', 'kciao' ) ); ?></span><?php
                }
                
                if( 'current_user' )  {
                    ?> &nbsp; <span class="fa fa-edit"><?php edit_post_link(); ?></span><?php
                } ?> 
        </div>
        
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
        
        <?php if(get_the_tags()) {
                ?><div class="postmeta-secondary"><span class="fa fa-tags"><?php the_tags('', ', ', ''); ?></span></div><?php
            }
        ?> 
        
    
    </div><!-- Post ID <?php the_ID(); ?> -->
    
    <?php 
        if(comments_open( get_the_ID() ))  {
            comments_template('', true); 
        }
    ?>