<?php if ( of_get_option( 'kciao_homepage_layout' ) == 1 ) : ?>
  
    <div <?php post_class('post post-col-three clearfix'); ?> id="<?php the_ID(); ?>">
    
<?php else :
if ( of_get_option( 'kciao_homepage_layout' ) == 2 || of_get_option( 'kciao_homepage_layout' ) == 3 ) : ?>
  
    <div <?php post_class('post post-single clearfix'); ?> id="post-<?php the_ID(); ?>">
    
<?php else : ?>
    <div <?php post_class('post post-single clearfix'); ?> id="post-<?php the_ID(); ?>">
    
<?php endif; endif; ?>
    
        <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kciao' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        
        <div class="postmeta-primary">

            <span class="fa fa-calendar"><?php echo get_the_date(); ?></span>
            
            <?php if(comments_open( get_the_ID() ))  {
                    ?> &nbsp; <span class="fa fa-comments"><?php comments_popup_link( __( 'No comments', 'kciao' ), __( '1 Comment', 'kciao' ), __( '% Comments', 'kciao' ) ); ?></span><?php
                }
            ?> 
        </div>
        
        <div class="entry clearfix">
            
            <?php
                if(has_post_thumbnail())  {
                    ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a><?php  
                }
            ?>
            
            <p>
                <?php kciao_excerpt(); ?>
            </p>

        </div>
        
    </div><!-- Post ID <?php the_ID(); ?> -->