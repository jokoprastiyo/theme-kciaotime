<?php if( of_get_option( 'kciao_display_flexslider' ) == 1 ) : ?>
    <div class="flexslider">
        <ul class="slides">
            <?php
    $posttype = of_get_option( 'kciao_posttype_slide' );
    if ( ! of_get_option( 'kciao_posttype_slide' ) ) {
$posttype = 'page';
}
   
    $args = array( 'post_type' => array( $posttype ), 'post_per_page' => '5' );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();

    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
?>

    <li>
    
        <?php
            // If the slide has an associated URL, wrap image in an anchor element
            if ( $image[0] ) :
        ?>
        
            <a href="<?php echo $image[0]; ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail(930, 300); ?>
            </a>
            
        <?php else : ?>
            <p class="alert-message">
            No images to be displayed on the posts in this slider.
            </p>
        <?php endif; ?>
  
    </li>

        <?php endwhile; else : ?>
  
    <li>
        <p class="alert-message">Setup your slides on the admin area by using "set featured image" in the "posts or pages", we'll take care of the rest!</p>
    </li>

            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>