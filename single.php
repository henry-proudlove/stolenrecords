<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content" class="offset">
		<div id="primary" class="eightcol shim-right clearfix">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
				<header class="entry-header">
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					<h1 class="entry-title medium-h"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				<?php if (get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE)):
					$vid_link = get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE);
					$embed_code = wp_oembed_get($vid_link);
					echo '<div class="video">' . $embed_code . '</div>';
				endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themename' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
	
			</article><!-- #post-<?php the_ID(); ?> -->
			<nav id="nav-below" role="article">
				<h1 class="section-heading visuallyhidden"><?php _e( 'Post navigation', 'themename' ); ?></h1>
				<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'themename' ) . '</span> Previous Post' ); ?></div>
				<footer class="entry-meta">
					<?php
						$tag_list = get_the_tag_list( '', ', ' );
						if ( '' != $tag_list ) {
							echo 'TAGS: '.$tag_list;
						}
					?>
	
					<?php edit_post_link( __( 'Edit', 'themename' ), '<div class="edit-link">', '</div>' ); ?>
				</footer><!-- .entry-meta -->
				<div class="nav-next"><?php next_post_link( '%link', 'Next Post <span class="meta-nav">' . _x( '', 'Next post link', 'themename' ) . '</span>' ); ?></div>
			</nav><!-- #nav-below -->
	
			<?php //comments_template( '', true ); ?>
	
		<?php endwhile; // end of the loop. ?>
		</div><!--#primary-->
		<?php get_sidebar(); ?>
	</div><!-- #content -->
<?php get_footer(); ?>