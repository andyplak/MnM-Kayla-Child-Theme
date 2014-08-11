<?php
/*
Template Name: Left Sidebar
*/
global $post;

if(is_blog()){
	return require(THEME_DIR . "/template_blog.php");
}elseif(is_front_page()){
	return require(THEME_DIR . "/front-page.php");
}
$type = get_post_meta($post->ID, '_intro_type', true);
$enable_scrollorama = get_post_meta($post->ID, '_enable_scrollorama', true);
?>
<?php get_header(); ?>
<?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full ); ?>
    <?php $ftrd_img_css = "background-image: url(".$thumbnail[0].")"; ?>
    <?php $show_thumbs = true ?>
    <header id="intro" class="clearfix">
        <div class="inner">
          <!--<div id="introType"> -->
          <div class="mnm-header-image" style="<?php echo $ftrd_img_css ?>"></div>

          <div class="mnm-header-title">
            <h1><?php echo $post->post_title; ?></h1>
          </div>

        </div>
    </header>
<?php else: ?>
    <?php theme_generator('custom_header',$post->ID); ?>
<?php endif; ?>
</div> <!-- End headerWrapper -->
<?php if ($enable_scrollorama=='true'):?>
<div id="wt_blocks" class="clearfix">
<?php endif; ?>
<?php theme_generator('containerWrapper',$post->ID);?>
<div id="containerWrapp" class="clearfix">
	<div id="wt_container" class="clearfix">
    	<?php theme_generator('content',$post->ID);?>
            <?php if( $show_thumbs ) : ?>
                <div class="mnm-breadcrumb-cont">
                    <?php theme_generator('breadcrumbs',$post->ID); ?>
                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>
            <div id="wt_main" role="main">
            <div id="wt_mainInner">
            <?php  if ($type == 'slideshow' || $type == 'disable' || $type == 'static_image' || $type == 'static_video' ){
				theme_generator('breadcrumbs',$post->ID);
			} ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                 <?php the_content(); ?>
            <?php endwhile; else: ?>
            <?php endif; ?>
            </div>  <!-- End wt_mainInner -->
            </div> <!-- End wt_main -->
            <aside id="wt_sidebar">
            <?php get_sidebar(); ?>
            </aside>  <!-- End wt_sidebar -->	
		</div> <!-- End wt_content -->
	</div> <!-- End wt_container -->
</div> <!-- End containerWrapper -->
</div> <!-- End containerWrapp -->
<?php get_footer(); ?>