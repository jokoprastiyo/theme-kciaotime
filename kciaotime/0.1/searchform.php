<?php $search_text = empty($_GET['s']) ? __('Search', 'kciao') : get_search_query(); ?> 
<div id="search" title="<?php _e('Type and hit enter', 'kciao'); ?>">
    <form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>"> 
        <input type="text" value="<?php echo $search_text; ?>" 
            name="s" id="s"  onblur="if (this.value == '')  {this.value = '<?php echo $search_text; ?>';}"  
            onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" 
        />
    </form>
</div><!-- #search -->