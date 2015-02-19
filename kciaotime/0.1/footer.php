<?php if ( of_get_option( 'kciao_display_footer_widget' ) == 1 ) : ?>
    <div id="footer-widgets" class="clearfix">
   
        <div class="footer-widget-box">
            <?php
                if(!dynamic_sidebar('footer-left')) {
                    dynamic_sidebar('footer-left');
                }
            ?>
        </div>
        
        <div class="footer-widget-box">
            <?php
                if(!dynamic_sidebar('footer-middle')) {
                    dynamic_sidebar('footer-middle');
                }
            ?>
        </div>
        
        <div class="footer-widget-box footer-widget-box-last">
            <?php
                if(!dynamic_sidebar('footer-right')) {
                    dynamic_sidebar('footer-right');
                }
            ?>
        </div>
        
    </div>
<?php endif; ?>

    <div id="footer">
    
        <div id="copyrights">
            
                <p>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></p>
            
        </div>
        
    </div><!-- #footer -->
    
</div><!-- #container-wrap -->

<?php wp_footer(); ?>
  
</body>
</html>