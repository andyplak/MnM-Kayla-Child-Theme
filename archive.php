<?php get_header(); ?>
<?php
if (is_tax()) {
	$layout = theme_get_option('portfolio','layout');
}
else {
	$layout= theme_get_option('blog','layout');
}
?>
<?php if ( $wp_query->query_vars['post_type'] == 'news' ) : ?>
    <header id="intro" class="clearfix">
        <div class="inner">
          <div class="mnm-header-image news"></div>
          <div class="mnm-header-title">
            <h1>News</h1>
          </div>
        </div>
    </header>
    <?php // @todo Breadcrumbs ?>                         
<?php else: ?>
    <?php theme_generator('custom_header',$post->ID); ?>
<?php endif; ?>
</div> <!-- End headerWrapper -->
<?php theme_generator('containerWrapper',$post->ID);?>
<div id="containerWrapp" class="clearfix">
	<div id="wt_container" class="clearfix">
    	<?php theme_generator('content',$post->ID);?>
            <?php if($layout != 'full') {
           		echo '<div id="wt_main" role="main">'; 
           		echo '<div id="wt_mainInner">';
			}?>
            <?php //theme_generator('breadcrumbs',$post->ID);?>
            <?php 
				$exclude_cats = theme_get_option('blog','exclude_categorys');
				foreach ($exclude_cats as $key => $value) {
					$exclude_cats[$key] = -$value;
				}
				if(stripos($query_string,'cat=') === false){
					query_posts($query_string."&cat=".implode(",",$exclude_cats));
				}else{
					query_posts($query_string.implode(",",$exclude_cats));
				}
				if ( $post->post_type == 'portfolio' ) {
					get_template_part('loop-portfolio','archive');
				}
				else {
					get_template_part('loop','archive');	
				}
			?>
            <?php if (function_exists("pagination")) {
				pagination();
			} ?>
            <?php if($layout != 'full') {
           		echo '</div> <!-- End wt_mainInner -->'; 
           		echo '</div> <!-- End wt_main -->'; 
			}?>
            <?php if($layout != 'full') {
				echo '<aside id="wt_sidebar">';
				get_sidebar(); 
				echo '</aside> <!-- End wt_sidebar -->'; 
        	}?>
		</div> <!-- End wt_content -->
	</div> <!-- End wt_container -->
</div> <!-- End containerWrapper -->
</div> <!-- End containerWrapp -->
<?php get_footer(); ?>